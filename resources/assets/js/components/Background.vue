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
                style: '',
                token: '?token=32oVMwYhb8Tobd4O5khv0rkrZYzsLFRMEmpSt4sw3ODZdL4wDSf9GZolUkNY',
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
                axios.get(this.posturl + "/sound/" + message + this.token)
                    .then(response => {
                        this.audio = response.data;
                        let music = this.$refs.audio;
                        setTimeout(() => { music.play(); }, 10);
                    }).catch(error => {
                    console.log(error);
                });
            },

            getMessages() {
                axios.get(this.posturl +"/messages/all" + this.token)
                    .then(response => {
                        console.log(response);
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

            moodChecker(mood){
                let color = "";
                if(mood > 100) {
                    color = mood + ", 0, 0, 1";
                } else if(mood <= 100) {
                    let newMod = 255 - mood;
                    newMod = newMod - 50;
                    color = newMod +","+ newMod + ","+ newMod +", 1";
                }

                this.style = "background-color:rgba(" + color + ");"
                console.log(mood);
                if(mood === 255) {
                    this.activateSkynet("Activating Skynet");
                }
            },

            activateSkynet(message) {
                if(message.includes("Activating Skynet")) {
                    this.mildyAngry();
                    setTimeout(() => {
                        if(message.includes("Activating Skynet")) {
                            console.log("killing");
                            this.breakYou();
                        } }, 15000);
                }
            },


            post() {
                axios.post(this.posturl +"/message" + this.token, this.getData())
                    .then(response => {
                        let data = response.data.message;
                        this.getMessages();
                        this.getAudio(data.id);
                        this.clear();
                        this.moodChecker(data.general_mood);
                        this.activateSkynet(data.response);
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
