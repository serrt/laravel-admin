<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'display_name' => $this->display_name,
            'text' => $this->display_name,
            'pid' => $this->pid,
        ];
        return $data;
    }

    public function with($request)
    {
        return ['code' => Response::HTTP_OK, 'message' => ''];
    }
}
