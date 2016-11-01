@extends('app')

@section('content')
    <div class="parent">
        <div class="block">
            <div class="panel panel-success">
                <div class="panel-heading">Url data</b></div>
                <div class="panel-body">
                    <ul class="list-group">
                            <li>Original url: {{ $url_original }}</li>
                            <li>New url: <a href="{{ $url_changed }}" target="_blank">{{ $url_changed }}</a></li>
                            <li>Password:
                                @if($password != '')
                                    {{ $password }}
                                @else
                                    Not
                                @endif
                            </li>
                    </ul>
                </div>
            </div>
            <a href="javascript:void(0)" onclick="window.history.back();"><< Back</a>
        </div>
    </div>
@stop