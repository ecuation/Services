@if($errors->any())
    <ul class="list-unstyled error-list">
        @foreach($errors->all() as $error)
            <li class="bg-danger">{{$error}}</li>
        @endforeach
    </ul>
@endif
