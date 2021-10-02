<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['company_id', 'menu_category_id', 'image'];

    protected $searchableFields = ['*'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function menuCategory()
    {
        return $this->belongsTo(MenuCategory::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
