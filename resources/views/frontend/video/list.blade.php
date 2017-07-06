@extends('frontend.main')

@section('content')
    <video-list :games="{{ $games }}"></video-list>
@endsection
