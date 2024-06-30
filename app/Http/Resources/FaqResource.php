<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class FaqResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $local = App::getLocale();
        $nameField = 'question_' . $local;
        $descriptionField = 'answer_' . $local;

        if(!Auth::user()){
            $data = [
                'question' => $this->$nameField,
                'answer' => $this->$descriptionField,
            ];
        }else{
            $data = [
                'question_en' => $this->question_en,
                'question_ar' => $this->question_ar,
                'answer_en' => $this->answer_en,
                'answer_ar' => $this->answer_ar,
            ];
        }

        return array_merge([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => date_format($this->created_at, 'Y m-d h:i:s'),
        ],$data);
    }
}
