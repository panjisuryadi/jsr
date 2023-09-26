<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\Permission\Traits\HasRoles;
use Modules\UserCabang\Models\UserCabang;
use Modules\Company\Models\Company;
use Auth;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public const USERCODE = 'U';
    protected $fillable = [
        'name',
        'email',
        'kode_user',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['media'];


    public function scopeAkses($query)
    {

     $users = Auth::user()->id;
     if ($users == 1) {
            return $query;
        }
        return $query->whereHas('namacabang', function($query) {
               $query->where('cabang_id', Auth::user()->namacabang->cabang()->first()->id);
            });
    }

     public function namacabang()
        {
            return $this->hasOne(UserCabang::class);
        }

      public function company() {
            return $this->hasMany(Company::class, 'id', 'user_id');
        }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')
            ->useFallbackUrl('https://www.gravatar.com/avatar/' . md5($this->attributes['email']));
    }

     public static function generateCode()
        {
            $dateCode = self::USERCODE . '-';
            $lastOrder = self::select([\DB::raw('MAX(users.kode_user) AS last_code')])
                ->where('kode_user', 'like', $dateCode . '%')
                ->first();
            $lastOrderCode = !empty($lastOrder) ? $lastOrder['last_code'] : null;
            $orderCode = $dateCode . '00001';
            if ($lastOrderCode) {
                $lastOrderNumber = str_replace($dateCode, '', $lastOrderCode);
                $nextOrderNumber = sprintf('%05d', (int)$lastOrderNumber + 1);
                $orderCode = $dateCode . $nextOrderNumber;
            }

            return $orderCode;
        }

    public function scopeIsActive(Builder $builder) {
        return $builder->where('is_active', 1);
    }
}
