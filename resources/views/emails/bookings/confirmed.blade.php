<x-mail::message>
# Booking Confirmed

Hello, {{ $booking->user->name }}!

Thank you for your payment. Your booking at **{{ $booking->hotel->title }}** has been successfully confirmed.

**Room:** {{ $booking->room->title }}

**Check-in:** {{ $booking->check_in->format('d.m.Y') }}

**Check-out:** {{ $booking->check_out->format('d.m.Y') }}

**Guests:** {{ $booking->guests }}

**Amount paid:** ${{ number_format($booking->total_price, 2) }}

We look forward to welcoming you on **{{ $booking->check_in->format('d.m.Y') }}**.

When you arrive at the hotel, please visit the reception desk to complete your check-in.

Thank you for choosing us. We wish you a pleasant stay!

Regards,<br>
{{ config('app.name') }}
</x-mail::message>