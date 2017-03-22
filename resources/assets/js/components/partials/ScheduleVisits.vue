<template>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>{{ trans('frontend.main.player_name') }}</th>
            <th>{{ trans('frontend.main.game_visit') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="visit in visits">
            <td>{{ visit.playerName }}</td>
            <td>
                <player-visit :canSelect="visit.canSelect" :stat="visit.value"></player-visit>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    import PlayerVisit from './PlayerVisit.vue';

    export default {
        components: {
            'player-visit': PlayerVisit
        },
        props: ['visits'],
        data () {
            return {};
        }
    }
</script>