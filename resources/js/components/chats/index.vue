<template>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="card users-box">
                    <div class="card-header">
                        Users
                    </div>

                    <div class="card-body users">
                         <chat-users :users="users" @selected="startChat"/>
                    </div>
                </div>
            </div>

            <div class="col-8">
                <div class="card users-box">
                    <div class="card-header">
                        Chat
                    </div>
                    
                    <div class="card-body users">
                        <chat-messages :loading="chatLoading" :user="selectedUser" :messages="messages" @new="newMessage" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ChatUsers from './ChatUsers';
    import ChatMessages from './ChatMessages';
    export default {
        name: 'Chat',
        components: {
            ChatUsers,
            ChatMessages
        },
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data(){
            return {
                selectedUser: null,
                messages: [],
                users: [],
                chatLoading: false
            }
        },
        mounted(){
            Echo.private(`chat.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    this.hanleIncoming(e.message);
                });
        },
        created(){
            this.getUsers();
        },
        methods: {
            getUsers(){
                axios.get('/users')
                .then(({data}) => {
                    this.users = data;
                });
            },
             startChat(user) {
                this.chatLoading = true;
                this.selectedUser = user;
                this.updateUnreadCount(user, true);
                axios.get(`/chat/${user.id}`)
                    .then(({data}) => {
                        this.chatLoading = false;
                        this.messages = data;
                    })
            },
            hanleIncoming(message) {
                if (this.selectedUser && message.from == this.selectedUser.id) {
                    this.newMessage(message);
                    return;
                }
                this.updateUnreadCount(message.from_user, false);
            },
            newMessage(message){
                this.messages.push(message);
            },
            updateUnreadCount(user, bool) {
                this.users = this.users.map((u) => {
                    if (u.id !== user.id) {
                        return u;
                    }
                    if (bool)
                        u.unread = 0;
                    else
                        u.unread += 1;
                    return u;
                })
            }
        }
    }
</script>
