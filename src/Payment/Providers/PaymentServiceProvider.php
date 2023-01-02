<?php

namespace Modules\Payment\Providers;

use Illuminate\Database\Eloquent\Factory;
use Modules\Core\Providers\ModuleServiceProvider;
use Modules\Payment\Repositories\BankRepository;
use Modules\Payment\Repositories\BankTransferRepository;
use Modules\Payment\Repositories\CardExchangeRepository;
use Modules\Payment\Repositories\CardRepository;
use Modules\Payment\Repositories\EloquentBankRepository;
use Modules\Payment\Repositories\EloquentBankTransferRepository;
use Modules\Payment\Repositories\EloquentCardExchangeRepository;
use Modules\Payment\Repositories\EloquentCardRepository;
use Modules\Payment\Repositories\EloquentEwalletRepository;
use Modules\Payment\Repositories\EloquentEwalletTransferRepository;
use Modules\Payment\Repositories\EloquentPaymentRepository;
use Modules\Payment\Repositories\EloquentPaymentMethodRepository;
use Modules\Payment\Repositories\EwalletRepository;
use Modules\Payment\Repositories\EwalletTransferRepository;
use Modules\Payment\Repositories\PaymentMethodRepository;
use Modules\Payment\Repositories\PaymentRepository;

class PaymentServiceProvider extends ModuleServiceProvider
{
    protected $moduleName = 'Payment';

    protected $moduleNameLower = 'payment';

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->bind(PaymentRepository::class, EloquentPaymentRepository::class);
        $this->app->bind(PaymentMethodRepository::class, EloquentPaymentMethodRepository::class);
        $this->app->bind(BankRepository::class, EloquentBankRepository::class);
        $this->app->bind(CardRepository::class, EloquentCardRepository::class);
        $this->app->bind(CardExchangeRepository::class, EloquentCardExchangeRepository::class);
        $this->app->bind(BankTransferRepository::class, EloquentBankTransferRepository::class);
        $this->app->bind(EwalletRepository::class, EloquentEwalletRepository::class);
        $this->app->bind(EwalletTransferRepository::class, EloquentEwalletTransferRepository::class);
    }

    protected function registerConfig()
    {
        parent::registerConfig();

        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/payments.php'), 'payments'
        );
    }
}
