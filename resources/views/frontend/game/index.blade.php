@extends('frontend.main')

@section('content')
    <section class="bg-light-gray football-bg-2">
        <div class="container">

            <div class="football-block">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="section-heading">{{ $game->team }}</h2>

                        <div class="game-team-logo">
                            <img src="{{ $game->getTeamPhotoLink() }}" />
                        </div>

                        <h3 class="section-subheading text-muted">
                            {{ trans('frontend.main.game_date') . ': ' . $game->date->format('H:i d-m-Y') }} |
                            {{ trans('frontend.main.stadium') . ': ' . $game->place }}
                        </h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
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
                                        <div class="visit-label-block pull-right">
                                            @if(Auth::user() != null && Auth::user()->player != null && Auth::user()->player->id == $player->id && $game->isEditable())
                                                <select data-team="{{ $team->id }}" data-game="{{ $game->id }}"
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
        $('.switcher').on('change', function () {
            $.ajax({
                url: '/game/visit',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    visit: this.value,
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

        $(".football-block").on("swipeleft",function(){
            alert("You swiped left!");
        });
    </script>
@endsection