@extends('layouts.app')

@section('content')
    <div id="app">
        <chats :user="{{$user}}" />
    </div>
@endsection
