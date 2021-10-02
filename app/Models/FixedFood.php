<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FixedFood extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'menu_category_id',
        'divnumber',
        'unit_id',
        'image',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'fixed_foods';

    public function menuCategory()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
