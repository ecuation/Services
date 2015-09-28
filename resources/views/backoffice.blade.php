<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta id="token" name="token" value="{{csrf_token()}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/libs.css')}}">
    <title>@yield('page-title', 'Api Rest')</title>
</head>
<body class="{{$view_name}}">
    @include('messages.flash')
    @section('page-header')
        @include('auth.menu')
    @show
    <div class="container jumbotron">

        @yield('content')

        @yield('page-footer')

    </div>
    <script src="{{asset('js/bundle.js')}}"></script>
</body>
</html>