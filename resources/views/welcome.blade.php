<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ URL::asset('css/welcome.css') }}">
        <script type="text/javascript" src="{{ URL::asset('js/welcome.js') }}"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="row">
                    <div class="title m-b-md">
                        @if ($name)
                            {{ $name }}
                        @else
                            Laravel
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="links">
                        @foreach($links as $link)
                        <a href="{{ $link->link }}" onmouseover="show({{ $link->div_id }})" onmouseout="hide({{ $link->div_id }})">
                            {{ $link->link_text }}
                            <div class="tooltip" id="{{ $link->div_id }}">
                                {{ $link->tip }}
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div>
                        <img src="{{ URL::asset('img/fall.jpg') }}">
                    </div>
                </div>
                <div class="row">
                    <audio controls>
                        <source src="{{ URL::asset('music/11 - Steampowered.mp3') }}" type="audio/mpeg">
                    </audio>
                </div>
            </div>
        </div>
    </body>
</html>
