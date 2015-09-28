@extends('app')

@section('page-title')
	Home page
@stop

@section('page-header')
	@parent
@stop

@section('content')
	<h1> {{ trans('interface.welcome') }} </h1>
@stop