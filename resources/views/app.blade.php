<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>skill matrix</title>
    @vite('resources/js/app.js')
</head>
<body>

    <div style="display: flex; justify-content: flex-end; margin: 5px">
        <p style="margin: 10px;">Hello <strong>{{ Auth::user()->name }} </strong></p>
    
        <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
            <button type="submit" class="btn btn-warning">{{ __('Log Out') }}</button>
        </form>
    </div>
    
    <div id="app"></div>
   
</body>
</html>