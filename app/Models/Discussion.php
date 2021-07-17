<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function scopeFilter($query, $filter, array $searchTable){
        return $query->where($searchTable['content'],'like','%'.$filter.'%')
        ->orWhere($searchTable['title'],'like','%'.$filter.'%');
    }
}
