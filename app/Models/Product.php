<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','barcode','cost','price','stock','alerts','image','category_id'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function getImagenAttribute()
    {
          
        // getter de la imagen de cada category
        if($this->image == null)
        {
            return 'noimg.jpg';
        }elseif(file_exists('storage/products/' . $this->image))
         {
            return $this->image ;
         }
    }
    
}
