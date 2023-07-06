<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function sekolah(){
        return $this->belongsTo(Sekolah::class);
    }

    public function log(){
        return $this->hasMany(Log::class);
    }

    private static function parseDataToArray($datas){
        $return = [];

        foreach ($datas as $key => $data) {
            array_push($return, $data->id);
        }

        return $return;
    }

    public function scopeFilterUser($query, array $filter){
        $query->when($filter['search'] ?? false, function($query, $filter){
            return $query->where('users.name', 'like', '%' . $filter . '%')
                        ->orWhere('users.email', 'like', '%' . $filter . '%')
                        ->orWhere('users.nip', 'like', '%' . $filter . '%');
        });
    }

    public static function getUser($role, $detail = false, $paginate = false, $filter = ['search' => '']){
        $users = User::filterUser($filter)
                        ->role($role) 
                        ->where('users.sekolah_id', \Auth::user()->sekolah_id);

        if ($paginate) {
            $users = $users->paginate(25)->withQueryString();
        } else {
            $users = $users->get();
        }
                
        return $users;
    }

    public static function findUser($role, $id){
        $user = User::role($role) 
                        ->where('users.sekolah_id', \Auth::user()->sekolah_id)
                        ->first();

        return $user;
    }
}
