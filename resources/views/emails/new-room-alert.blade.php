@extends('emails.layout', ['title' => 'New Room Available!'])

@section('content')
    <div style="text-align: center; margin-bottom: 30px;">
        <span class="badge badge-success">New Listing Found</span>
    </div>

    <h2>गुड न्यूज़!</h2>
    <p>आपके द्वारा सब्सक्राइब किए गए शहर <strong>{{ $city }}</strong> में एक नया रूम उपलब्ध है जो आपकी पसंद का हो सकता है।</p>
    
    <div style="background-color: #f8fafc; border-radius: 12px; padding: 20px; margin: 30px 0; border: 1px solid #e2e8f0; text-align: left;">
        <h3 style="margin: 0; color: #1e3a8a;">{{ $room->title }}</h3>
        <p style="margin: 10px 0; font-size: 14px; color: #4a5568;">🚩 {{ $room->address }}</p>
        <p style="margin: 10px 0; font-size: 18px; font-weight: 700; color: #059669;">Price: ₹{{ number_format($room->rent) }} / month</p>
        <p style="margin: 0; font-size: 13px; color: #718096;">🏠 Type: {{ ucfirst($room->room_type) }} | Furnishing: {{ ucfirst($room->furnishing_type) }}</p>
    </div>

    <p>यह कमरा काफी अच्छी लोकेशन पर है और जल्दी बुक हो सकता है। डिटेल्स देखने के लिए नीचे दिए गए बटन पर क्लिक करें।</p>
    
    <div style="text-align: center;">
        <a href="{{ config('app.url') }}/rooms/{{ $room->id }}" class="btn">View Room Details</a>
    </div>

    <p style="font-size: 13px; color: #a0aec0; margin-top: 40px; text-align: center; border-top: 1px solid #edf2f7; padding-top: 20px;">
        आपने <strong>{{ $city }}</strong> के लिए अलर्ट चालू किया था, इसलिए आपको यह ईमेल मिला है। <br>
        अलर्ट बंद करने के लिए <a href="{{ config('app.url') }}/dashboard" style="color: #4a5568;">यहाँ क्लिक करें</a>।
    </p>
@endsection
