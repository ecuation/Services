@extends('app')

@section('page-title')
	Register
@stop

@section('content')

    <div class="form-container">
        <h2>Sign in</h2>
        {!! Form::open(['route' => 'post-register']) !!}
            <div class="form-group">
                {!! Form::text('name',old('name'), ['placeholder' => 'Name*']) !!}
            </div>

            <div class="form-group">
                {!! Form::text('email', old('email'), ['placeholder' => 'Email*']) !!}
            </div>

            <div class="form-group">
                {!! Form::password('password', ['placeholder' => 'Password*']) !!}
            </div>

            <div class="form-group">
                {!! Form::password('password_confirmation', ['placeholder' => 'Confirm password*']) !!}
            </div>

            @include('errors.form-errors')
            <div class="form-group">
                {!! Form::submit('Register', ['class' =>'btn btn-success']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@stop