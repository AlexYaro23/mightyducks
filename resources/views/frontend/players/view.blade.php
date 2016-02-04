@extends('frontend.main')

@section('content')
    <section class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="player-header-block">
                        <div class="player-header-logo pull-left">
                            <img src="{{ $player->getPhotoLink() }}" title=""/>
                        </div>

                        <div class="player-header">
                            <h2 class="section-heading">{{ $player->name }}</h2>
                            <h3 class="section-subheading text-muted">
                                <img class="player-team-logo" src="{{ $player->team->getLogoLink() }}" /> {{ $player->team->name }}
                            </h3>
                            <div class="player-header-info">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>{{ trans('frontend.players.games_played') }}</td>
                                        <td>{{ $stats->visits }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('frontend.players.goals') }}</td>
                                        <td>{{ $stats->goals }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('frontend.players.assists') }}</td>
                                        <td>{{ $stats->assists }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('frontend.players.ycs') }}</td>
                                        <td>{{ $stats->ycs }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ trans('frontend.players.rcs') }}</td>
                                        <td>{{ $stats->rcs }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection