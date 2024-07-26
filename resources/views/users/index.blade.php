<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users List</title>
</head>
<body>
    <h1>Users</h1>

    @session('success')
       <p> {!! $value !!} </p>
    @endsession

    @session('erro')
       <p style="color: #f00;"> {!! $value !!} </p>
    @endsession

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color: #f00;">{{ $error }}</p>
        @endforeach   
    @endif

    <form enctype="multipart/form-data" method="POST" action="{{ route('user.import') }}" name="">
        @csrf
        <input type="file" name="file" id="file" accept=".csv">
        <button type="submit">Importar</button>
    </form>

    @foreach ($users as $user)
        {{ $user->id }}
    @endforeach
</body>
</html>