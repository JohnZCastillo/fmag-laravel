<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry</title>
    <style>
        /* Reset styles to ensure consistency across email clients */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        /* Inline CSS for specific styling */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            margin-bottom: 20px;
        }

        .form-control {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            outline: none;
            border: solid 1px grey;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>{{$serviceInquiry->service->title}}</h1>
    <p>Dear {{$serviceInquiry->user->name}}</p>

    <p>We appreciate your interest in our training services. I trust that our course will meet your needs effectively.
        Your feedback is valued, and we're here to assist you with any queries as you utilize our training materials.
        <strong>Thank you once again for being a valued customer.</strong>
    </p>
    <p>
        Additionally, we'd like to arrange a meeting to discuss our services further. We're flexible and can accommodate
        your schedule. Please let us know your availability this week between 8 AM and 5:30 PM
    </p>
    <p>Thank you,<br> FMAG Philippines</p>
</div>
</body>
</html>
