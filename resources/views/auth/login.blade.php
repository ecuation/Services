@extends('app')

@section('page-title')
	Login
@stop

@section('content')
    <div class="form-container">

        @include('messages.success')

        <h2 class="form-title title">{{trans('interface.login')}}</h2>

        {!!  Form::open(['route' => 'post-login'])  !!}

            <div class="form-group">
                {!! Form::text('email',old('email'), ['placeholder' => trans('interface.email')]) !!}
            </div>

            <div class="form-group">
                {!! Form::password('password', ['placeholder' => trans('interface.password')]) !!}
            </div>

            @include('errors.form-errors')
            <div class="form-group">
                {!! Form::submit(trans('interface.login'), ['class' =>'btn btn-success']) !!}
                <a href="{{ get_permalink('reset') }}" class="forgot">{{ trans('interface.forgot-passsword') }}</a>
            </div>

            {!! Form::checkbox('remember', 1, false) !!}
            <span>{{trans('interface.remember-me')}}</span>

        {!!  Form::close()  !!}
    </div>
@stop