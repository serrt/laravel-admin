@extends('admin.layouts.iframe')
@section('content')
    <div class="jumbotron text-center">
        <h1>403</h1>
        <p>{{$exception->getMessage()}}</p>
    </div>
@endsection