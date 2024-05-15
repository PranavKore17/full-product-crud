<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby_Product_Mapping extends Model
{
    use HasFactory;
    protected $table='hobby__product__mappings';

    public function hobby(){
        return $this->hasOne('App\Models\Hobby','id','hobby_id');
    }
}
