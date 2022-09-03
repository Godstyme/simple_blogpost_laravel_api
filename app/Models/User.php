<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements Authenticatable
{
    use HasApiTokens,AuthenticableTrait;
    protected $table = "blog_users";
    protected $hidden = ['password','updated_at'];

    function post(){
        return $this->hasMany(Post::class,'blog_users_id');
    }
}
