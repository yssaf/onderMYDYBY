{{--@if($user!=false && $user->level==1)--}}
    <a href="{{ action('PersonController@edit',[$person->person_id+1]) }}">
        <i style="font-size:1.5em" class="ft icon-forward"></i>
        <span class="hidden-xs hidden-sm"> next</span>
    </a>
{{--@endif--}}
