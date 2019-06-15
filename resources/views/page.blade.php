<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}"

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
       
    </head>
    <body>
        <div id="app">
       @if (Auth::check())
          <app user_role="{{Auth::user()->role_id}}"></app> 
       @else
          <app user_role="0"></app> 
       @endif
        </div>
       <script src="{{mix('js/app.js')}}"></script>
    </body>
</html>
