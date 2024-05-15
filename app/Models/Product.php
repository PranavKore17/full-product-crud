<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='products';

    protected $fillable = [
        
        'name',
        'description',
        'from_date',
        'to_date',
        
    ];

    public function countries(){

        return $this->hasOne('App\Models\Country','id','country_id');
    }
    public function states(){

        return $this->hasOne('App\Models\State','id','state_id');
    }
    public function cities(){

        return $this->hasOne('App\Models\City','id','city_id');
    }
    public function hobby_mapping(){

        return $this->hasMany('App\Models\Hobby_Product_Mapping','product_id','id')->with('hobby');
    }

}
