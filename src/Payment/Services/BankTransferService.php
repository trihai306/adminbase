<?php

namespace Modules\Payment\Services;

use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\BankTransfer;
use Modules\Payment\Enums\BankTransferStatus;
use Modules\Payment\Enums\CardExchangeStatus;
use Modules\Payment\Repositories\BankTransferRepository;
use Modules\Payment\Repositories\PaymentRepository;

class BankTransferService
{
    private $bankTransferRepository;
    private $paymentRepository;
    private $paymentService;

    public function __construct(
        BankTransferRepository $bankTransferRepository,
        PaymentRepository $paymentRepository,
        PaymentService $paymentService
    )
    {
        $this->bankTransferRepository = $bankTransferRepository;
        $this->paymentRepository = $paymentRepository;
        $this->paymentService = $paymentService;
    }

    public function accept(BankTransfer $bankTransfer)
    {
        return DB::transaction(function () use ($bankTransfer) {
            $payment = $this->paymentRepository->find($bankTransfer->payment_id);

            $this->bankTransferRepository->update([
                'status' => BankTransferStatus::COMPLETED
            ], $bankTransfer->id);

            $this->paymentService->complete($payment, $bankTransfer->id);
        });
    }

    public function deny(BankTransfer $bankTransfer, $feedback)
    {
        return DB::transaction(function () use ($bankTransfer, $feedback) {
            $payment = $this->paymentRepository->find($bankTransfer->payment_id);

            $this->bankTransferRepository->update([
                'feedback' => $feedback,
                'status' => CardExchangeStatus::FAILED
            ], $bankTransfer->id);

            $this->paymentService->complete($payment, $bankTransfer->id);
        });
    }

    public function callback($data)
    {
        return DB::transaction(function () use ($data) {
            $template = '/MK\s*(?<id>\d+)/i';
            if(!preg_match($template, $data['content'], $matches)) {
                throw new \Exception('Nội dung không hợp lệ.');
            }

            $bankTransfer = $this->bankTransferRepository
                ->lockForUpdate()
                ->findByPaymentId($matches['id']);

            if (!$bankTransfer || $bankTransfer->status->value != BankTransferStatus::PENDING) {
                throw new \Exception('Giao dịch không tồn tại hoặc đã hoàn thành.');
            }

            if ($bankTransfer->amount != $data['amount']) {
                throw new \Exception('Số tiền giao dịch không khớp.');
            }

            $payment = $this->paymentRepository
                ->lockForUpdate()
                ->find($bankTransfer->payment_id);

            $bankTransfer = $this->bankTransferRepository->update([
                'ref' => $data['ref'],
                'status' => BankTransferStatus::COMPLETED
            ], $bankTransfer->id);

            $this->paymentService->complete($payment, $bankTransfer->id);

            return $bankTransfer;
        });
    }
}
