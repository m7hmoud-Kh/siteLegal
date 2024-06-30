<?php

namespace App\Models;

use App\Http\Trait\Statusable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory, Statusable;
    public const PATH_IMAGE = '/assets/Client/';
    public const DISK_NAME = 'client';
    protected $guarded = [];

    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }
}
