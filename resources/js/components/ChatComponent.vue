<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Messages</h2>
            <div class="card mx-2 my-2 bg-light" >
                <div :class="{'card mx-2 my-2 col-md-5 p-2 message rounded align-self-end': message.user.id == userId, 'card mx-2 my-2 col-md-5 p-2 message rounded': message.user.id != userId }" v-for="message in messages" :key="message.id">
                    <div v-if="message.user.id == userId">
                        <p style="margin: 0px;">{{ message.message }}</p>
                        <p style="font-size: 10px; margin: 0px;" class="text-right">{{ message.created_at }}</p>
                    </div>

                    <div v-if="message.user.id != userId">
                        <h6><i>@{{ message.user.name }}</i></h6>
                        <p style="margin: 0px;">{{ message.message }}</p>
                        <p style="font-size: 10px; margin: 0px;" class="text-right">{{ message.created_at | moment }}</p>
                    </div>

                </div>
            </div>

            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Escribe un mensaje..." v-model="newMessage" @keyup.enter="sendMessage">
                <button class="btn btn-primary" @click="sendMessage"> Send</button>
            </div>
        </div>
    </div>
</template>

<script>

import moment from 'moment';

export default {
    data() {
        return {
            messages: [],
            newMessage: '',
            userId: this.$props.currentuserid
        }   
    },

    props: ['currentuserid'],

    filters: {
        moment: function (date) {
            return moment(date).format('MM/DD/YYYY hh:mm');
        }
    },

    created() {
        this.fetchMessages();

        Echo.private('chat')
            .listen('MessageSentEvent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user
                });
            });
    },

    methods: {
        fetchMessages() {
            axios.get('/mensajes').then(response => {
                this.messages = response.data;
            });
        },

        addMessage(message) {

            axios.post('/mensajes/nuevo', {message})
                .then(response => {                    
                    this.messages.push({
                        message: response.data.message.message,
                        user: response.data.user
                    });
                }).catch(err => {
                    alert("Error el enviar el mensaje.");
                    console.log(err);
                });
        },

        sendMessage() {
            this.addMessage(this.newMessage);
            this.newMessage = '';
        }
    }
}
</script>