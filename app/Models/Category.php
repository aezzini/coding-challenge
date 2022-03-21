<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'parent_category_id',
    ];

    public function child()
    {
        return $this->belongsTo(Category::class, 'child_category_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }

}
