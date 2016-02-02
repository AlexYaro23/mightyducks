@extends('frontend.main')

@section('content')
    <section class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">{{ $team->name }}</h2>
                    <h3 class="section-subheading text-muted">
                        {{ trans('frontend.training.training') }}
                    </h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <ul>
                        @foreach($trainingList as $training)
                            <li>
                                <a href="{{ route('training.visit', ['id' => $training->id]) }}">
                                    {{ $training->name . ' | ' .
                                        $dayList[$training->day_of_week] . '  ' .
                                        $training->time }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
