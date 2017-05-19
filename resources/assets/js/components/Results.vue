<template>
    <div v-if="game">
        <div>{{ game.teamA }} - {{ game.teamB }} ( {{ game.date }})</div>

        <hr/>

        <div>
            <form>
                <select name="stat" v-model="stat">
                    <option value="goal">Goal</option>
                    <option value="assist">Assist</option>
                    <option value="yc">YC</option>
                    <option value="RC">RC</option>
                </select>
                <select name="player" v-model="player">
                    <option v-for="player in players" :value="player.id">{{ player.name }}</option>
                </select>
                <select name="value" v-model="value">
                    <option v-for="n in 20" :value="n">{{ n }}</option>
                </select>
                <button type="submit" @click.prevent="addStat">Add</button>
            </form>
        </div>

        <hr/>
        <div>
            <p>Goals:</p>
            <ul>
                <li v-for="stat in game.results.goal">
                    {{ stat.player }} {{ stat.count }} <a href="#" @click.prevent="removeStat(stat.stat_id)">x</a>
                </li>
            </ul>
        </div>
        <div>
            <p>Assists:</p>
            <ul>
                <li v-for="stat in game.results.assist">
                    {{ stat.player }} {{ stat.count }} <a href="#" @click.prevent="removeStat(stat.stat_id)">x</a>
                </li>
            </ul>
        </div>
        <div>
            <p>YCs:</p>
            <ul>
                <li v-for="stat in game.results.yc">
                    {{ stat.player }} {{ stat.count }} <a href="#" @click.prevent="removeStat(stat.stat_id)">x</a>
                </li>
            </ul>
        </div>
        <div>
            <p>RCs:</p>
            <ul>
                <li v-for="stat in game.results.rc">
                    {{ stat.player }} {{ stat.count }} <a href="#" @click.prevent="removeStat(stat.stat_id)">x</a>
                </li>
            </ul>
        </div>
        <spinner v-show="showSpinner"></spinner>
    </div>
</template>


<script>
    import Spinner from './partials/Spinner.vue';

    export default {
        components: {
            'spinner': Spinner
        },
        props: ['id'],
        data () {
            return {
                showSpinner: true,
                game: null,
                players: [],
                stat: 'goal',
                player: null,
                value: 1
            }
        },
        created() {
            axios.get('/api/games/result/' + this.id)
                .then(response => {
                    this.game = response.data;
                    axios.post('/api/players/filter',
                        {
                            'players': [],
                            'leagues': [],
                            'tournaments': [this.game.tournamentId]
                        }
                    ).then(response => {
                        this.players = response.data;
                        this.player = this.players[0].id;
                        this.showSpinner = false;
                    }).catch(error => console.log(error));
                })
                .catch(error => console.log(error)
                );
        },
        computed: {
            teams() {
                return this.game != null ? this.game.teamA + ' - ' + this.game.teamB : '';
            }
        },
        methods: {
            addStat() {
                this.showSpinner = true;
                axios.post('/api/stats/add',
                    {
                        'player_id': this.player,
                        'game_id': this.game.id,
                        'parameter': this.stat,
                        'value': this.value
                    }
                ).then(response => {
                    this.updateGame();
                    this.showSpinner = false;
                }).catch(error => console.log(error));
            },
            removeStat(id) {
                this.showSpinner = true;
                axios.post('/api/stats/remove',
                    {
                        'id': id
                    }
                ).then(response => {
                    this.updateGame();
                    this.showSpinner = false;
                }).catch(error => console.log(error));
            },
            updateGame() {
                axios.get('/api/games/result/' + this.game.id)
                    .then(response => {
                        this.game = response.data;
                    })
                    .catch(error => console.log(error)
                    );
            }
        }
    }
</script>

<style>

</style>