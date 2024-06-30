<?php

namespace App\Http\Resources;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientReousrce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'name' => $this->name,
            'created_at' => date_format($this->created_at, 'Y m-d h:i:s'),
            'media' => new MediaResource($this->whenLoaded('media')),
            'ImagePath' =>$this->whenLoaded('media',Client::PATH_IMAGE),
        ];
    }
}
