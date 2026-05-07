<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'father_husband_name',
        'cnic',
        'email',
        'phone',
        'address',
        'nominee',
        'is_active'
    ];

    public function customerPlotFiles()
    {
        return $this->hasMany(CustomerPlotFile::class, 'customer_id');
    }
}
