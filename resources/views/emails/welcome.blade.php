@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => trans('interface.hello').'!',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>{{trans('interface.confirm-success')}}:</p>
    <p>{{trans('messages.finish-suscription-process')}}</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => trans('interface.confirm'),
            'link' => get_permalink('confirm').'/'.$verification_key
    ])

@stop
