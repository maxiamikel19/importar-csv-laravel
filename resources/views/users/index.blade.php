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

    <form action="POST" enctype="multipart/form-data" action="" name="">
        @csrf
        <input type="file" name="file" id="file" accept=".csv">
        <button type="submit">Importar</button>
    </form>

    @foreach ($users as $user)
        {{ $user->id }}
    @endforeach
</body>
</html>