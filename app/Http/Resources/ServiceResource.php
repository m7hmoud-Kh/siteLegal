<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ServiceResource extends JsonResource
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
                'id' => $this->id,
                'name' => $this->$nameField,
                'description' => $this->$descriptionField,
                'status' => $this->status
            ];
        }else{
            $data = [
                'id' => $this->id,
                'name_en' => $this->name_en,
                'name_ar' => $this->name_ar,
                'description_en' => $this->description_en,
                'description_ar' => $this->description_ar,
                'status' => $this->status
            ];
        }
        return $data;
    }
}
