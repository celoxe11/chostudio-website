<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adoption extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'adoptions';
    protected $primaryKey = 'adoption_id';

    protected $fillable = [
        'gallery_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'price',
        'buyer_message',
        'delivery_notes',
        'order_status',
        'payment_status',
        'confirmed_at',
        'paid_at',
        'delivered_at',
        'completed_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'paid_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * relationship to Gallery model
     */
    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'gallery_id');
    }

    /**
     * Scope to filter by order status
     * Intinya: mendapatkan semua adoption dengan order_status tertentu
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('order_status', $status);
    }

    /**
     * Scope to filter by payment status
     * Intinya: mendapatkan semua adoption dengan status pembayaran tertentu
     */
    public function scopePaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    /**
     * Scope to get pending orders
     * Intinya: mendapatkan semua adoption dengan status 'pending'
     */
    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    /**
     * Scope to get confirmed orders
     * Intinya: mendapatkan semua adoption dengan status 'confirmed'
     */
    public function scopeConfirmed($query)
    {
        return $query->where('order_status', 'confirmed');
    }

    /**
     * Scope to get orders by buyer email
     * Intinya: mendapatkan semua adoption dengan email pembeli tertentu
     */
    public function scopeByEmail($query, $email)
    {
        return $query->where('buyer_email', $email);
    }

    /**
     * Check if order can be cancelled
     * Intinya: memeriksa apakah status pesanan memungkinkan untuk dibatalkan
     */
    public function canBeCancelled()
    {
        return in_array($this->order_status, ['pending', 'confirmed']);
    }

    /**
     * Check if payment can be confirmed
     * Intinya: memeriksa apakah status pesanan memungkinkan untuk konfirmasi pembayaran
     */
    public function canConfirmPayment()
    {
        return $this->order_status === 'confirmed' && $this->payment_status === 'unpaid';
    }

    /**
     * Check if files can be uploaded/delivered
     * Intinya: memeriksa apakah status pesanan memungkinkan untuk pengiriman file
     */
    public function canDeliver()
    {
        return $this->order_status === 'processing' && $this->payment_status === 'paid';
    }

    /**
     * Confirm the order
     * Intinya: mengonfirmasi pesanan oleh artis
     */
    public function confirm()
    {
        $this->update([
            'order_status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // Mark gallery as reserved when order is confirmed
        $this->gallery->update(['status' => 'reserved']);
    }

    /**
     * Confirm payment
     * Intinya: method untuk mengkonfirmasi pembayaran oleh artis
     */
    public function confirmPayment()
    {
        $this->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'order_status' => 'processing',
        ]);
    }

    /**
     * Mark as delivered
     * Intinya: mengupdate pesanan sebagai telah dikirim
     */
    public function markDelivered()
    {
        $this->update([
            'order_status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    /**
     * Mark as completed
     * Intinya: mengupdate pesanan sebagai telah selesai
     */
    public function markCompleted()
    {
        $this->update([
            'order_status' => 'completed',
            'completed_at' => now(),
        ]);

        // Update gallery status to sold
        $this->gallery->update(['status' => 'sold']);
    }

    /**
     * Cancel the order
     * Intinya: membatalkan pesanan 
     */
    public function cancel()
    {
        $this->update([
            'order_status' => 'cancelled',
        ]);

        // Return gallery to available if order is cancelled
        $this->gallery->update(['status' => 'available']);
    }

}
