<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Product extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'slug', 'description', 'price'];
    //protected $hidden = ['slug'];
    //slug kolonunu gizledik.

    public function categories() {
        return $this->belongsToMany('App\Category', 'product_categories');
    }
}
