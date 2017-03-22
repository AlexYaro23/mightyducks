@extends('frontend.main')

@section('content')
    <section class="bg-light-gray football-bg-2">
        <div class="container">
            <schedule></schedule>
        </div>
    </section>
    <script>
        window.gameId = {!! $gameId !!}
    </script>
@endsection