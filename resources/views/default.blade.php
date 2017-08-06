<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{env('SITE_NAME')}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <script src="{{asset('js/vendor/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">{{env('SITE_NAME')}}</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="navbar-form navbar-right nav">
                @if(!\Auth::user())
                    <span style="color:white;padding: 6px 16px">Login: </span>
                    @foreach(explode(',', env('OAUTH_ENABLE')) as $provider)
                        {!! \App\Libraries\Helpers::btn_oAuth($provider) !!}
                    @endforeach
                @else
                    <span style="color:white;padding: 6px 16px">Logged as: {{\Auth::user()->email}} ({{Auth::user()->votes_count}}/{{env('VOTE_LIMIT', 10)}} votes)</span>
                    <a href='{{url('/logout')}}' class='btn btn-danger'>Logout</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<div class="container">
    <div id="loader"></div>
    <div id="app">
        <div class="row row-eq-height headers">
            <div class="col-sm-1 ranks">Rank</div>
            <div class="col-sm-9 infos">Title</div>
            <div class="col-sm-2 text-center votes">Votes</div>
        </div>
        <div id="rows">
            <h1>Loading....</h1>
        </div>
    </div>

    <footer>
        <p>&copy; {{date('Y')}}</p>
    </footer>
</div> <!-- /container -->

<script>var baseurl = "{{url('/')}}";</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{{asset('js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>
<script src="{{asset('js/vendor/bootstrap.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
</body>
</html>
