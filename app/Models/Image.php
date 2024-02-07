<?php

namespace App\Models;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path','ad_id','labels'];

    protected $casts = [
        'labels' => 'array',
    ];

    public function ad(){
        return $this->belongsTo(Ad::class);
    }

     public static function getUrlByFilePath($filePath, $w , $h){
        if(!$w && !$h){
            return Storage::url($filePath);
        }

        $path = dirname($filePath);
        $filename = basename($filePath);
        $file = "{$path}/crop_{$w}x{$h}_{$filename}";

        return Storage::url($file);

     }

     public function getUrl($w , $h){
         return Image::getUrlByFilePath($this->path, $w, $h);
     }
}
    