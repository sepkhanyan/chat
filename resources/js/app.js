require('./bootstrap');

import Vue from 'vue';
import Chats from './components/chats';

new Vue({
    el: '#app',
    components: {
        Chats
    }
});
