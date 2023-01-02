<?php

namespace Modules\Payment\Services;

use Modules\Payment\Enums\PaymentMethodType;
use Modules\Payment\Repositories\BankRepository;
use Modules\Payment\Repositories\CardRepository;
use Modules\Payment\Repositories\EwalletRepository;
use Modules\Payment\Repositories\PaymentMethodRepository;

class PaymentMethodService
{
    private $paymentMethodRepository;
    private $bankRepository;
    private $cardRepository;
    private $ewalletRepository;

    public function __construct(
        PaymentMethodRepository $paymentMethodRepository,
        BankRepository $bankRepository,
        CardRepository $cardRepository,
        EwalletRepository $ewalletRepository
    ) {
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->bankRepository = $bankRepository;
        $this->cardRepository = $cardRepository;
        $this->ewalletRepository = $ewalletRepository;
    }

    public function create(array $attributes)
    {
        $paymentMethod = $this->paymentMethodRepository->create($attributes);

        if ($paymentMethod->type->value === PaymentMethodType::BANK_TRANSFER && isset($attributes['banks'])) {
            $this->bankRepository->createMany($this->assignIndex($attributes['banks']), [
                'payment_method_id' => $paymentMethod->id
            ]);
        }

        if ($paymentMethod->type->value === PaymentMethodType::CARD && isset($attributes['cards'])) {
            $this->cardRepository->createMany($this->assignIndex($attributes['cards']), [
                'payment_method_id' => $paymentMethod->id
            ]);
        }

        if ($paymentMethod->type->value === PaymentMethodType::EWALLET_TRANSFER && isset($attributes['ewallets'])) {
            $this->ewalletRepository->createMany($this->assignIndex($attributes['ewallets']), [
                'payment_method_id' => $paymentMethod->id
            ]);
        }

        return $paymentMethod;
    }

    public function update(array $attributes, $id)
    {
        $paymentMethod = $this->paymentMethodRepository->update($attributes, $id);

        if ($paymentMethod->type->value === PaymentMethodType::BANK_TRANSFER && isset($attributes['banks'])) {
            $this->updateBanks($paymentMethod, $this->assignIndex($attributes['banks']));
        }

        if ($paymentMethod->type->value === PaymentMethodType::CARD && isset($attributes['cards'])) {
            $this->updateCards($paymentMethod, $this->assignIndex($attributes['cards']));
        }

        if ($paymentMethod->type->value === PaymentMethodType::EWALLET_TRANSFER && isset($attributes['ewallets'])) {
            $this->updateEwallets($paymentMethod, $this->assignIndex($attributes['ewallets']));
        }

        return $paymentMethod;
    }

    protected function assignIndex($items)
    {
        $index = 0;
        return array_map(function ($item) use (&$index) {
            $item['index'] = $index++;

            return $item;
        }, $items);
    }

    protected function updateBanks($paymentMethod, $banks)
    {
        $newBanks = [];
        $existedBankIds = [];
        foreach ($banks as $bank) {
            if (isset($bank['id'])) {
                $existedBankIds[] = $bank['id'];
                $this->bankRepository->update($bank, $bank['id']);
            } else {
                $newBanks[] = $bank;
            }
        }

        $paymentMethod->banks()->whereNotIn('id', $existedBankIds)
            ->delete();

        $this->bankRepository->createMany($newBanks, [
            'payment_method_id' => $paymentMethod->id
        ]);
    }

    protected function updateCards($paymentMethod, $cards)
    {
        $newCards = [];
        $existedCardIds = [];
        foreach ($cards as $card) {
            if (isset($card['id'])) {
                $existedCardIds[] = $card['id'];
                $this->cardRepository->update($card, $card['id']);
            } else {
                $newCards[] = $card;
            }
        }

        $paymentMethod->cards()->whereNotIn('id', $existedCardIds)
            ->delete();

        $this->cardRepository->createMany($newCards, [
            'payment_method_id' => $paymentMethod->id
        ]);
    }

    protected function updateEwallets($paymentMethod, $cards)
    {
        $newCards = [];
        $existedCardIds = [];
        foreach ($cards as $card) {
            if (isset($card['id'])) {
                $existedCardIds[] = $card['id'];
                $this->cardRepository->update($card, $card['id']);
            } else {
                $newCards[] = $card;
            }
        }

        $paymentMethod->ewallets()->whereNotIn('id', $existedCardIds)
            ->delete();

        $this->ewalletRepository->createMany($newCards, [
            'payment_method_id' => $paymentMethod->id
        ]);
    }
}
