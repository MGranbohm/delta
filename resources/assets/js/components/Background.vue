<script>
    import particles from "particles.js";
    import axios from "axios";

    export default {
        props: ['posturl'],

        data() {
            return {
                message: '',
                mood: '',
                messages: '',
            }
        },

        mounted() {
            this.$nextTick(function () {
                this.getMessages();
            })
        },

        created() {
            particlesJS.load('particles-js', 'assets/particles.json', function() {
                console.log('callback - particles.js config loaded');
            });
        },

        methods: {
            wasSentByUser(message) {
                return true;
            },

            getMessages() {
                axios.get(this.posturl +"/messages/all")
                    .then(response => {
                        console.log(response);
                        this.messages = response.data;
                    }).catch(error => {
                });
                this.scrollToBottom();
            },

            scrollToBottom() {
                this.chatBox = document.getElementById('chat-box');
                setTimeout(() => { this.chatBox.scrollTop = this.chatBox.scrollHeight; }, 0);
            },

            post() {
                axios.post(this.posturl +"/message", this.getData())
                    .then(response => {
                        let msg = new SpeechSynthesisUtterance(response.data.response.body);
                        console.log(response);
                        console.log(response.data);
                        window.speechSynthesis.speak(msg);
                        this.getMessages();
                    }).catch(error => {

                    });
            },

            getData() {
                return {
                    message: this.message,
                }
            },
        }
    };
</script>
