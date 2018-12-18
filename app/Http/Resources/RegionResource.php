<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
            'pid' => $this->pid,
            'name' => $this->name,
            'code' => $this->code,
            'level' => $this->level,
        ];
    }

    public function with($request)
    {
        return ['code' => Response::HTTP_OK, 'message' => ''];
    }
}
