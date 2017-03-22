<template>

    <div class="football-block">
        <schedule-game :game="game"></schedule-game>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <schedule-siblings :nextGameId="game.nextGameId" :prevGameId="game.prevGameId"></schedule-siblings>

                <schedule-visits :visits="game.visits"></schedule-visits>
            </div>
        </div>
        <spinner v-show="showSpinner"></spinner>
    </div>

</template>

<script>
    import ScheduleGame from './partials/ScheduleGame.vue';
    import ScheduleSiblings from './partials/ScheduleSiblings.vue';
    import ScheduleVisits from './partials/ScheduleVisits.vue';
    import Spinner from './partials/Spinner.vue';
    import swal from 'sweetalert2';

    export default {
        components: {
            'schedule-game': ScheduleGame,
            'schedule-siblings': ScheduleSiblings,
            'schedule-visits': ScheduleVisits,
            'spinner' : Spinner
        },
        data () {
            return {
                'game': {},
                'gameId': 0,
                showSpinner: true
            };
        },
        created () {
            if (typeof gameId != 'undefined') {
                this.gameId = gameId;
            }

            axios.get('/api/games/' + this.gameId)
                .then(response => {
                    this.game = response.data;
                    this.showSpinner = false;
                }).catch(error => console.log(error));


            bus.$on('changedVisit', (value) => {
                this.showSpinner = true;
                axios.post('/api/update-visit', {
                    'value' : value,
                    'game_id': this.game.id
                }).then(response => {
                    this.showSpinner = false;
                    let msgType = 'success';
                    if (response.data.status == 'error') {
                        msgType = 'error';
                    }

                    swal({
                        title: response.data.msg,
                        text: '',
                        type: msgType,
                        confirmButtonText: 'Ok'
                    })
                }).catch(error => console.log(error));
            });
        },
        computed: {
            hasNextGame () {
                return this.game.nextGameId != null;
            },
            hasPrevGame () {
                return this.game.prevGameId != null;
            }
        }
    }
</script>

<style></style>