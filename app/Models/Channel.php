<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function discussions(){
        return $this->hasMany(Discussion::class);
    }
}
