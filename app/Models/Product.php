<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];

     // Relación con imágenes a través de la tabla pivote `product_images`
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'product_images', 'product_id', 'image_id')
                    ->withPivot('selected'); // Incluye el campo `selected` de la tabla pivote
    }

    // Método para obtener la imagen seleccionada (opcional)
    public function selectedImage(): ?Image
    {
        return $this->images()->wherePivot('selected', true)->first();
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
