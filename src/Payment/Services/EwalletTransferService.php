<?php

namespace Modules\Payment\Services;

use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\EwalletTransfer;
use Modules\Payment\Enums\CardExchangeStatus;
use Modules\Payment\Enums\EwalletTransferStatus;
use Modules\Payment\Repositories\EwalletTransferRepository;
use Modules\Payment\Repositories\PaymentRepository;

class EwalletTransferService
{
    private $ewalletTransferRepository;
    private $paymentRepository;
    private $paymentService;

    public function __construct(
        EwalletTransferRepository $ewalletTransferRepository,
        PaymentRepository $paymentRepository,
        PaymentService $paymentService
    )
    {
        $this->ewalletTransferRepository = $ewalletTransferRepository;
        $this->paymentRepository = $paymentRepository;
        $this->paymentService = $paymentService;
    }

    public function accept(EwalletTransfer $ewalletTransfer)
    {
        return DB::transaction(function () use ($ewalletTransfer) {
            $payment = $this->paymentRepository->find($ewalletTransfer->payment_id);

            $this->ewalletTransferRepository->update([
                'status' => EwalletTransferStatus::COMPLETED
            ], $ewalletTransfer->id);

            $this->paymentService->complete($payment, $ewalletTransfer->id);
        });
    }

    public function deny(EwalletTransfer $ewalletTransfer, $feedback)
    {
        return DB::transaction(function () use ($ewalletTransfer, $feedback) {
            $payment = $this->paymentRepository->find($ewalletTransfer->payment_id);

            $this->ewalletTransferRepository->update([
                'feedback' => $feedback,
                'status' => CardExchangeStatus::FAILED
            ], $ewalletTransfer->id);

            $this->paymentService->complete($payment, $ewalletTransfer->id);
        });
    }

    public function callback($data)
    {
        $ewalletTransfer = $this->ewalletTransferRepository->find($data['ewallet_transfer_id']);

        return DB::transaction(function () use ($ewalletTransfer) {
            $payment = $this->paymentRepository->find($ewalletTransfer->payment_id);

            $this->ewalletTransferRepository->update([
                'status' => EwalletTransferStatus::COMPLETED
            ], $ewalletTransfer->id);

            $this->paymentService->complete($payment, $ewalletTransfer->id);
        });
    }
}
