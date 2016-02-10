@extends('frontend.main')

@section('content')
    <section class="bg-light-gray football-bg-2">
        <div class="container">
            <div class="row player-header-block">
                <div class="col-md-4">
                    <div class="player-header-logo">
                        <img src="{{ $player->getPhotoLink() }}" title=""/>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="player-header">
                        <h2 class="section-heading">{{ $player->name }}</h2>

                        <h3 class="section-subheading text-muted">
                            <img class="player-team-logo"
                                 src="{{ $player->team->getLogoLink() }}"/> {{ $player->team->name }}
                        </h3>

                        <div class="player-header-info">
                            <table class="table" width="200px">
                                <tbody>
                                <tr>
                                    <td>
                                        <i class="ic ic-visits" title="{{ trans('frontend.players.games_played') }}">
                                            &nbsp;
                                        </i>
                                    </td>
                                    <td>{{ $stats->visits }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="ic ic-goals" title="{{ trans('frontend.players.goals') }}">
                                            &nbsp;
                                        </i>
                                    </td>
                                    <td>{{ $stats->goals }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="ic ic-assists" title="{{ trans('frontend.players.assists') }}">
                                            &nbsp;
                                        </i>
                                    </td>
                                    <td>{{ $stats->assists }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="ic ic-yc" title="{{ trans('frontend.players.ycs') }}">
                                            &nbsp;
                                        </i>
                                    </td>
                                    <td>{{ $stats->ycs }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="ic ic-rc" title="{{ trans('frontend.players.rcs') }}">
                                            &nbsp;
                                        </i>
                                    </td>
                                    <td>{{ $stats->rcs }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection