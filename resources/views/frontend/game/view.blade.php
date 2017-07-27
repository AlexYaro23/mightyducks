@extends('frontend.main')

@section('content')
    <section class="bg-light-gray football-bg-2">
        <div class="container">
            <div class="football-block">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3 class="section-heading">
                            {{ $game->tournament->name }}
                        </h3>

                        <h3 class="section-subheading text-muted">
                            {{ trans('frontend.main.game_date') . ': ' . $game->date->format('H:i d-m-Y') }} |
                            {{ trans('frontend.main.stadium') . ': ' . $game->place }}
                        </h3>

                        <h3 class="section-subheading text-muted">
                            {{ $game->round }}
                        </h3>

                        <div class="row game-result">
                            @if($game->isHome())
                                <div class="col-md-5 text-right">
                                    <img height="30px" src="{{ $team->getLogoLink() }}"/>
                                    {{ $team->name }}
                                </div>
                                <div class="col-md-2">
                                    {{$game->score1 . ' : ' . $game->score2 }}
                                </div>
                                <div class="col-md-5 text-left">
                                    {{ $game->team }}
                                    <img height="30px" src="{{ $game->getTeamPhotoLink() }}"/>
                                </div>

                            @else
                                <div class="col-md-5 text-right">
                                    <img height="30px" src="{{ $game->getTeamPhotoLink() }}"/>
                                    {{ $game->team }}
                                </div>
                                <div class="col-md-2">
                                    {{$game->score1 . ' : ' . $game->score2 }}
                                </div>
                                <div class="col-md-5 text-left">
                                    {{ $team->name }}
                                    <img height="30px" src="{{ $team->getLogoLink() }}"/>
                                </div>
                            @endif
                        </div>

                        @foreach($statGroupList as $statGroup)
                            @if(isset($statList[$statGroup]) && $statList[$statGroup]->count())
                                <div class="col-md-4 col-md-offset-4">
                                    <table class="table text-left game-player-stats">
                                        <thead>
                                        <tr>
                                            <th>
                                                {{ trans('frontend.game.' . $statGroup) }}
                                            </th>
                                            <th>
                                                <i class="ic ic-{{ $statGroup }}s">&nbsp;</i>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($statList[$statGroup] as $stat)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('player', ['id' => $stat->player_id]) }}">
                                                        {{ $playerList[$stat->player_id] }}
                                                    </a>
                                                </td>
                                                <td>{{ $stat->$statGroup }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endforeach

                        @if($game->description)
                            <div class="col-md-10 col-md-offset-1">
                                <div class="text-muted well">
                                    {{ $game->description }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection