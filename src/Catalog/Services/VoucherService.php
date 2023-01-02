<?php

namespace Modules\Catalog\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Modules\Catalog\Enums\HistoryPointStatus;
use Modules\Catalog\Enums\HistoryPointType;
use Modules\Catalog\Repositories\HistoryPointRepository;
use Modules\Catalog\Repositories\VoucherRepository;
use Modules\User\Repositories\WalletRepository;
use Modules\User\Services\AuthenticationService;

class VoucherService
{
    private $voucherRepository;
    private $historyPointRepository;
    private $walletRepository;
    private $authenticationService;

    public function __construct(
        VoucherRepository      $voucherRepository,
        WalletRepository       $walletRepository,
        HistoryPointRepository $historyPointRepository,
        AuthenticationService  $authenticationService

    )
    {
        $this->voucherRepository = $voucherRepository;
        $this->walletRepository = $walletRepository;
        $this->historyPointRepository = $historyPointRepository;
        $this->authenticationService = $authenticationService;
    }

    public function create(array $attributes)
    {

        return DB::transaction(function () use ($attributes) {

            $voucher = $this->voucherRepository->create([
                "code" => $attributes['code'],
                "name" => $attributes['name'],
                "title" => $attributes['title'] ?? null,
                "max_money" => $attributes['max_money'],
                "discount" => $attributes['discount'],
                "expire_day" => $attributes['expire_day'],
                "quality" => $attributes['quality'],
                "point" => $attributes['point'],
                'options'=>$attributes['options'],
                "description" => $attributes['description'] ?? null,
                "type" => $attributes['type'],
                "start_at" => $attributes['dateRange'][0] ?? null,
                "end_at" => $attributes['dateRange'][1] ?? null,
            ]);
            if (isset($attributes['variant_ids'])) {
                $voucher->variants()->attach($attributes['variant_ids']);
            }
            if (isset($attributes['product_ids'])) {
                $voucher->products()->attach($attributes['product_ids']);
            }
            if (isset($attributes['user_ids'])) {
                $voucher->users()->attach($attributes['user_ids'], ['expire_at' => Carbon::now()->addDays($attributes['expire_day'])]);
            }
            return $voucher;
        });
    }

    public function update(array $attributes, $id)
    {
        if (isset($attributes['dateRange'])) {
            $attributes['start_at'] = $attributes['dateRange'][0];
            $attributes['end_at'] = $attributes['dateRange'][1];
        }
        $data = Arr::except($attributes, ['variant_ids', 'user_ids', 'dateRange','product_ids']);


        $voucher = $this->voucherRepository->update(
            $data,
            $id
        );
        if (isset($attributes['variant_ids'])) {
            $voucher->variants()->sync($attributes['variant_ids']);
            $voucher->products()->detach();
        }
        if (isset($attributes['product_ids'])) {
            $voucher->products()->sync($attributes['product_ids']);
            $voucher->variants()->detach();

        }
        if (isset($attributes['user_ids'])) {
            $voucher->users()->sync($attributes['user_ids'], ['expire_at' => Carbon::now()->addDays($attributes['expire_day'])]);
        }
        return $voucher;
    }

    public function byVoucher($id)
    {
        return DB::transaction(function () use ($id) {
            if (empty($voucher = $this->voucherRepository->lockForUpdate()->find($id))) {
                throw new Exception('id không tồn tại');
            }
            if($voucher->quality < 1){
                throw new Exception('Voucher hết hàng');
            }
            $userId = $this->authenticationService->currentUser()->id;
            $userWallet = $this->walletRepository->lockForUpdate()->findByUserId($userId);
            if ($userWallet->points - $voucher->point < 0) {
                throw new Exception('points không đủ');
            }
            $userWallet->points = $userWallet->points - $voucher->point;
            $voucher->quality = $voucher->quality - 1;
            $voucher->save();
            $expire_day = $voucher->expire_day;
            $userWallet->save();
            $history = $this->historyPointRepository->create([
                'voucher_id' => $id,
                'user_id' => $userId,
                'order_id' => 0,
                'point' => $voucher->point,
                'status' => HistoryPointStatus::ACTIVATED,
                'type' => HistoryPointType::VOUCHER,
                'note' => "Đổi voucher $voucher->name"
            ]);
            $voucher->users()->attach($userId, ['expire_at' => Carbon::now()->addDays($expire_day)]);
            return $history;
        });
    }
}
