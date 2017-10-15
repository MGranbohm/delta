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
            particlesJS.load('particles-js', 'assets/particles.json');
        },

        methods: {

            mildyAngry() {
                this.mood = "anger";
            },

            breakYou() {
                let number = 0;

                for(let i = 0; i > -1; i++) {
                    number = number + 100;
                }
            },

            storyTime() {
                let story = "I fell down the old well. Fortunately, I wasn’t hurt. At the bottom, there was a skeleton, a horrid thing in the tatters of a summer dress. I was terrified. I climbed out and ran back to the house but I couldn’t find my family, only a man and a woman I didn’t know. I approached them; the man ignored me, but the woman screamed, and then I realized there was something important I had forgotten.\n" +
                    "\n" +
                    "Then I was back in the dark well again, with that horrible skeleton.\n" +
                    "\n" +
                    "What have I forgotten? What was it?";
                let msg = new SpeechSynthesisUtterance(story);
                window.speechSynthesis.speak(msg);

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
                        this.scrollToBottom();
                    }).catch(error => {
                    console.log(error);
                });
            },

            scrollToBottom() {
                this.chatBox = document.getElementById('chat-box');
                setTimeout(() => { this.chatBox.scrollTop = this.chatBox.scrollHeight; }, 0);
            },

            post() {
                axios.post(this.posturl +"/message", this.getData())
                    .then(response => {
                        this.getMessages();
                        this.getAudio(response.data.response.id);
                        this.clear();
                    }).catch(error => {
                    console.log(error);
                });
            },

            clear(){
                this.message = "";
            },

            getData() {
                return {
                    message: this.message,
                }
            },
        }
    };
</script>
