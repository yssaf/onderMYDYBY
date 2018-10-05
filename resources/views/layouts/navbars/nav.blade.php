<nav class="navbar navbar-default  navbar-fixed-top" style="border-bottom-width: 1px;">

    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
           {{--<a class="navbar-brand" href="{{ action('WelcomeController@index') }}"><i class="ft icon-movie"></i> -MDB</a>--}}
           <a class="navbar-brand" href="{{ action('WelcomeController@index') }}"><div class="mylogo" style="position: absolute; margin-top: -112px; margin-left: -134px;">
                   <img src="{{asset('images/mdb1.png')}}" style="width: 185px; height: 239px;">
               </div><h3 style="color: black; margin-top: -5px; display: contents;"> -MDB - منتدى <span style="color: #f15a29;">مصطفى العقّاد</span> السينمائي</h3></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav navbar-right">
                <li class="{{Request::is('movies*') ? 'movies-active' : 'movies-normal'}}">
                    <a href="{{ action('MovieController@index') }}">
                        <i style="font-size:1.5em" class="ft icon-view-movie"></i>
                        <span> Movies</span>
                    </a>
                </li>
                <li class="{{Request::is('people*') ? 'character-active' : 'character-normal'}}">
                    <a href="{{ action('PersonController@index') }}">
                        <i style="font-size:1.5em" class="ft icon-character"></i>
                        <span> People</span>
                    </a>
                </li>

                <li class="{{Request::is('admin*') ? 'admin-active' : 'admin-normal'}}">
                    {{--@if(isset($user) && $user!=false && $user->level==1)--}}
                    @if(Route::has('login'))
                        @auth
                        <a href="{{ route('admin') }}"><i style="font-size:1.5em" class="ft icon-admin"></i> Admin</a>
                    @else
                        {{--<a href="{{ url('/auth/login') }}"><i style="font-size:1.5em" class="ft icon-rebel"></i> Login</a>--}}
                        <a href="{{ url('/login') }}"><i style="font-size:1.5em" class="ft icon-rebel"></i> Login</a>
                        @endauth
                    @endif
                </li>
            </ul>

        </div>

    </div>

</nav>
