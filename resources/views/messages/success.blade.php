@if( session('success') !== null )
    <ul class="list-unstyled success-list">
        @foreach( ( (array) session('success') ) as $message)
            <li class="bg-success">{{$message}}</li>
        @endforeach
    </ul>
@endif


