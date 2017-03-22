<template>
    <div class="visit-label-block pull-right">
        <template v-if="canSelect">
            <select class="switcher" v-model="stat" v-on:change="changedVisit">
                <template v-for="option in options">
                    <option :value="option.value">{{ option.text }}</option>
                </template>

            </select>
        </template>
        <template v-else>
            <span class="label label-success" v-if="visited">{{ trans('frontend.main.visit.yes') }}</span>
            <span class="label label-danger" v-if="notVisited">{{ trans('frontend.main.visit.no') }}</span>
            <span class="label label-default" v-if="notSelected">...</span>
        </template>
    </div>
</template>

<script>
    export default {
        props: ['canSelect', 'stat'],
        data () {
            return {
                'options': [
                    {value: '', text: ''},
                    {value: 1, text: trans.frontend.main.visit.yes},
                    {value: 2, text: trans.frontend.main.visit.no}
                ]
            };
        },
        computed: {
            visited () {
                return this.stat == 1;
            },
            notVisited () {
                return this.stat == 2;
            },
            notSelected() {
                return this.stat != 1 && this.stat != 2;
            }
        },
        methods: {
            changedVisit () {
                bus.$emit('changedVisit', this.stat);
            }
        }
    }
</script>