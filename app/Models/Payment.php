<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_plot_file_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_id',
        'remarks'
    ];

    public function customerPlotFile()
    {
        return $this->belongsTo(CustomerPlotFile::class, 'customer_plot_file_id');
    }


    public function scopeWithRelations($query)
    {
        return $query->with('customerPlotFile.customer:id,name,cnic', 
                           'customerPlotFile.projectPlot:id,block,plot_no');
    }

    // Scope for latest records
    public function scopeLatestPayments($query)
    {
        return $query->latest();
    }
}
