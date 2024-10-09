<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'title', 'content', 'image'];

    protected $keyType = 'string';
    public $incrementing = false; 

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_categories', 'blog_id', 'category_id');
    }
}
