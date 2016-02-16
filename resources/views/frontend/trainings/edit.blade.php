@extends('frontend.main')

@section('content')
    <section class="bg-light-gray football-bg-2">
        <div class="container">
            <div class="football-block">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">{{ $training->name }}</h2>

                        <h3 class="section-subheading text-muted">
                            {{ trans('frontend.training.' . $dayList[$training->day_of_week]) . ' ' . $training->getTime() }}
                        </h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">

                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>{{ trans('frontend.training.player_name') }}</th>
                                <th>{{ trans('frontend.training.visit') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($playerList as $player)
                                <tr>
                                    <td>{{ $player->name }}</td>
                                    <td>
                                        <div class="material-switch pull-right">
                                            @if(isset(Auth::user()->player->id) && Auth::user()->player->id == $player->id)
                                                <input {{ isset($visitList[$player->id]) ? 'checked="checked"' : '' }}
                                                        data-team="{{ $team->id }}"
                                                        data-training="{{ $training->id }}" class="switcher"
                                                        id="someSwitchOptionSuccess_{{ $player->id }}"
                                                        name="someSwitchOption001"
                                                        type="checkbox"/>
                                                <label for="someSwitchOptionSuccess_{{ $player->id }}"
                                                       class="label-success"></label>
                                            @else
                                                @if(isset($visitList[$player->id]))
                                                    <span class="label label-success">{{ trans('frontend.main.visit.yes') }}</span>
                                                @else
                                                    <span class="label label-danger">{{ trans('frontend.main.visit.no') }}</span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <script>

        (function () {
            var pusher = new Pusher('4cbafc53eb5fa82e05c2', {
                encrypted: true
            });

            var channel = pusher.subscribe('trainingVisit');

            channel.bind('App\\Events\\TrainingVisitAdded', function(data) {
                console.log(124);
            });

            $('.switcher').on('change', function () {
                $.ajax({
                    url: '{{ route('training.visit.add', ['id' => $training->id]) }}',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        visit: this.checked,
                        training_id: $(this).data('training'),
                        team_id: $(this).data('team')
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status == 'success') {
                            swal(data.msg, "", "success")
                        } else if (data.status == 'error') {
                            swal(data.msg, "", "error")
                        }
                    },
                    error: function (error) {
                        swal("{{ trans('frontend.main.visit_add_error') }}", "", "error");
                    }
                });
            });
        })();
    </script>
@endsection