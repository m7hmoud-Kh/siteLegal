<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public const PATH_IMAGE = '/assets/Setting/';
    public const DISK_NAME = 'setting';

    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }

}
