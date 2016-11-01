@extends('app')

@section('content')
    <div class="parent">
        <div class="block">
            <form action="/url/pass" method="post">
                <form action="/url" method="post" class="urlForm">
                    <label for="url">Enter link's password:</label>
                    <input type="password" class="form-group form-control" name="password" placeholder="Password">
                    <input type="hidden" name="url_changed" value="{{ $url_changed }}">
                    <input type="submit" class="form-group form-control btn-primary" value="Enter">
                </form>
            </form>
    </div>
    </div>
@stop