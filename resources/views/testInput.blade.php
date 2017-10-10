@extends('layouts.app')
@section('content')
    <form action="{{url('/message')}}" method="POST">{{ csrf_field() }}
        message: <input type="text" name="message"><br>
        <input type="submit" value="Submit" required>
    </form>
    @stop