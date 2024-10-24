<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable; 
use Illuminate\Auth\Authenticatable as UserAuthenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Admin extends Model implements Authenticatable
{
    use HasFactory, UserAuthenticatable;

    protected $fillable = ['id', 'name', 'email', 'password'];

    // UUIDの設定
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    // パスワードのハッシュ化
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }
}
