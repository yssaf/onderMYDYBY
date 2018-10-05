<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Onder Movie Database</title>
    <meta name="description" content="dbMovies - My Movie Database. This is a record of every movie that I own. Built using the Laravel 7 framework.">
    <meta name="author" content="Yusuf Hajjar">
    <meta name="_token" content="{!! csrf_token() !!}" />

    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ URL::asset('images/app-icon.png') }}">


    <link rel="stylesheet" type="text/css" href="//www.fontstatic.com/f=rabat" />
    <link rel="stylesheet" type="text/css" href="//www.fontstatic.com/f=rabat,arabswell-1" />

    <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}">
    <link rel="shortcut icon" href="{{ URL::asset('myicon.ico') }}">


    <link href="{{asset('css/mymdb.css')}}" rel="stylesheet">

</head>
<body>

{{----}}


{{--@if(!Session::get('counter'))--}}
    {{--<div class="doc-loader">--}}
        {{--<h2 style="font-family:Philosopher;color:#fafafa;text-align:center;font-size:5em;line-height:0.9em;">Onder-MDB</h2>--}}
        {{--<div class="loader" style="margin-left: 30px;">--}}
            {{--<h2 style="font-family:Philosopher;color:#fafafa;text-align:center;font-size:5em;line-height:0.9em;">Onder-MDB</h2>--}}
            {{--<img src="images/svg/onder.svg"/>--}}
            {{--<img src="images/mdb1.png"/>--}}
        {{--</div>--}}
      {{--<div style="position: absolute; margin-left: 650px; margin-top: 450px;"><h1 style="font-family: 'arabswell-1';border-bottom: none;color: #000000; font-size: 8em">مصطفى العقاد</h1></div>--}}
    {{--</div>--}}
{{--@endif--}}

{{--@if(!Session::get('counter'))--}}
    {{--<div class="doc-loader">--}}
        {{--<div class="loader">--}}
            {{--<h2 style="font-family:Philosopher;color:#fafafa;text-align:center;font-size:5em;line-height:0.9em">MyMDb</h2>--}}
            {{--<img src="images/svg/rings.svg"/>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endif--}}

@include('layouts.navbars.nav')
@include('layouts.navbars.subnav')

{{----}}

<div class="container">
    <div class="filtered-content"></div>
</div>

{{-- PURCHAED CONTENT --}}
<div class="purchased-content parallax">

    <div class="container">

        <div class="row">
            <div class="col-xs-12">
                <h4>Recently Purchased</h4>
            </div>
        </div>

    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="slick-purchased hide">
                    @foreach($details->most_recent as $movie)
                        <div>
                            <a href="{{ action('MovieController@show', $movie->movie_id) }}">
                                <img class="img-rounded" src="{{asset('images/covers/'.$movie->image)}}" alt="Movie Poster for {{$movie->name}}" />
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div> {{-- END OF PURCHASED CONTENT --}}

{{----}}

{{-- RATING CONTENT --}}
<div class="ratings-content">

    <div class="container">

        @include('layouts.padding.padding')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                @include('layouts.welcoms.highest')
            </div>
            <div class="col-xs-12 col-md-6">
                <h4>Movies By Certificate</h4>
                <div id="certificateChart" style="height: 350px; width: 100%;"></div>
            </div>
        </div>

        @include('layouts.padding.padding')

    </div>

</div> {{-- END OF RATING CONTENT --}}

{{----}}



{{----}}
{{-- FEATURED CONTENT --}}
<div class="feature-content parallax">

    <div class="container">

        @include('layouts.padding.padding')

        <div class="row">
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2  col-lg-offset-1">
                <a href="{{ action('MovieController@show', $details->highlight->movie_id) }}">
                    <img class="img-rounded img-responsive" src="{{asset('images/covers/'.$details->highlight->image)}}"  alt="Movie poster for {{$details->highlight->name}} " />
                </a>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-8">
                <h4>{{$details->highlight->name}} ({{$details->highlight->released}}) </h4>
                <span class="rating-display @if($details->highlight->rating==10) top-rated @endif"
                      data-toggle='tooltip' data-placement='top' title='{{$details->highlight->rating}} / @if($movie->movie_id==176) 11 @else 10 @endif'>
                        {!! $details->highlight->rating_display !!}
                  </span>

                @include('layouts.padding.padding')

                <div class="row">
                    <div class="col-xs-12">
                        {{$details->highlight->bio}}
                    </div>
                </div>

                @include('layouts.padding.padding')

                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                        <a href="{{ action('MovieController@show', $details->highlight->movie_id) }}" class="btn btn-block btn-primary"> view </a>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.padding.padding')

    </div>

</div> {{-- END OF FEATURED CONTENT --}


{{----}}


{{----}}

{{-- POPULAR PEOPLE CONTENT --}}
<div class="secondary-content">

    <div class="container">

        @include('layouts.padding.padding')

        <div class="row">
            <div class="col-xs-12">
                <h4>Most Popular Actors</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 image-thumbnail">
                <div id="actor-slidee" class="frame">
                    <ul class="slidee">
                        @foreach($details->actors as $actor)
                            <li>
                                <a href="{{ action('PersonController@show', $actor->person_id) }}">
                                    <img class="img-rounded img-responsive" src="{{asset('images/people/'.$actor->image)}}" alt="Image of {{$actor->name}}" />
                                    <span class="title-wrapper text-center">
                                        {{$actor->name}}<br/>
                                        @if($actor->count == 1) 1 movie
                                        @else {{$actor->count}} movies
                                        @endif
                                 </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <ul id="actor-pages" class="pages"></ul>
            </div>
        </div>

        @include('layouts.padding.padding')

        <div class="row">
            <div class="col-xs-12">
                <h4>Most Popular Directors</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 image-thumbnail">
                <div id="director-slidee" class="frame">
                    <ul class="slidee">
                        @foreach($details->directors as $director)
                            <li>
                                <a href="{{action('PersonController@show', $director->person_id) }}">
                                    <img class="img-rounded img-responsive" src="{{asset('images/people/'.$director->image)}}" alt="Image of {{$director->name}}" />
                                    <span class="title-wrapper text-center">
                                    {{$director->name}}<br/>
                                        @if($director->count == 1) 1 movie
                                        @else {{$director->count}} movies
                                        @endif
                                 </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <ul id="director-pages" class="pages"></ul>
            </div>
        </div>

        @include('layouts.padding.padding')

        <div class="row">
            <div class="col-xs-12">
                <h4>Today's Birthdays</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 image-thumbnail">
                <div id="birthday-slidee" class="frame">
                    <ul class="slidee">
                        @foreach($details->birthdays as $actor)
                            <li>
                                <a href="{{action('PersonController@show', $actor->person_id) }}">
                                    <img class="img-rounded img-responsive" src="{{asset('images/people/'.$actor->image)}}" alt="Image of {{$actor->name}}" />
                                    <span class="title-wrapper text-center">
                                    {{$actor->name}}<br/>
                                        @if($actor->deceased) ( @endif {{$actor->age}} @if($actor->deceased) ) @endif
                                 </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <ul id="birthday-pages" class="pages"></ul>
            </div>
        </div>

        @include('layouts.padding.padding')

    </div>

</div> {{-- END OF POPULAR PEOPLE CONTENT --}}

{{----}}
{{----}}

{{-- CHART CONTENT --}}
<div class="chart-content">

    <div class="container">

        @include('layouts.padding.padding')

        <div class="row">
            <div class="col-xs-10">
                <h4 id="movies-by-label">Movies By Decade</h4>
            </div>
            <div class="col-xs-2">
                {!! Form::select('select_decade', ['all'=>'All'] + $details->decades, 'all', ['class'=>'form-control', 'id'=>'decadeSelectFilter']) !!}
            </div>
        </div>

        @include('layouts.padding.padding')

        <div class="row">
            <div class="col-xs-12">
                <div id="yearChart" style="height: 300px; width: 100%;">
                </div>
            </div>
        </div>




        @include('layouts.padding.padding')

    </div>

</div> {{-- CHART CONTENT --}}

{{----}}


<script src="{{asset('js/mymdb.js')}}"></script>

{!! Html::script('js/slick.js') !!}
{!! Html::script('js/canvas.js') !!}
{!! Html::script('js/welcome.js') !!}



<footer>
    @include('layouts.footer.footer')
</footer>


</body>
</html>