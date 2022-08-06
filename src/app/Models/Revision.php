<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    const UPDATED_AT = null;
    protected $table = 'revision';
    protected $fillable = [
        'id',
        'table_name',
        'column_name',
        'ref_id',
        'user_id',
        'old',
        'new',
        'created_at',
    ];
}
