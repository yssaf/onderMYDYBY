<?php

$label_class  = "col-xs-12 col-sm-6 col-md-4 col-lg-4";
$input_class  = "col-xs-12 col-sm-6 col-md-8 col-lg-8";
$break = "";
?>

@extends('app')

{{-- Page Title --}}
@section('title')
    {{$movie->name}}
@stop

{{-- Subnav --}}
@section('subnav-left')
    @include('layouts.links.back')
    @include('layouts.links.add_movie')
    @include('layouts.links.edit_movie')
@stop

{{-- Main Body --}}
@section('content')

    <div class="row movie">

        {{-- left column --}}
        <div id="left-hand-column" class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

            <div class="row">
                <div class="col-xs-12">
                    {{--<img class="img-responsive img-rounded lazy" src="{{asset('images/ondermdb.jpg')}}" data-original="{{asset('images/covers/'.$movie->image)}}"  />--}}
                    @if($movie->cover_count == 1)
                        {{--<img class="img-responsive img-rounded" src="http://placehold.it/300x450/cccccc/ffffff?text={{$movie->cover}}"/>--}}
                        <img class="img-responsive img-rounded" src="{{asset('no-ondermdb.jpg')}}"/>
                    @else
                        <img class="img-responsive img-rounded" src="{{asset($movie->cover)}}" />
                    @endif
                </div>
            </div>

            <hr/>

            <div class="side-buttons">

                @include('layouts.buttons.edit')
                @include('layouts.buttons.view')
                @include('layouts.buttons.imdb')
                @include('layouts.padding.padding')

            </div>

        </div> {{-- end of left column --}}

        {{-- right column --}}
        <div class="col-xs-12 col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9 col-lg-offset-1 col-lg-8">

            <div class="viewing-message"></div>

            <h1>{{$movie->name}}<br/></h1>

            <div class="row">
                <div class="col-xs-12">
                    <p>{{$movie->bio}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h4>Details</h4>
                </div>
            </div>

            <div class="row">
                <div class="{{$label_class}}"><b>Rating</b></div>
                <div class="{{$input_class}}">
               <span class="rating-display @if($movie->rating==10) top-rated @endif"
                     data-toggle='tooltip' data-placement='right' title='{{$movie->rating}} /
                  @if($movie->movie_id==176) 11 @else 10 @endif'>{!!$movie->rating_display!!}
               </span>
                </div>
            </div>

            <div class="row">
                <div class="{{$label_class}}"><b>Released</b></div>
                <div class="{{$input_class}}">{{$movie->released}}</div>
            </div>

            <div class="row">
                <div class="{{$label_class}}"><b>Running Time</b></div>
                <div class="{{$input_class}}">{{$movie->running_time}} mins</div>
            </div>

            <div class="row">
                <div class="{{$label_class}}"><b>Certificate</b></div>
                <div class="{{$input_class}}">@if($movie->certificate){{$movie->certificate->title}}@endif</div>
            </div>

            <div class="row">
                <div class="{{$label_class}}"><b>Format</b></div>
                <div class="{{$input_class}}">@if($movie->format){{$movie->format->type}}@endif</div>
            </div>

            <div class="row">
                <div class="{{$label_class}}"><b>Purchased</b></div>
                <div class="{{$input_class}}">{{  Carbon\Carbon::parse($movie->purchased)->format('jS F Y') }}</div>
            </div>

            <div class="row">
                <div class="{{$label_class}}"><b>Studio</b></div>
                <div class="{{$input_class}}">@if($movie->studio){{$movie->studio->name}}@endif</div>
            </div>

            @if(count($movie->genres) != 0)
                <div class="row">
                    <div class="{{$label_class}}">
                        <b>Genres</b>
                    </div>
                    <div class="{{$input_class}}">
                        @foreach( $movie->genres as $genre )
                            {{$genre->type}};
                        @endforeach
                    </div>
                </div>
            @endif

            @if(count($movie->tags) != 0)
                <div class="row">
                    <div class="{{$label_class}}">
                        <b>Tags</b>
                    </div>
                    <div class="{{$input_class}}">
                        @foreach($movie->tags as $tag)
                            {{$tag->word}};
                        @endforeach
                    </div>
                </div>
            @endif

            @if($movie->last_viewed !== NULL)
                <div class="row">
                    <div class="{{$label_class}}">
                        <b>Last Viewed</b>
                    </div>
                    <div class="{{$input_class}}">
                        {{$movie->last_viewed}}
                    </div>
                </div>
            @endif

            @if(count($movie->crew) != 0)

                @include('layouts.padding.padding')

                <div class="row">
                    <div class="col-xs-12"><h4>Crew</h4></div>
                </div>

                @foreach($movie->crew as $emp)
                    <div class="row">
                        <div class="{{$label_class}}">
                            <a href="{{ action('PersonController@show', $emp->person_id) }}">{{$emp->forename}} {{$emp->surname}}</a>
                        </div>
                        <div class="{{$input_class}}">
                            {{$emp->pivot->position}}
                        </div>
                    </div>
                @endforeach

            @endif

            @if(count($movie->cast) != 0)

                @include('layouts.padding.padding')

                <div class="row">
                    <div class="col-xs-12"><h4>Cast</h4></div>
                </div>

                {{--*/ $break=false /*--}}
                @foreach( $movie->cast as $actor )

                    @if($actor->pivot->star ==1)
                        {{--*/ $break = true /*--}}
                    @endif
                    @if($actor->pivot->star ==0 and $break == true )
                        <br/>
                        {{--*/ $break=false /*--}}
                    @endif

                    <div class="row">
                        <div class="{{$label_class}}">
                            <a href="{{ action('PersonController@show', $actor->person_id) }}">{{$actor->forename}} {{$actor->surname}}</a>
                        </div>
                        <div class="{{$input_class}}">
                            <em>{{$actor->pivot->character}}</em>
                        </div>
                    </div>
                @endforeach

            @endif

            @include('layouts.padding.padding')

        </div> {{-- end of right column --}}

    </div> {{-- end of movie row --}}

@stop

@section('extensions')
    {!! Html::script('js/show_movie.js') !!}
@stop
