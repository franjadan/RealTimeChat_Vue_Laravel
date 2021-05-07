<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Messages</h2>
            <div v-for="message in messages" :key="message.id">
                @{{ message.user.name }}: {{ message.message }}
            </div>

            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="Escribe un mensaje..." v-model="newMessage" @keyup.enter="sendMessage">
                <button class="btn btn-primary" @click="sendMessage"> Send</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            newMessage: ''
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