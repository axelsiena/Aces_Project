<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Category;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory, Searchable, SoftDeletes;

    protected $fillable = [
        'title', 'category_id','user_id','price','description','is_accepted', 'revisioned_by_user_id',
    ];

    public function toSearchableArray()
    {
        $category = $this->category;
        $array = [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $category,
        ];
        return $array;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // funzione per ottenere gli user a cui piace tal annuncio

    public function favBy()
    {
        return $this->belongsToMany(User::class, 'user_favourite_ad');
    }

    public function setAccepted($value)
    {
        $this->is_accepted = $value;
        $this-> save();
        return true;
    }

    public function toBeRevisionedCount()
    {
        return Ad::where('is_accepted', null)->count();
    }

    public function images()
    {
        return $this -> hasMany(Image::class);
    }
}
