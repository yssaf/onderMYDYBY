{{--@if($user!=false && $user->level==1)--}}
    <a href="{{ action('PersonController@edit',[$person->person_id]) }}">
        <i style="font-size:1.5em" class="ft icon-edit-user"></i>
        <span class="hidden-xs hidden-sm"> Edit Person</span>
    </a>
{{--@endif--}}
