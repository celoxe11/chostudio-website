<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ChoStudio Adoption Notification</title>
    <style>
        body {
            font-family: 'Poppins', 'Arial', sans-serif;
            background: #f9f6f1;
            color: #2c2c2c;
            margin: 0;
            padding: 0;
            line-height: 1.7;
        }
        .container {
            max-width: 640px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            border: 1px solid #eee5d8;
        }
        .header {
            background: linear-gradient(135deg, #f7d89c, #f0ad4e);
            color: #2c2c2c;
            text-align: center;
            padding: 30px 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .section {
            padding: 25px 30px;
            border-bottom: 1px solid #f4f0ea;
        }
        .section h2 {
            color: #f0ad4e;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .section p {
            margin: 0 0 12px;
            color: #444;
        }
        .details-list {
            list-style: none;
            padding: 0;
            margin: 10px 0 0;
        }
        .details-list li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #e9e2d6;
            font-size: 15px;
        }
        .details-list .label {
            color: #7a6c5f;
            font-weight: 600;
        }
        .details-list .value {
            color: #333;
            text-align: right;
        }
        .highlight {
            color: #f0ad4e;
            font-weight: 700;
        }
        .footer {
            background: #faf7f2;
            text-align: center;
            padding: 20px 15px;
            color: #8c857a;
            font-size: 13px;
        }
        .footer p {
            margin: 0;
        }
        .artwork-box {
            background: #fff8ec;
            border: 1px solid #f5d9a7;
            border-radius: 8px;
            padding: 15px 20px;
            margin-top: 10px;
        }
        .cta {
            text-align: center;
            margin-top: 20px;
        }
        .cta a {
            display: inline-block;
            background: #f0ad4e;
            color: #fff;
            padding: 12px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
        }
        .cta a:hover {
            background: #e79d3e;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <h1>🧡 New Adoption Submission Received!</h1>
        </div>

        <!-- INTRO -->
        <div class="section">
            <p>Hai <strong>Admin ChoStudio</strong>,</p>
            <p>Ada pengajuan adopsi baru yang masuk ke sistem. Berikut detail lengkapnya:</p>
        </div>

        <!-- ARTWORK DETAILS -->
        <div class="section">
            <h2>Artwork Details</h2>
            <div class="artwork-box">
                <ul class="details-list">
                    <li><span class="label">Gallery ID:</span> <span class="value">#{{ $adoption->gallery->gallery_id ?? $adoption->gallery_id }}</span></li>
                    <li><span class="label">Title:</span> <span class="value">{{ $adoption->gallery->title ?? '-' }}</span></li>
                    <li><span class="label">Price:</span> <span class="value highlight">Rp {{ number_format($adoption->price ?? ($adoption->gallery->price ?? 0), 0, ',', '.') }}</span></li>
                </ul>
            </div>
        </div>

        <!-- TRANSACTION INFO -->
        <div class="section">
            <h2>Transaction Info</h2>
            <ul class="details-list">
                <li><span class="label">Adoption ID:</span> <span class="value">#{{ $adoption->adoption_id ?? '-' }}</span></li>
                <li><span class="label">Your Email:</span> <span class="value">{{ $adoption->email ?? '-' }}</span></li>
                <li><span class="label">Order Status:</span> <span class="value highlight">{{ strtoupper($adoption->order_status ?? '-') }}</span></li>
                <li><span class="label">Payment Status:</span> <span class="value highlight">{{ strtoupper($adoption->payment_status ?? '-') }}</span></li>
            </ul>
        </div>

        <!-- CTA -->
        <div class="section cta">
            <a href="{{ url('/admin/adoptions') }}">View in Dashboard</a>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>© {{ date('Y') }} <strong>ChoStudio</strong>. Handcrafted with passion 🖌️</p>
        </div>
    </div>
</body>
</html>
