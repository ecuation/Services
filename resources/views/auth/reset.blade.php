@extends('app')

@section('page-title')
    Reset
@stop

@section('content')

    <div class="form-container">

        @include('messages.success')

        <h2 class="form-title title">{{trans('interface.reset-password')}}</h2>
        {!! Form::open(['route' => 'reset']) !!}

            {!! Form::hidden('token', $token) !!}

            <div class="form-group">
                {!! Form::text('email',old('email'), ['placeholder' => trans('interface.email')]) !!}
            </div>

            <div class="form-group">
                {!! Form::password('password', ['placeholder' => trans('interface.password')]) !!}
            </div>

            <div class="form-group">
                {!! Form::password('password_confirmation', ['placeholder' => 'Confirm password*']) !!}
            </div>

            @include('errors.form-errors')

            <div class="form-group">
                {!! Form::submit(trans('interface.submit'), ['class' =>'btn btn-success']) !!}
            </div>

        {!! Form::close() !!}

    </div>
@stop
