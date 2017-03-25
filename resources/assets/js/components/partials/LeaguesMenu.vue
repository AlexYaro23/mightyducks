<template>
    <ul :class="classObject">
        <li role="presentation" v-bind:class="{ active: activeLeague == '' }">
            <a href="#" v-on:click.prevent="showLeague('')">
                <img src="/img/football/ball3.png" height="30px" />
                {{ trans('frontend.main.total') }}
            </a>
        </li>
        <template v-for="league in leagues">
            <li role="presentation" v-bind:class="{ active: activeLeague == league.id }">
                <a href="#" v-on:click.prevent="showLeague(league.id)">
                    <img :src="league.logo" height="30px" />
                    {{ league.name }}
                </a>
            </li>
        </template>
    </ul>
</template>

<script>
    export default {
        props: ['activeLeague', 'leagues', 'subclass', 'action'],
        data () {
            return {};
        },
        methods: {
            showLeague (id) {
                bus.$emit(this.action, id);
            }
        },
        computed: {
            classObject () {
                return 'nav ' + this.subclass;
            }
        }
    }
</script>