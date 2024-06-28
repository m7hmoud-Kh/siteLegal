<?php

namespace App\Models;

use App\Http\Trait\Statusable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, Statusable;

    public const PATH_IMAGE = '/assets/Blog/';
    public const DISK_NAME = 'blog';
    protected $guarded = [];

    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }
}
