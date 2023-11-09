<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=>$this->id,
            "model"=>$this->name,
            "year"=>$this->year,
            "phone"=>$this->phone,
            "whatsapp"=>$this->whatsapp,
            "location"=>$this->location,
            "title"=>$this->title,
            'description'=>$this->description,
            'body_type'=>$this->body_type,
            'mileage'=>$this->mileage,
            'transmission'=>$this->transmission,
            'fuel'=>$this->fuel,
            'color'=>$this->color,
            'tags'=>$this->tags,
            'price'=>$this->price,
            'doors'=>$this->doors,
            'cylinders'=>$this->cylinders,
            'owner'=>$this->user->name,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'image'=>"public/images/cars/$this->image",
        ];
    }
}
