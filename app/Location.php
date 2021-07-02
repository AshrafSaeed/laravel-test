<?php
namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Location extends Model
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

    // Campaign Has One Relationship
    public function Campaign()
    {
        return $this->hasOne('App\Campaign')->withDefault();
    }
    
    public function User()
    {
    	return $this->belongsTo('App\User');
    }

    // Query Scope for Current User 
    public function scopeGetAll($query)
    {
        if(Auth::user()->hasRole('owner')) {
            return $query->orderBy('updated_at', 'desc')->paginate(5);
        } else {
            return $query->where('user_id', Auth::id())->orderBy('updated_at', 'desc')->paginate(5);
        }
    }
}
