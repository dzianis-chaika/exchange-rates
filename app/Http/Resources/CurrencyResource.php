<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'valuteID' => $this->valuteID,
            'numCode' => $this->numCode,
            'charCode' => $this->charCode,
            'name' => $this->name,
            'value' => $this->value,
            'date' => $this->date->format('d.m.Y'),
        ];
    }
}
