{{--@if($user!=false && $user->level==1)--}}
    <a href="{{ action('MovieController@edit',[$movie->movie_id]) }}">
        <i style="font-size:1.5em" class="ft icon-edit-movie"></i>
        <span class="hidden-xs hidden-sm"> Edit Movie</span>
    </a>
{{--@endif--}}
