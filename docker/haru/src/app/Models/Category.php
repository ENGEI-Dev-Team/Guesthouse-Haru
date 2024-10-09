<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'name'];

    protected $keyType = 'string';
    public $incrementing = false; 

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_categories', 'category_id', 'blog_id');
    }
}
