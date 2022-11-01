<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','image'];
    
        public function products()
        {
            return $this->hasMany(Product::class);
        }
        public function getImagenAttribute()
        {
              
            // getter de la imagen de cada category
            if($this->image == null)
            {
                return 'noimg.jpg';
            }elseif(file_exists('storage/categories/' . $this->image))
             {
                return $this->image ;
             }
                
              
             
        }


}
