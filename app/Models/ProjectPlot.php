<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPlot extends Model
{
    use HasFactory;

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function customerPlotFiles()
    {
        return $this->hasMany(CustomerPlotFile::class, 'project_plot_id');
    }
}
