<?php

namespace Modules\Payment\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Repositories\PaymentRepository;
use Modules\Payment\Services\PaymentService;

class CancelExpiredPayment implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function handle(
        PaymentService $paymentService,
        PaymentRepository $paymentRepository
    )
    {
        DB::transaction(function () use ($paymentService, $paymentRepository) {
            $payment = $paymentRepository->lockForUpdate()
                ->find($this->payment->id);

            if ($payment->status->value != PaymentStatus::PENDING) {
                return;
            }

            $paymentService->cancel($payment);
        });
    }

    public function uniqueId()
    {
        return $this->payment->id;
    }
}
