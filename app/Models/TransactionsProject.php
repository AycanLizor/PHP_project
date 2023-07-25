<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionsProject extends Model
{
    Protected $table='project_transactions';
    Public $timestamps = false; 
    Protected $primaryKey = 'transaction_id';
    public $incrementing = false;
}