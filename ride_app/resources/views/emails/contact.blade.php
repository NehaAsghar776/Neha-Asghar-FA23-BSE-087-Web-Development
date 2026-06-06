<!DOCTYPE html>
<html>
<head>
    <title>New Contact Query</title>
</head>
<body>
    <h2>New Contact Query</h2>
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $data['message'] }}</p>
</body>
</html>