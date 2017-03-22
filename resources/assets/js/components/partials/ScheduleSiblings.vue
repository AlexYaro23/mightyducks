<template>
    <div>
        <div class="col-md-1 text-left">
            <a :href="prevGameUrl" class="prev-game" v-show="prevGameId">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </a>
        </div>
        <div class="col-md-10 text-center">
            {{ trans('frontend.game.move_to_sibling') }}
        </div>
        <div class="col-md-1 text-right">
            <a :href="nextGameUrl" class="next-game" v-show="nextGameId">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['nextGameId', 'prevGameId'],
        data () {
            return {
                gameUrl: '/game/visit/'
            };
        },
        methods: {
            showPrevGame () {
                bus.$emit('showPrevGame');
            },
            showNextGame () {
                bus.$emit('showNextGame');
            }
        },
        computed: {
            prevGameUrl () {
                return this.gameUrl + this.prevGameId;
            },
            nextGameUrl () {
                return this.gameUrl + this.nextGameId;
            }
        }
    }
</script>