<template>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2 class="section-heading">{{ game.teamB }}</h2>

            <div class="game-team-logo">
                <img :src="game.logoB"/>
            </div>

            <h3 class="section-subheading text-muted">
                {{ trans('frontend.main.game_date') }} : {{ game.date }} |
                {{ trans('frontend.main.stadium') }} : {{ game.place }}
            </h3>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['game'],
        data () {
            return {};
        }
    }
</script>