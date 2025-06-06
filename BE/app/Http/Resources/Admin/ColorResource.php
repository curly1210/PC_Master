<?php
namespace App\Http\Resources\Admin;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'code'      => $this->code,
            // 'is_active' => $this->is_active,
            // 'created_at'=> $this->created_at,
            // 'updated_at'=> $this->updated_at,
        ];
    }
}
