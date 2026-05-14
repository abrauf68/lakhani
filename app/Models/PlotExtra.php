<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlotExtra extends Model
{
    use HasFactory;

    protected $table = 'plot_extras';

    protected $fillable = [
        'project_plot_id',
        'key',
        'value',
    ];
}
