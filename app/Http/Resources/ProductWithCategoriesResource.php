<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductWithCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            //'categories' => CategoryResource::collection($this->categories)
            //bu şekilde ürünlerin kategorilerinide çekiyorum
             'categories' => CategoryResource::collection($this->whenLoaded('categories'))
            //bu şekilde de eager loading ile eğer with ile categoriler çekilirse veri tabanından gösterecek

        ];
    }
}
