<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Link ke file CSS jika ada -->
    <style>
        body {
            background-color: black;
            color: orange;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; /* Font iPhone */
        }
        h1 {
            font-size: 8rem;
            margin: 0;
            text-shadow: 2px 2px 5px rgba(255, 165, 0, 0.7);
        }
        h2 {
            font-size: 2.5rem;
            margin-top: 10px;
        }
        p {
            font-size: 1.5rem;
            margin-top: 20px;
        }
        .btn {
            background-color: orange;
            color: black;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1.2rem;
            margin-top: 30px;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }
        .btn:hover {
            background-color: #ff8c00; /* Warna oranye lebih terang saat hover */
            transform: translateY(-2px);
        }
        .btn-back {
            margin-top: 10px;
            font-size: 1rem;
            color: orange;
            text-decoration: underline;
        }
        .btn-back:hover {
            color: #ff8c00; /* Warna oranye lebih terang saat hover */
        }
    </style>
</head>
<body>
    <div>
        <h1>404</h1>
        <h2>Access Forbidden</h2>
        <p>We couldn't find the page you're looking for.
        Please check the link or go back to the homepage.</p>
        <a href="{{ url('/') }}" class="btn">Go to Home</a>
    </div>
</body>
</html>
