<?php

namespace App\Http\Resources;

use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ProcessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $local = App::getLocale();
        $nameField = 'name_' . $local;
        $descriptionField = 'description_' . $local;

        if(!Auth::user()){
            $data = [
                'name' => $this->$nameField,
                'description' => $this->$descriptionField,
            ];
        }else{
            $data = [
                'name_en' => $this->name_en,
                'name_ar' => $this->name_ar,
                'description_en' => $this->description_en,
                'description_ar' => $this->description_ar,
            ];
        }

        return array_merge([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => date_format($this->created_at, 'Y m-d h:i:s'),
            'media' => new MediaResource($this->whenLoaded('media')),
            'ImagePath' =>$this->whenLoaded('media',Process::PATH_IMAGE),
        ],$data);
    }
}
