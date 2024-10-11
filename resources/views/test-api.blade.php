<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    @if($message = session('success'))
    <div class="alert alert-success my-2 text-success" role="alert">{{ $message }}</div>
    @endif
    <form method="POST" action="{{route('api')}}">
        @csrf
        <button class="btn btn-outline-primary" type="submit">test</button>
    </form>

    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="">user</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">gender</a>
            </li>
        </ul>
        <br>
        <button class="btn btn-primary btn-lg">add user</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>name</th>
                    <th>born</th>
                    <th>gender</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>iqbal</td>
                    <td>06-04-06</td>
                    <td>men</td>
                    <td>
                        <button class="btn btn-primary">edit</button>
                        <button class="btn btn-danger">delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>



    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>


</html>