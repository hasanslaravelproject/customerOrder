<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuCategory extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name'];

    protected $searchableFields = ['*'];

    protected $table = 'menu_categories';

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function fixedFoods()
    {
        return $this->hasMany(FixedFood::class);
    }

    public function allFood()
    {
        return $this->hasMany(Food::class);
    }
}
