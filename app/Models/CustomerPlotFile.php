<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPlotFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'project_plot_id',
        'file_no',
        'booked_by',
        'total_cost',
        'discount',
        'paid_amount',
        'remaining_amount',
        'booking_date',
        'status',
        'payment_status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function projectPlot()
    {
        return $this->belongsTo(ProjectPlot::class, 'project_plot_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scope for eager loading relationships
    public function scopeWithRelations($query)
    {
        return $query->with('customer:id,name,cnic', 
                           'projectPlot:id,block,plot_no');
    }

    // Scope for latest records
    public function scopeLatestRecords($query)
    {
        return $query->latest();
    }

    // Scope for payment creation (combines common conditions)
    public function scopeForPaymentCreation($query)
    {
        return $query->where('payment_status', '!=' , 'paid')->withRelations()->latestRecords();
    }
}
