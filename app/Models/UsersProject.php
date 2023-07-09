<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersProject extends Model
{
    Protected $table='project_users';
    //Protected $fillable = ['email', 'password', 'password2'];
    Public $timestamps = true; 
}