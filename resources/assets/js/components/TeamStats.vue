<template>
    <div>
        <div class="row team-header-block">
            <div class="col-md-5">
                <div class="team-header-logo">
                    <img :src="team.logo" :title="team.name"/>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-1">
                <div class="team-header">
                    <h2 class="section-heading">{{ team.name }}</h2>

                    <div class="row team-header-info">
                        <div class="col-md-10">

                            <leagues-menu :activeLeague="activeLeague" :leagues="leagues" :subclass="menuClass" :action="menuAction"></leagues-menu>

                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>{{ trans('frontend.team.games_played') }}</td>
                                    <td>{{ team.playedGames }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('frontend.team.wins') }}</td>
                                    <td>{{ team.wins }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('frontend.team.draws') }}</td>
                                    <td>{{ team.draws }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('frontend.team.looses') }}</td>
                                    <td>{{ team.looses }}</td>
                                </tr>
                                <tr>
                                    <td>{{ trans('frontend.team.goals_scored_missed') }}</td>
                                    <td>{{ team.goalsData }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
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
          'spinner' : Spinner,
           'leagues-menu': LeaguesMenu
        },
        data () {
            return {
                team: {},
                showSpinner: true,
                leagues: [],
                activeLeague: '',
                menuClass: 'nav-pills',
                menuAction: 'showLeague'
            }
        },
        created () {
            axios.get('/api/leagues/all').then(response => this.leagues = response.data).catch(error => console.log(error));

            axios.get('/api/team/stats').then(response =>{
                this.team = response.data;
                this.showSpinner = false;
            }).catch(error => console.log(error));

            bus.$on('showLeague', leagueId => this.showLeague(leagueId));
        },
        methods: {
            showLeague (leagueId = '') {
                this.showSpinner = true;
                axios.get('/api/team/stats', {
                    params: {
                        leagueId
                    }
                }).then(response =>{
                    this.team = response.data;
                    this.activeLeague = leagueId;
                    this.showSpinner = false;
                }).catch(error => console.log(error));
            }
        }
    }
</script>

<style>
    .nav {
        margin-bottom: 5px;
    }
</style>