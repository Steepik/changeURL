@extends('app')

@section('content')
    <div class="parent">
        <div class="block">
            <div class="panel panel-danger">
                <div class="panel-heading">Errors</b></div>
                <div class="panel-body">
                    <ul>
                        @foreach($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <a href="javascript:void(0)" onclick="window.history.back();"><< Back</a>
        </div>
    </div>
@stop