<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = [
        'type',
        'customer_id',
        'estimate_id',
        'lead_id',
        'assigned_to',
        'source',
        'payment_status',
        'website',       
        'invoice_generated',
        'voucher_generated',
        'mail_sent',
        'date',
        'time',
        'vendor_id',
        'image'
    ];

    public $timestamps = true;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'booking_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'booking_id');
    }

    public function credit()
    {
        return $this->hasOne(CreditNote::class, 'booking_id');
    }

    public function reason()
    {
        return $this->hasOne(BookingCancel::class, 'booking_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function deleteduser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function cab()
    {
        return $this->hasOne(BookingCab::class, 'booking_id');
    }

    public function cabs()
    {
        return $this->hasMany(BookingCab::class, 'booking_id');
    }

    public function hotel()
    {
        return $this->hasOne(BookingHotel::class, 'booking_id');
    }

    public function hotels()
    {
        return $this->hasMany(BookingHotel::class, 'booking_id');
    }

    public function safari()
    {
        return $this->hasOne(BookingSafari::class, 'booking_id');
    }

    public function safaris()
    {
        return $this->hasMany(BookingSafari::class, 'booking_id');
    }

    public function items()
    {
        return $this->hasMany(BookingItem::class, 'booking_id');
    }

    public function customer_details()
    {
        return $this->hasMany(BookingSafariCustomer::class, 'booking_id');
    }

    public function permits()
    {
        return $this->hasMany(BookingSafariPermit::class, 'booking_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'booking_id');
    }
    public function refundtransactions()
    {
        return $this->hasMany(RefundTransaction::class, 'booking_id');
    }
    public function reminders()
    {
        return $this->hasMany(BookingReminder::class, 'booking_id');
    }

    public function destinations()
    {
        return $this->hasMany(BookingHotelDestination::class, 'booking_id');
    }
     public function Cancel()
    {
        return $this->hasOne(BookingCancel::class, 'booking_id');
    }

    public function inclusions()
    {
        return $this->hasMany(BookingInclusion::class, 'booking_id');
    }

    public function exclusions()
    {
        return $this->hasMany(BookingExclusion::class, 'booking_id');
    }

    public function halts()
    {
        return $this->hasMany(BookingCabHalt::class, 'booking_id');
    }

    public function terms()
    {
        return $this->hasMany(BookingTerm::class, 'booking_id');
    }

    public function cancellationRequest()
    {
        return $this->hasOne(BookingCancellationRequest::class, 'booking_id');
    }
    public function refund_history(){

        return $this->hasMany(RefundHistory::class, 'booking_id')->latest();

    }
}
