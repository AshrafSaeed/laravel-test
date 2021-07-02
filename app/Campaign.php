<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Campaign extends Model
{
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:Y-d-m',
    ];

     // Date format Accessor on Created_at 
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('M d, Y H:i:s');    
    }

    // Brand  Inverce Has One Relationship
    public function Brand()
    {
    	return $this->belongsTo('App\Brand');
    }

    // Location Inverce Has One Relationship
    public function Location()
    {
    	return $this->belongsTo('App\Location');
    }

    // User Inverce Has One Relationship
    public function User()
    {
        return $this->belongsTo('App\User');
    }

    // Media One To One Polymorphic Relationship
    public function Media()
    {
        return $this->morphOne('App\Media', 'mediaable')->withDefault();
    }

    // Get Compaign data
    public function scopeGetAllCampaign($query)
    {
        if(Auth::user()->hasRole('owner')) {
            return $query->orderBy('updated_at', 'desc')->paginate(5);
        } else {
            return $query->where('user_id', Auth::id())->orderBy('updated_at', 'desc')->paginate(5);
        }

    }

}
