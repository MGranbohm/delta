@extends('layouts.app')
@section('content')
    <form action="{{url('/message')}}" method="POST">{{ csrf_field() }}
        message: <input type="text" name="message"><br>
        <input type="submit" value="Submit" required>

        {{--@foreach($messages as $message)--}}
            {{--<li>{{$message}}</li>--}}
        {{--@endforeach--}}
        {{--@foreach($responses as $response)--}}
            {{--<li>{{$response}}</li>--}}
        {{--@endforeach--}}
        @foreach($c as $post)
            <li>{{$post[0]}}</li>
            <li>{{$post[1]}}</li>
        @endforeach
        {{$mood}}

    </form>
    @stop