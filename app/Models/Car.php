<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable=[
            "model",
            "year",
            "phone",
            "whatsapp",
            "title",
            "description",
            "location",
            "body_type",
            'mileage',
            "transmission",
            "fuel",
            "color",
            "tags",
            "price",
            'doors',
            'cylinders',
            'image',
            'user_id',

    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
