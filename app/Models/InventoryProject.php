<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryProject extends Model
{
    Protected $table='project_inventory';
    Public $timestamps = false; 
    Protected $primaryKey = 'inventory_id';
    public $incrementing = false;
}