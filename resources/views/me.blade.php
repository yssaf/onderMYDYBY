<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@if (session('status'))
    <div class="col-xs-12 alert alert-dismissible alert-success">
        <button type="button" class="close" >
            <span aria-hidden="true">&times;</span>
        </button>
        {{ session('status') }}
    </div>
@endif
{{--<p>{{dd($fields)}}</p>--}}
{{--<p>{{dd($person)}}</p>--}}
{{--<p>{{dd($values)}}</p>--}}
{{--<p>{{dd($user)}}</p>--}}
{{--<p>{{($crew->movie_id)}}</p>--}}
<p>{{dd($data)}}</p>
</body>
</html>