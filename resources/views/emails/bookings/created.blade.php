<x-mail::message>
# Booking Created

Hello, {{ $booking->user->name }}!

Your booking at **{{ $booking->hotel->title }}** has been successfully created.

**Check-in:** {{ $booking->check_in->format('d.m.Y') }}

**Check-out:** {{ $booking->check_out->format('d.m.Y') }}

**Amount due:** ${{ number_format($booking->total_price, 2) }}

To confirm your booking, please go to the My Bookings section and complete the payment.

Thank you,<br>
{{ config('app.name') }}
</x-mail::message>