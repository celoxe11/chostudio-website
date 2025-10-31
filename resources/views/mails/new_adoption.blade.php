<h1>New Adoption Submission!</h1>

<p>A new adoption has been submitted for the artwork:</p>
<ul>
    {{-- Menggunakan relasi untuk mendapatkan info galeri --}}
    <li><strong>Artwork Title:</strong> {{ $adoption->gallery->title }}</li> 
    <li><strong>Price:</strong> Rp {{ number_format($adoption->gallery->price, 0, ',', '.') }}</li>
</ul>

<p>Buyer Details:</p>
<ul>
    <li><strong>Adoption ID:</strong> {{ $adoption->adoption_id }}</li>
    <li><strong>Email:</strong> {{ $adoption->email }}</li>
    <li><strong>Payment Status:</strong> {{ $adoption->payment_status }}</li>
</ul>