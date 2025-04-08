<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Service</title>
    <style>
        /* Add your email styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .logo {
            max-width: 150px;
            display: block;
            margin: 0 auto;
        }
        .message {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!--<img class="logo" src="https://dash.comtinuumcapitaltrading.com/public/assets/images/bit-blockdigital_images/logomain.png" alt="Company Logo">-->
        <div class="message">
            <h2>Welcome to Our Service</h2>
            <p>Hello {{ $user->fullname }},</p>
            <p>We are excited to welcome you to our platform. Thank you for choosing us for your financial needs.</p>
            <p>Feel free to explore our services, and if you have any questions or need assistance, don't hesitate to contact our support team.</p>
            <p>Before you get started, please verify your email by clicking the button below:</p>
            <a href="{{ route('verify_email', ['token' => $token]) }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Verify Email</a>
            <p>If the button above doesn't work, you can also copy and paste the following link into your browser:</p>
            <p>{{ route('verify_email', ['token' => $token]) }}</p>
            <p>Thank you for becoming a part of our community!</p>
            <p>Sincerely,<br> Comtinuum Capital Trading</p>
        </div>
    </div>
</body>

</html>
