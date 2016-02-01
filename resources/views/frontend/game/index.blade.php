@extends('frontend.main')

@section('content')
    <section class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">{{ $game->team }}</h2>
                    <h3 class="section-subheading text-muted">
                        {{ trans('frontend.main.game_date') . ': ' . $game->date->format('H:i d-m-Y') }} |
                        {{ trans('frontend.main.stadium') . ': ' . $game->place }}
                    </h3>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-md-offset-4">

                    @include('frontend.game.partitions.siblings', ['siblings' => $gameSiblings])

                    <table class="table table-hover">
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
                                        @if(isset(Auth::user()->player->id) && Auth::user()->player->id == $player->id && $game->isEditable())
                                        <input {{ isset($visitList[$player->id]) ? 'checked="checked"' : '' }}
                                               data-team="{{ $team->id }}"
                                               data-game="{{ $game->id }}" class="switcher"
                                               id="someSwitchOptionSuccess_{{ $player->id }}" name="someSwitchOption001"
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
                    } else if (data.status == 'error') {
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