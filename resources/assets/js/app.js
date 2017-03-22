/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.prototype.trans = (key) => {
    return _.get(window.trans, key, key);
};

import TeamStats from './components/TeamStats.vue';
import PlayersStats from './components/PlayersStats.vue';
import Statistics from './components/Statistics.vue';
import Schedule from './components/Schedule.vue';

const app = new Vue({
    el: '#app',
    components: {
        'team-stats': TeamStats,
        'players-stats': PlayersStats,
        'statistics': Statistics,
        'schedule': Schedule
    }
});