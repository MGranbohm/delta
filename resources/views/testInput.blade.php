@extends('layouts.app')
@section('content')
    <form action="{{url('/message')}}" method="POST">{{ csrf_field() }}
        message: <input type="text" name="message"><br>
        <input type="submit" value="Submit" required>

            @foreach($messages as $message)
            <li>{{$message}}</li>
            @endforeach
            @foreach($responses as $response)
            <li>{{$response}}</li>
            @endforeach

    </form>
    @stop