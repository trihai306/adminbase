<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Catalog\Entities\Voucher;
use Modules\Media\Casts\MediaFile;
use Modules\User\Enums\UserGender;
use Modules\User\Enums\UserStatus;
use Spatie\Permission\Traits\HasRoles;

class User extends \App\Models\User
{
    use HasFactory;
    use HasApiTokens;
    use HasRoles;

    protected $fillable = [
        'avatar',
        'username',
        'password',
        'full_name',
        'email',
        'phone',
        'birthday',
        'gender',
        'address',
        'points',
        'is_admin',
        'status'
    ];

    protected $casts = [
        'avatar' => MediaFile::class,
        'birthday' => 'date',
        'gender' => UserGender::class,
        'points' => 'integer',
        'is_admin' => 'boolean',
        'status' => UserStatus::class
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->wallet()->create();
        });
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar;
    }

    public function getRankAttribute()
    {
        $ranks = [
            'bronze' => 0,
            'silver' => 1000,
            'gold' => 5000,
            'diamond' => 10000
        ];

        arsort($ranks);

        foreach ($ranks as $name => $points) {
            if ($this->points >= $points) {
                return $name;
            }
        }
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function scopeSearch(Builder $builder, $keyword): Builder
    {
        return $builder->where(function ($query) use ($keyword) {
            return $query->where('username', 'like', "%$keyword%")
                ->orWhere('full_name', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%")
                ->orWhere('phone', 'like', "%$keyword%");
        });
    }

    public function role_ids()
    {
        return $this->roles()->select('id');
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class)
            ->withDefault(['balance' => 0]);
    }

    public function identifyProviders()
    {
        return $this->belongsToMany(IdentifyProvider::class, 'identify_provider_connection');
    }

    public function guardName()
    {
        return ['sanctum'];
    }

    public function receivesBroadcastNotificationsOn()
    {
        return [
            "admin.$this->id.notifications",
            "shop.$this->id.notifications",
        ];
    }

    protected static function newFactory(): \Modules\User\Database\factories\UserFactory
    {
        return \Modules\User\Database\factories\UserFactory::new();
    }

    public function vouchers(){
        return $this->belongsToMany(Voucher::class, 'user_voucher', 'user_id', 'voucher_id');

    }
}
