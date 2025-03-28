<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enrollment Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }

        .email-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        h2 {
            color: #dc3545;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        .status-button {
            display: inline-block;
            background: {{ $status === 'completed' ? '#28a745' : '#dc3545' }};
            color: #fff !important;
            text-decoration: none;
            padding: 12px;
            border-radius: 5px;
            font-weight: bold;
            margin: 15px 0;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h2>📢 Enrollment Status Update</h2>
        <p>Hello, <strong>{{ $name }}</strong> 👋</p>
        <p>Your enrollment status for the course <strong>{{ $course }}</strong> has been updated.</p>

        @if ($status === 'completed')
            <p>🎉 Congratulations! Your enrollment has been successfully completed.</p>
            <a href="#" class="status-button">✅ Enrollment Confirmed</a>
        @elseif($status === 'failed')
            <p>⚠️ Unfortunately, there was an issue with your payment. Please check your Vodafone Cash receipt and try
                again.</p>
            <a href="#" class="status-button">❌ Payment Failed</a>
        @endif
        <p>If you need any assistance, feel free to contact our support team.</p>
        <div class="footer">
            <p>📞 Need help? Contact our support team.</p>
            <p>🛠️ <strong>The Code Spark Team</strong></p>
        </div>
    </div>
</body>

</html>
