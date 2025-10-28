<div
    style="background: #efeae4; border: 2px solid black; max-width: 520px; margin: 32px auto; font-family: 'Segoe UI', 'Arial', sans-serif; box-shadow: 0 2px 12px #a2e1db33;">
    <div
        style="background: linear-gradient(90deg, #a2e1db 0%, #7dc8c1 100%); border-radius: 16px 16px 0 0; padding: 32px 32px 16px 32px; text-align: center;">
        <img src="{{ asset('assets/cho_asset/Talking cho.png') }}" alt="CHO Studio Logo"
            style="height: 48px; margin-bottom: 12px;">
        <h2 style="font-size: 2rem; font-weight: bold; color: black; margin-bottom: 8px;">Your Adoption Files Are
            Ready!</h2>
        <p style="font-size: 1.1rem; color: #333; margin-bottom: 0;">Hi <span
                style="color: black; font-weight: bold;">{{ $adoption->buyer_name }}</span>,</p>
    </div>
    <div style="padding: 24px 32px 32px 32px;">
        <p style="font-size: 1.1rem; color: #444; margin-bottom: 18px; text-align: center;">Thank you for your adoption! Your files are now
            available for download below.</p>
        @if (Str::startsWith($fileOrLink, 'http'))
            <div
                style="background: #a2e1db22; border-radius: 12px; padding: 18px; text-align: center; margin-bottom: 18px; border: 1px solid #a2e1db;">
                <span style="font-size: 1.1rem; color: #7dc8c1; font-weight: 600;">Download Link:</span><br>
                <a href="{{ $fileOrLink }}"
                    style="display: inline-block; margin: 8px; padding: 10px 24px; background: #7dc8c1; color: #fff; font-weight: bold; border-radius: 8px; text-decoration: none; box-shadow: 0 1px 4px #a2e1db66;">Download
                    File</a>
                <br><span style="font-size: 0.95rem; color: #888;">If you have trouble accessing the link, please reply
                    to this email.</span>
            </div>
        @else
            <div
                style="background: #a2e1db22; border-radius: 12px; padding: 18px; text-align: center; margin-bottom: 18px; border: 1px solid #a2e1db;">
                <span style="font-size: 1.1rem; color: #7dc8c1; font-weight: 600;">Download Your File:</span><br>
                <a href="{{ asset($fileOrLink) }}"
                    style="display: inline-block; margin-top: 8px; padding: 10px 24px; background: #7dc8c1; color: #fff; font-weight: bold; border-radius: 8px; text-decoration: none; box-shadow: 0 1px 4px #a2e1db66;">Download
                    File</a>
                <br><span style="font-size: 0.95rem; color: black;">If you have trouble accessing the file, please reply
                    to this email.</span>
            </div>
        @endif
        <div style="margin-top: 24px; text-align: center;">
            <p style="font-size: 1rem; color: black;">If you have any questions or need help, just reply to this
                email.<br>Thank you for supporting our artists!</p>
            <hr style="margin: 18px 0; border: none; border-top: 1px solid black;">
            <p style="font-size: 0.95rem; color: black;">&copy; {{ date('Y') }} CHO Studio</p>
        </div>
    </div>
</div>
