<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public function cart() {
        return $this->hasMany(cart::class);
    }
}
