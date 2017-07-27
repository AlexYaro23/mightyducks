<template>
    <section class="bg-light-gray football-bg-2">
        <div class="container">

            <div class="row stats-filter">
                <div class="col-md-12">
                    <h3 class="section-heading text-center">{{ trans('frontend.video.subtitle') }}</h3>

                    <div class="form-group">
                        <label>{{ trans('frontend.stats.players') }}</label>
                        <select name="game" v-model="game" class="form-control" @change="updateLinks">
                            <option v-for="game in games" :value="game.id">{{ showGameTitle(game) }}</option>
                        </select>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row stats-block">

                <div class="col-md-10 col-md-offset-1" v-if="description">
                    <div class="text-muted well">
                        {{ description }}
                    </div>
                </div>

                <br />

                <div class="col-md-12">
                    <template v-for="link in links">
                        <div class="col-md-8 col-md-offset-2 col-sm-12" style="margin-bottom: 30px;">
                            <div class="video-container">
                                <iframe width="560" height="315" :src="link" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <br />
                    </template>
                </div>
            </div>
        </div>
        <spinner v-show="showSpinner"></spinner>
    </section>
</template>

<script>
    import Spinner from './partials/Spinner.vue';

    export default {
        components: {
            'spinner': Spinner
        },
        props: [
            'games'
        ],
        data () {
            return {
                showSpinner: false,
                game: null,
                links: [],
                description: ''
            }
        },
        created () {
            this.game = this.games[0].id;
            this.links = this.games[0].youtube.split("\n");
            this.description = this.games[0].description;
        },
        computed: {},
        methods: {
            showGameTitle(game) {
                return game.team + ' ' + game.date.substring(0, 10);
            },

            updateLinks() {
                this.showSpinner = true;
                for (let i = 0; i < this.games.length; i++) {
                    if (this.games[i].id == this.game) {
                        this.links = this.games[i].youtube.split("\n");
                        this.description = this.games[i].description;
                    }
                }
                var self = this;
                setTimeout(function () {
                    self.showSpinner = false
                }, 1000);

            }
        }
    }
</script>

<style>
    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        padding-top: 30px;
        height: 0;
        overflow: hidden;
    }

    .video-container iframe, .video-container object, .video-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>