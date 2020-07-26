<template>
    <div class="users-list">
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action"
                v-for="user in users" 
                :key="user.id" 
                @click="selectUser(user)" 
                :class="{ 'selected': user == selected }">
                    {{ user.name }}
                <span class="unread" v-if="user.unread">{{ user.unread }}</span>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ChatUsers',
         props: {
            users: {
                type: Array,
                default: []
            }
        },
        data() {
            return {
                selected: null
            };
        },
        methods: {
            selectUser(user) {
                this.selected = user;
                this.$emit('selected', user);
            }
        },
    }
</script>
<style lang="scss" scoped>
.users-list {
    max-height: 100%;
    height: 500px;
    overflow-y: scroll;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

::-webkit-scrollbar {
    width: 0px;
    background: transparent;
}
.unread {
   background: #3490dc;
    color: #fff;
    position: absolute;
    right: 15px;
    top: 15px;
    display: flex;
    font-weight: 700;
    min-width: 20px;
    justify-content: center;
    align-items: center;
    line-height: 20px;
    font-size: 12px;
    padding: 0 10px;
    border-radius: 10px;
}
</style>
