<?php

namespace App\Models;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','title_en','title_it','title_es'
    ];


    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        return $this->attributes['title_' . $locale] ?? $this->attributes['title_en']; 
    }
}
