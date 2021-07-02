<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Brand extends Model
{
    
    protected $guarded = [];

    protected $casts = [
    	'created_at' => 'datetime:Y-d-m',
    ];

    // Media One To One Polymorphic Relationship
    public function Media()
    {
        return $this->morphOne('App\Media', 'mediaable')->withDefault();
    }

    // Campaign Inverse Has One Relationship
    public function Campaign()
    {
        return $this->hasOne('App\Campaign')->withDefault();
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    // Date format Accessor on Created_at 
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('M d, Y H:i:s');    
    }
    
    // Query Scope for Current User and Order By Clause 
    public function scopeByCurrentUserAndOrderBy($query, $order)
    {
        if(Auth::user()->hasRole('owner')) {
            return $query->orderBy('updated_at', $order);
        } else {
            return $query->where('user_id', Auth::id())->orderBy('updated_at', $order);
        }
    }

    // Query Scope for Current User 
    public function scopeGetAll($query)
    {
        if(Auth::user()->hasRole('owner')) {
            return $query->orderBy('updated_at', 'desc')->get();
        } else {
            return $query->where('user_id', Auth::id())->orderBy('updated_at', 'desc')->get();
        }
    }
}
