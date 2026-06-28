@extends('emails.layout', ['title' => 'Action Required'])

@section('content')
    <div style="text-align: center; margin-bottom: 30px;">
        <span class="badge badge-error">Action Required</span>
    </div>

    <h2>नमस्ते, {{ $ownerName }}</h2>
    <p>आपकी रूम लिस्टिंग <strong>"{{ $roomTitle }}"</strong> की समीक्षा की गई है, और इसे लाइव करने के लिए कुछ बदलावों की आवश्यकता है।</p>
    
    <div style="background-color: #fff5f5; border-left: 4px solid #f56565; padding: 20px; margin: 30px 0;">
        <h4 style="margin: 0 0 10px 0; color: #c53030;">रिजेक्शन के कारण:</h4>
        <ul style="margin: 0; padding-left: 20px; color: #4a5568;">
            @foreach($reasons as $reason)
                <li>{{ $reason }}</li>
            @endforeach
        </ul>
    </div>

    <p>कृपया ऊपर दिए गए कारणों को ठीक करें और अपनी लिस्टिंग को दोबारा सबमिट करें। हमारे एडमिन इसे फिर से चेक करेंगे।</p>
    
    <div style="text-align: center;">
        <a href="{{ config('app.url') }}/owner/rooms" class="btn" style="background-color: #f56565;">Edit Listing</a>
    </div>

    <p style="font-size: 14px; color: #718096; margin-top: 40px; text-align: center;">
        अगर आपको कोई सवाल है, तो कृपया हमारी सपोर्ट टीम से संपर्क करें।
    </p>
@endsection