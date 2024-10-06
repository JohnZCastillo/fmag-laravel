<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
    <h1>Password Changed!</h1>
    <p>For the safety of your account, please use this temporary password to log in to your account</p>
    <input readonly class="form-control" type="text" value="{{$password}}">
    <p>If you didn't request this, immediately secure your account!</p>
    <p>Thank you,<br> FMAG Philippines</p>
</div>
</body>
</html>
