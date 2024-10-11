<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @if($message = session('success'))
    <div class="alert alert-success my-2 text-success" role="alert">{{ $message }}</div>
    @endif
    <form method="POST" action="{{route('api')}}">
        @csrf
        <button type="submit">test</button>
    </form>
</body>
</html>