<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersProject extends Model
{
    Protected $table='users_project';
    //Protected $fillable = ['email', 'password', 'password2'];
    protected $primaryKey = 'user_id'; // Add this line
    Public $timestamps = true; 
}