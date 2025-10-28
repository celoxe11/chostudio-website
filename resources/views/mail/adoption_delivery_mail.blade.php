<p>Hi {{ $adoption->buyer_name }},</p>
<p>Your adoption files are ready!</p>
@if (Str::startsWith($fileOrLink, 'http'))
    <p>Download here: <a href="{{ $fileOrLink }}">{{ $fileOrLink }}</a></p>
@else
    <p>Download your file: <a href="{{ asset('storage/' . $fileOrLink) }}">Click here</a></p>
@endif
