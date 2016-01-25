@if ($errors->any())
    <ul class="alert alert-danger error">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif