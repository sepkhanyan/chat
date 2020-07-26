<template>
    <div class="chat">
        <h1>{{ user ? user.name : 'Select a User' }}</h1>
        <div class="messagebox" ref="box">
        	<ul>
        		<li v-for="message in messages" :class="`message${message.to == user.id ? ' sent' : ' received'}`" :key="message.id">
        			<div class="text">
        				{{ message.text }}
        			</div>
        		</li>
        	</ul>
        </div>

        <div v-if="user" class="textbox">
       		<textarea v-model="message" @keyup.enter="sendMessage" placeholder="Type message here..."></textarea>
       	</div>
    </div>
</template>

<script>
    export default {
        name: 'ChatMessages',
        props: {
            user: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                default: []
            }
        },
        data(){
        	return {
        		message: ''
        	}
        },
         methods: {
            sendMessage() {
                if (this.message) {
                	let data = {
                		user_id: this.user.id,
                      	text: this.message
                	};
                	this.message = '';
                    axios.post('/send/message', data).then(({data}) => {
                        	this.$emit('new', data);
                      })
                  }
            },
            scrollToBottom() {
                 this.$refs.box.scrollTop = this.$refs.box.scrollHeight - this.$refs.box.clientHeight;
            }
        },
         watch: {
            user(user) {
                this.scrollToBottom();
            },
            messages(messages) {
                this.scrollToBottom();
            }
        }
    }
</script>
<style lang="scss" scoped>
::-webkit-scrollbar {
    width: 0px;
    background: transparent;
}

.chat {
	max-height: 100%;
    height: 500px;
    flex: 5;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    h1 {
        font-size: 20px;
        margin-bottom: 15px;
    }
}
.messagebox {
	overflow-y: scroll;
    scrollbar-width: none;
    -ms-overflow-style: none;
    background: #f0f0f0;
    height: 100%;
    max-height: 470px;
    border-radius: 5px;
    ul {
        list-style-type: none;
        padding: 10px;
        li {
            &.message {
                margin: 10px 0;
                width: 100%;
                .text {
                   max-width: 200px;
    				border-radius: 5px;
   					padding: 5px 10px;
    				display: inline-block;
                }
                &.received {
                    text-align: right;
                    .text {
                        background: #b2b2b2;
                    }
                }
                &.sent {
                    text-align: left;
                    .text {
                        background: #81c4f9;
                    }
                }
            }
        }
    }
}
.textbox textarea {
    width: 100%;
    margin: 10px 0;
    resize: none;
    border-radius: 3px;
    border: 1px solid lightgray;
    padding: 15px;
}
</style>