<template>
    <div class="row">
        <div class="col-md-12">
            <div class="team-body-block">
                <!--<ul class="nav nav-tabs" role="tablist">-->
                    <!--<li role="presentation" class="active">-->
                        <!--<a href="#players" aria-controls="players" role="tab"-->
                           <!--data-toggle="tab">-->
                            <!--<p>{{ trans('frontend.team.team') }}</p>-->
                        <!--</a>-->
                    <!--</li>-->
                <!--</ul>-->

                <leagues-menu :activeLeague="activeLeague" :leagues="leagues" :subclass="menuClass" :action="menuAction"></leagues-menu>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="players">
                        <table class="table table-hover player-stats table-mobile">
                            <thead>
                            <tr>
                                <th>{{ trans('frontend.team.player_name') }}</th>
                                <th><i class="ic ic-visits"></i></th>
                                <th><i class="ic ic-goals"></i></th>
                                <th><i class="ic ic-assists"></i></th>
                                <th><i class="ic ic-yc"></i></th>
                                <th><i class="ic ic-rc"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-for="player in players">
                                <tr>
                                    <td class="mobile-row-fix">
                                        <a :href="player.url">
                                            <img height="20px" :src="player.photo" class="player-logo"/>
                                            {{ player.name }}
                                        </a>
                                    </td>
                                    <td>{{ player.visits }}</td>
                                    <td>{{ player.goals }}</td>
                                    <td>{{ player.assists }}</td>
                                    <td>{{ player.ycs }}</td>
                                    <td>{{ player.rcs }}</td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <spinner v-show="showSpinner"></spinner>
    </div>
</template>

<script>
    import Spinner from './partials/Spinner.vue';
    import LeaguesMenu from './partials/LeaguesMenu.vue';

    export default {
        components: {
            'spinner': Spinner,
            'leagues-menu': LeaguesMenu
        },
        data () {
            return {
                players: {},
                showSpinner: true,
                leagues: [],
                activeLeague: '',
                menuAction: 'changedLeague',
                menuClass: 'nav-tabs'
            }
        },
        created () {
            axios.get('/api/leagues/all').then(response => this.leagues = response.data).catch(error => console.log(error));
            axios.get('/api/players/stats')
                .then(response => {
                    this.players = response.data;
                    this.showSpinner = false;
                })
                .catch(error => console.log(error)
            );

            bus.$on('changedLeague', leagueId => this.showForLeague(leagueId))
        },
        methods: {
            showForLeague (leagueId = '') {
                this.showSpinner = true;
                axios.get('/api/players/stats', {
                    params: {
                        leagueId
                    }
                }).then(response => {
                    this.players = response.data;
                    this.activeLeague = leagueId;
                    this.showSpinner = false;
                }).catch(error => console.log(error));
            }
        }
    }
</script>