<?php

namespace App\Models;

use App\Http\Trait\Statusable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory, Statusable;

    public const PATH_IMAGE = '/assets/Service/';
    public const DISK_NAME = 'service';
    protected $guarded = [];

    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

}
