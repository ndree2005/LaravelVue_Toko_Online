<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Product;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * booted() — lifecycle hook yang didaftarkan saat class pertama dipakai.
     * creating → dipanggil SEBELUM insert baru ke database.
     * updating → dipanggil SEBELUM update ke database.
     */
    protected static function booted(): void
    {
        // Generate slug dari nama saat CREATE
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // Perbarui slug saat nama diubah (UPDATE)
        static::updating(function (Category $category) {
            $category->slug = Str::slug($category->name);
        });
    }

    // Relasi ke produk — Many-to-Many (pivot: category_product)
    // Akan dipakai di P5 saat membangun fitur produk

    //public function products()
    //{
    //    return $this->belongsToMany(Product::class);
    //}
}
