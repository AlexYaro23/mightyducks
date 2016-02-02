@extends('frontend.main')

@section('content')
    <section class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">{{ $team->name }}</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p>{{ trans('frontend.team.team') }}</p>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ trans('frontend.team.player_name') }}</th>
                            <th>{{ trans('frontend.team.visits') }}</th>
                            <th>{{ trans('frontend.team.goals') }}</th>
                            <th>{{ trans('frontend.team.assists') }}</th>
                            <th>{{ trans('frontend.team.ycs') }}</th>
                            <th>{{ trans('frontend.team.rcs') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($playerList as $player)
                            <tr>
                                <td>
                                    {{ $player->name }}
                                </td>
                                <td>{{ $statList[$player->id]->visits }}</td>
                                <td>{{ $statList[$player->id]->goals }}</td>
                                <td>{{ $statList[$player->id]->assists }}</td>
                                <td>{{ $statList[$player->id]->ycs }}</td>
                                <td>{{ $statList[$player->id]->rcs }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <p>{{ trans('frontend.team.calendar') }}</p>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ trans('frontend.team.date') }}</th>
                            <th>{{ trans('frontend.team.tournament') }}</th>
                            <th>{{ trans('frontend.team.opponent') }}</th>
                            <th>&nbsp;</th>
                            <th>{{ trans('frontend.team.score') }}</th>
                            <th></th>
                            <th>{{ trans('frontend.team.place') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($gameList as $game)
                                <tr>
                                    <td>{{ $game->date->format('d-m-Y | H:i') }}</td>
                                    <td>{{ $game->tournament->name }}</td>
                                    <td>{{ $game->team }}</td>
                                    <td>{{ $game->isHome() ? trans('frontend.team.home') : trans('frontend.team.guest') }}</td>
                                    <td>{{ $game->score1 . ' : ' . $game->score2 }}</td>
                                    <td><span class="{{ $game->score1 > $game->score2 ? 'win' : $game->score1 == $game->score2 ? 'draw' : 'lose' }}"></span></td>
                                    <td>{{ $game->place }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection