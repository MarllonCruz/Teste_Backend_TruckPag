<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['logradouro', 'numero', 'bairro', 'cidade_id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function cidade()
    {
        return $this->belongsTo(City::class);
    }
}