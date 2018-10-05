@extends('app')

{{-- Page Title --}}
@section('title')
    Edit {{$person->forename}} {{$person->surname}}
@stop

{{-- Page Heading --}}
@section('heading')
    Edit : {{$person->forename}} {{$person->surname}}
@stop

{{-- Subnav --}}
@section('subnav-left')
    @include('layouts.links.back')
    @include('layouts.links.view_person')
    @include('layouts.links.add_person')
    @include('layouts.links.edit_next_person')
@stop

{{-- Main Body --}}
@section('content')

    <div class="row movie">

        {{-- left column --}}
        <div id="left-hand-column" class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

            {{-- cover image --}}
            <div class="row">
                <div class="col-xs-12">
                    @if(isset($person->image))
                        @if($person->cover_count == 1)
                            {{--<img id="person-poster" class="img-responsive img-rounded" src="http://placehold.it/300x450/cccccc/ffffff?text={{$person->cover}}"  />--}}
                            <img id="person-poster" class="img-responsive img-rounded" src="{{asset('images/no-ondermdb.jpg')}}"  />
                        @else
                            <img id="person-poster" class="img-responsive img-rounded" src="{{asset($person->cover)}}" />
                            @include('layouts.buttons.edit_image')
                        @endif
                    @else
                        <img id="person-poster" class="img-responsive img-rounded" src="http://placehold.it/300x450/cccccc/ffffff?text=no+image">
                    @endif
                </div>
            </div>

            <div class="side-buttons">
                <hr/>
                @include('layouts.buttons.view_person')
                @include('layouts.buttons.delete_person')
                @include('layouts.padding.padding')
            </div>

        </div>
        {{-- end of left column --}}

        {{-- right column --}}
        <div class="col-xs-12 col-sm-offset-3 col-sm-9 col-md-offset-3 col-md-9 col-lg-offset-1 col-lg-8">

            @if(session('status'))
                <div class="col-xs-12 alert alert-dismissible alert-success">
                    <button type="button" class="close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{session('status')}}
                </div>
            @endif

             {{--errors column--}}
            @if($errors->any())
                <div class="col-xs-12 alert alert-danger">
                    * There are errors with your form
                </div>
            @endif

            <ul id="movieTabs" class="nav nav-tabs" role="tablist">
                <li role="details" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Details</a></li>
                <li role="details"><a href="#roles" aria-controls="roles" role="tab" data-toggle="tab">Roles</a></li>
                <li role="details"><a href="#positions" aria-controls="positions" role="tab" data-toggle="tab">Positions</a></li>
            </ul>

            <div class="tab-content">

                <div role="tabpanel" class="tab-pane fade in active" id="details">
                    {!! Form::model($person, ['method'=>'PATCH', 'url'=>'people/'.$person->person_id, 'files' => true]) !!}
                    {!! Form::hidden('movie_id','', ['id'=>'movie_id']) !!}
                    {!! Form::hidden('person_id',$person->person_id, ['id'=>'person_id']) !!}
                    {!! Form::hidden('row_id','', ['id'=>'row_id']) !!}
                    {!! Form::hidden('_aviary', env('AVIARY_KEY'), ['id'=>'_aviary']) !!}
                    @include('layouts.forms.form_builder')
                </div>

                <div role="tabpanel" class="tab-pane fade in" id="roles">
                    <div class="row">
                        <div class="col-xs-12">
                            <a onclick="addMovieRole()" class="btn btn-primary" href="javascript:void(0)"><i class="ft icon-movie"></i> new role</a>
                        </div>
                    </div>
                    <div class="row cast">
                        <div class="col-xs-5"><b>Film</b></div>
                        <div class="col-xs-3"><b>Character</b></div>
                    </div>
                    <div id="role-list">
                        @include('people.roles')
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade in" id="positions">
                    <div class="row">
                        <div class="col-xs-12">
                            {{--<a onclick="showModal('createPosition', '')" class="btn btn-primary" href="javascript:void(0)"><i class="ft icon-director"></i> new position</a>--}}
                            <a onclick="addPosition()" class="btn btn-primary" href="javascript:void(0)"><i class="ft icon-director"></i> new position</a>
                        </div>
                    </div>
                    <div class="row cast">
                        <div class="col-xs-5"><b>Film</b></div>
                        <div class="col-xs-3"><b>Position</b></div>
                    </div>
                    <div id="position-list">
                        @include('people.positions')
                    </div>
                </div>

            </div>

            @include('layouts.forms.submit')

            {!! Form::close() !!}

        </div>
        {{-- end of right column --}}

    </div>
    {{-- end of movie row --}}

    @include('modal.add_role')
    @include('modal.add_position')
    @include('modal.edit_character')
    @include('modal.edit_position')
    @include('modal.remove_role')
    @include('modal.remove_crew')
    @include('modal.delete_person')

@stop

@section('extensions')
    <script type="text/javascript" src="http://feather.aviary.com/js/feather.js"></script>
    {!! Html::script('js/edit_person.js') !!}
@stop
