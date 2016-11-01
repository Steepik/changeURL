@extends('app')

@section('content')
    <div class="parent">
        <div class="block">
            <form action="/url" method="post" class="urlForm">
                <label for="url">* Enter your original url:</label>
                <input type="text" class="form-group form-control" placeholder="http://google.com" id="url" name="url" required>
                <label for="url">Enter password for your url:</label>
                <input type="password" class="form-group form-control" name="password" placeholder="Password">
                <label for="url">* The link will be available in:</label>
                <input type="date" class="form-group form-control" name="endtime" required>
                <input type="time" class="form-group form-control" name="endtimehour" required>
                <input type="submit" class="form-group form-control btn-primary" value="Change">
            </form>
        </div>
    </div>
@stop