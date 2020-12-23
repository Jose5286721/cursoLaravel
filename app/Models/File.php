<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\FileCreated;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        "name","public_url","extension"
    ];

    protected $dispatchesEvents = [
        "created" => FileCreated::class,
    ];
}
