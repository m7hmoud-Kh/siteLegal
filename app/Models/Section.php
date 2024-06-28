<?php

namespace App\Models;

use App\Http\Trait\Statusable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory,Statusable;

    public const PATH_IMAGE = '/assets/Section/';
    public const DISK_NAME = 'section';
    protected $guarded = [];

    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
