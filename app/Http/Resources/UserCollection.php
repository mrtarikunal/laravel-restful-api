<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\UserResource';
    // burda collection olarak kullanacağı resource dosyasını tanımlıyrz
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'data' => $this->collection,
          'meta' => [
              'total_users' => $this->collection->count(),
              'custom' => 'value'
          ]
        ];
    }
    //burda collection olarak dönen değere data haricinde meta diye bir dizi daha ekledik
}
