<?php

namespace Modules\Payment\Services\Payment;

use Illuminate\Support\Manager;

class PaymentManager extends Manager
{
    public function createBalanceDriver()
    {
        return $this->container->make(BalancePaymentHandler::class);
    }

    public function createBankTransferDriver()
    {
        return $this->container->make(BankTransferPaymentHandler::class);
    }

    public function createEwalletTransferDriver()
    {
        return $this->container->make(EwalletTransferPaymentHandler::class);
    }

    public function createCardDriver()
    {
        return $this->container->make(CardPaymentHandler::class);
    }

    public function getDefaultDriver()
    {
        return 'balance';
    }
}
