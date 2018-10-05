@extends('app')


{{-- Page Title --}}
@section('title')
    All People
@stop


{{-- Subnav --}}
@section('subnav-left')
    @include('layouts.links.back')
    @include('layouts.links.add_person')
@stop

{{-- Main Body --}}
@section('content')

    <div class="row">
        <div class="col-xs-12">
            <ul class="xs-block-grid-3 sm-block-grid-6 md-block-grid-8 lg-block-grid-8">
                @foreach($people as $person)
                    <li class="image-thumbnail text-center">
                        <a href="{{ action('PersonController@show', $person->person_id) }}">
                            <img class="img-responsive img-rounded lazy" src="{{asset('images/ondermdb.jpg')}}" data-original="{{asset('images/people/'.$person->image)}}"  />
                            <span class="title-wrapper hidden-xs">{{$person->forename}} {{$person->surname}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @include('layouts.padding.padding')

    <div class="row">
        <div class="col-xs-12 text-center">
            {!! $people->render() !!}
        </div>
    </div>

    @include('layouts.padding.padding')

@stop
