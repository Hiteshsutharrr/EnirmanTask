<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IfscCode extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
            'ifsc_code',
            'name',
            'city',
            'state',
            'pincode',
            'phone_number',
            'address',
        ];
}
