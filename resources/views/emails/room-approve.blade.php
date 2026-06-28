@extends('emails.layout', ['title' => 'Listing Approved'])

@section('content')
    <div style="text-align: center; margin-bottom: 30px;">
        <span class="badge badge-success">Live Now</span>
    </div>

    <h2>बधाई हो, {{ $ownerName }}!</h2>
    <p>हमें यह बताते हुए खुशी हो रही है कि आपकी रूम लिस्टिंग <strong>"{{ $roomTitle }}"</strong> को हमारे एडमिन द्वारा अप्रूव कर दिया गया है।</p>
    
    <div style="background-color: #f8fafc; border-radius: 12px; padding: 20px; margin: 30px 0; border: 1px solid #e2e8f0;">
        <table width="100%">
            <tr>
                <td width="100%">
                    <h4 style="margin: 0; color: #1e3a8a;">{{ $roomTitle }}</h4>
                    <p style="margin: 5px 0; font-size: 14px;">{{ $roomAddress }}</p>
                    <p style="margin: 5px 0; font-weight: 700; color: #059669;">₹{{ number_format($roomPrice) }} / Month</p>
                </td>
            </tr>
        </table>
    </div>

    <p>आपका रूम अब यूज़र्स के लिए सर्च में उपलब्ध है। आपको जल्द ही इंक्वायरी मिलने शुरू हो सकती हैं।</p>
    
    <div style="text-align: center;">
        <a href="{{ config('app.url') }}/owner/rooms" class="btn">View My Listings</a>
    </div>

    <p style="font-size: 14px; color: #718096; margin-top: 40px; text-align: center;">
        Good luck with your rental! Team RoomRental.
    </p>
@endsection