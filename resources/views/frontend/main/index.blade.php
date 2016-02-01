@extends('frontend.main')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">{{ $game->team }}</h2>
                    <h3 class="section-subheading text-muted">
                        {{ trans('frontend.main.game_date') . ': ' . $game->date->format('H:i d-m-Y') }}
                    </h3>
                    <h3 class="section-subheading text-muted">
                        {{ trans('frontend.main.stadium') . ': ' . $game->place }}
                    </h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <table class="table table-hover center-block">
                        <thead>
                        <tr>
                            <th>{{ trans('frontend.main.player_name') }}</th>
                            <th>{{ trans('frontend.main.game_visit') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($playerList as $player)
                            <tr>
                                <td>{{ $player->name }}</td>
                                <td>
                                    <div class="material-switch pull-right">
                                        <input data-team="{{ $team->id }}" data-game="{{ $game->id }}" class="switcher" id="someSwitchOptionSuccess_{{ $player->id }}" name="someSwitchOption001" type="checkbox"/>
                                        <label for="someSwitchOptionSuccess_{{ $player->id }}" class="label-success"></label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    <script>
        $('.switcher').on('change', function () {
            $.ajax({
                url: '/game/visit/',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    visit: this.checked,
                    game_id: $(this).data('game'),
                    team_id: $(this).data('team')
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.status == 'success') {
                        swal(data.msg, "", "success")
                    }else if (data.status == 'error') {
                        swal(data.msg, "", "error")
                    }
                },
                error: function (error) {
                    swal("{{ trans('frontend.main.visit_add_error') }}", "", "error");
                }
            });
        });
    </script>
@endsection