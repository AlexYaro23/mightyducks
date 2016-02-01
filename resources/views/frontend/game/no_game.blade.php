@extends('frontend.main')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">{{ trans('frontend.main.no_game.title') }}</h2>
                    <h3 class="section-subheading text-muted">
                        {{ trans('frontend.main.no_game.msg') }}
                    </h3>
                </div>
            </div>
        </div>
    </section>
@endsection