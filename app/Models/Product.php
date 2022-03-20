<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;


    /**
     * The product categories.
     */
    protected $categories;

    /**
     * The product attributes.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'categories',
    ];

    /**
     * Get product categories
     */
    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'product_categories',
            'product_id',
            'category_id'
        );
    }

    /**
     * Get product categories
     */
    public function setCategoriesAttribute($value)
    {
        $this->categories()->sync(explode(",",$value));
        unset($this->attributes['categories']);
    }

    /**
     * Set Product Image
     */
    public function setImageAttribute($value, $upload = true)
    {
        if(!$upload){
            $this->attributes['image'] = $value;
        }
        else{
            if ($this->image) {
                Storage::delete(env('APP_UPLOAD_PATH', 'uploads') . DIRECTORY_SEPARATOR . $this->image);
            }
            $this->attributes['image'] = basename(Storage::put(env('APP_UPLOAD_PATH', 'uploads'), $value));
        }
    }

    /**
     * Catch product events
     */
    public static function boot()
    {
        parent::boot();
        self::deleting(function ($product) {

            if ($image = $product->image) {
                Storage::delete(env('APP_UPLOAD_PATH', 'uploads') . DIRECTORY_SEPARATOR . $image);
            }

            if ($product->categories()) {
                $product->categories()->detach();
            }

            Log::info('Product Deleting Event:' . $product);
        });
    }
}
