<template>
    <section class="bg-light-gray football-bg-2">
        <div class="container">

            <div class="row stats-filter">
                <div class="col-md-12">
                    <h3 class="section-heading text-center">{{ trans('frontend.stats.filter') }}</h3>

                    <div class="form-group">
                        <label>{{ trans('frontend.stats.players') }}</label>
                        <select2 name="players" :options="playerOptions" multiple v-model="selectedPlayers" @input="updatedPlayers"></select2>
                    </div>

                    <div class="form-group">
                        <label>{{ trans('frontend.stats.leagues') }}</label>
                        <select2 name="leagues" :options="leagueOptions" multiple v-model="selectedLeagues" @input="updatePlayers"></select2>
                    </div>

                    <div class="form-group">
                        <label>{{ trans('frontend.stats.tournaments') }}</label>
                        <select2 name="tournaments" :options="tournamentsOptions" multiple v-model="selectedTournaments" @input="updatePlayers"></select2>
                    </div>
                </div>
            </div>

            <div class="row stats-block">
                <div class="col-md-12">
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
    </section>
</template>

<script>
    import Select2 from './Select2.vue'

    export default {
        components: {
            Select2
        },
        data () {
            return {
                players: [],
                playersAll: [],
                leagues: [],
                tournaments: [],
                selectedPlayers: [],
                selectedLeagues: [],
                selectedTournaments: []
            }
        },
        created () {
            axios.get('/api/players/stats')
                .then(response => {
                    this.players = response.data;
                    this.playersAll = response.data;
                })
                .catch(error => console.log(error));

            axios.get('/api/leagues/all')
                .then(response => this.leagues = response.data)
                .catch(error => console.log(error));
        },
        computed: {
            playerOptions () {
                return this.playersAll.map(function (player) {
                    return {id: player.id, text: player.name};
                });
            },
            leagueOptions () {
                return this.leagues.map(function (league) {
                    return {id: league.id, text: league.name};
                });
            },
            tournamentOptions () {
                return this.tournaments.map(function (tournament) {
                    return {id: tournament.id, text: tournament.name};
                });
            }
        },
        methods: {
            updatedPlayers () {
                axios.post('/api/players/filter',
                    {
                        'players': this.selectedPlayers,
                        'leagues': this.selectedLeagues,
                        'tournaments': this.selectedTournaments
                    }
                ).then(response => this.players = response.data.players)
                    .catch(error => console.log(error));
            }
        }
    }
</script>

<style>
    #app .v-select input[type="search"], #app  .v-select input[type="search"]:focus {
        background: rgba(255, 255, 255, 1) none repeat scroll 0 0;
    }
</style>