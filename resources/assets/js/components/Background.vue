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
                audio: '',
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

            getAudio(message) {
                axios.get(this.posturl + "/sound/" + message)
                    .then(response => {
                        this.audio = response.data;
                        let music = this.$refs.audio;
                        setTimeout(() => { music.play(); }, 10);
                    }).catch(error => {
                        console.log(error);
                    });
            },

            getMessages() {
                axios.get(this.posturl +"/messages/all")
                    .then(response => {
                        this.messages = response.data;
                    }).catch(error => {
                        console.log(error);
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
//                        let msg = new SpeechSynthesisUtterance(response.data.response.body);
//                        window.speechSynthesis.speak(msg);
                        this.getMessages();
                        this.getAudio(response.data.response.id);
                    }).catch(error => {
                        console.log(error);
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
