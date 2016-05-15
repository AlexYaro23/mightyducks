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

                        <table class="table table-hover" data-training="{{ $training->id }}">
                            <thead>
                            <tr>
                                <th>{{ trans('frontend.training.player_name') }}</th>
                                <th>{{ trans('frontend.training.visit') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($playerList as $player)
                                <tr data-player="{{ $player->id }}">
                                    <td>{{ $player->name }}</td>
                                    <td>
                                        <div class="pull-right visit-label-block">
                                            @if(Auth::user() != null && Auth::user()->player != null && Auth::user()->player->id == $player->id)
                                                <select data-team="{{ $team->id }}" data-training="{{ $training->id }}"
                                                        class="switcher">
                                                    <option value="">&nbsp;</option>
                                                    <option value="{{ $statusVisited }}"
                                                            {{ isset($visitList[$player->id]) && $visitList[$player->id] == $statusVisited ? 'selected="selected"' : ''}}>
                                                        {{ trans('frontend.main.visit.yes') }}
                                                    </option>
                                                    <option value="{{ $statusNotVisited }}"
                                                            {{ isset($visitList[$player->id]) && $visitList[$player->id] == $statusNotVisited ? 'selected="selected"' : ''}}>
                                                        {{ trans('frontend.main.visit.no') }}
                                                    </option>
                                                </select>
                                            @else
                                                @if(isset($visitList[$player->id]) && $visitList[$player->id] == $statusVisited)
                                                    <span class="label label-success">{{ trans('frontend.main.visit.yes') }}</span>
                                                @elseif(isset($visitList[$player->id]) && $visitList[$player->id] == $statusNotVisited)
                                                    <span class="label label-danger">{{ trans('frontend.main.visit.no') }}</span>
                                                @else
                                                    <span class="label label-default">...</span>
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

            var channel = pusher.subscribe('trainingVisit.{{$training->id}}');

            channel.bind('App\\Events\\TrainingVisitAdded', function (data) {
                if (data.trainingId != undefined && data.playerId != undefined && data.visit != undefined) {
                    var label = $('table[data-training="' + data.trainingId + '"]').find('tr[data-player="' + data.playerId + '"]').find('.label');

                    label.removeClass();
                    if (data.visit == '2') {
                        label.html('Нет');
                        label.addClass('label label-danger');
                    } else if (data.visit == '1') {
                        label.html('Да');
                        label.addClass('label label-success');
                    } else {
                        label.html('...');
                        label.addClass('label label-default');
                    }
                }
            });

            $('.switcher').on('change', function () {
                $.ajax({
                    url: '{{ route('training.visit.add', ['id' => $training->id]) }}',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        visit: this.value,
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