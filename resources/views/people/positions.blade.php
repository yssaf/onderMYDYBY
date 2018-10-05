@foreach( $person->positions as $position )
    <div class="row cast">
        <div class="col-xs-5">{{$position->name}}</div>
        <div class="col-xs-3"><i>{{$position->pivot->position}}</i></div>
        <div class="col-xs-2">
            {{--<a class="btn btn-block btn-success-outline btn-xs" onclick="showModal('editPosition', {{$position->pivot->cast_id}})" href="javascript:void(0)"><i class="ft icon-edit"></i> edit</a>--}}
            <a class="btn btn-block btn-success-outline btn-xs" onclick="editPosition({{$position->pivot->crew_id}})" href="javascript:void(0)"><i class="ft icon-edit"></i> edit</a>
        </div>
        <div class="col-xs-2">
            {{--<a class="btn btn-block btn-danger-outline btn-xs" onclick="showModal('removePosition', {{$position->pivot->cast_id}})" href="javascript:void(0)"><i class="ft icon-fail"></i> remove</a>--}}
            <a class="btn btn-block btn-danger-outline btn-xs" onclick="removeCrewMovie({{$position->pivot->crew_id}})" href="javascript:void(0)"><i class="ft icon-fail"></i> remove</a>
        </div>
    </div>
@endforeach
