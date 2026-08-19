<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmedMail;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function pay(Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === auth()->id(), 404);

        if ($booking->status === 'cancelled') {
            return back()->withErrors([
                'payment' => 'Cancelled booking cannot be paid.',
            ]);
        }

        if ($booking->payment_status === 'paid') {
            return back()->with(
                'info',
                'This booking is already paid.'
            );
        }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'status' => 'confirmed',
            ]);
        });

        $booking->refresh();
        $booking->load(['user', 'hotel', 'room']);

        Mail::to($booking->user->email)
            ->send(new BookingConfirmedMail($booking));

        return back()->with(
            'success',
            'Test payment completed. Booking confirmed.'
        );
    }
}