@extends('app')

{{-- Page Title --}}
@section('title')
    Admin
@stop

{{-- Main Body --}}
@section('content')

    <div class="row">
        <div class="col-xs-2">
            <div class="admin-side-links">
                @include('layouts.links.genres')
                @include('layouts.links.studios')
                @include('layouts.links.keywords')
                @include('layouts.links.viewings')
                @include('layouts.links.quotes')<hr/>
                @include('layouts.links.add_movie')
                @include('layouts.links.add_person')<hr/>
                @include('layouts.links.seed')<hr/>
                @include('layouts.links.logout')
            </div>
        </div>
        <div class="col-xs-offset-1 col-xs-9">
            @if(session('status'))
                <div class="col-xs-12 alert alert-dismissible alert-success">
                    <button type="button" class="close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('status') }}
                </div>
            @endif
            <div id="admin-details">
                @include('layouts.padding.padding')
                <div class="row">
                    <div class="col-xs-5"><b>Total movies in collection :</b></div>
                    <div class="col-xs-7"><span class="add-commas">{{$data->movie_total}}</span></div>
                </div>
                <div class="row">
                    <div class="col-xs-5"><b>Total running time :</b></div>
                    <div class="col-xs-7"><span class="add-commas">{{$data->running_total}}</span> minutes</div>
                </div>
                <div class="row">
                    <div class="col-xs-5"><b>Time required to watch :</b></div>
                    <div class="col-xs-7">{{$data->watching_time}}</div>
                </div>
                @include('layouts.padding.padding')
                <div class="row">
                    <div class="col-xs-5"><b>Total actors in collection :</b></div>
                    <div class="col-xs-7"><span class="add-commas">{{$data->person_total}}</span></div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('extensions')
    {!! Html::script('js/admin.js') !!}
@stop
