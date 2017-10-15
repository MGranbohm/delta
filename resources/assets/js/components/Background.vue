<script>
    import particles from "particles.js";
    import axios from "axios";

    export default {
        props: ['posturl'],

        data() {
            return {
                message: '',
                mood: '',
            }
        },

        created() {
            particlesJS.load('particles-js', 'assets/particles.json', function() {
                console.log('callback - particles.js config loaded');
            });
        },

        methods: {
            read(){
                if(this.message === "fuck you") {
                    this.mood = "anger";
                    this.message = "No, Fuck you!"
                }
                let msg = new SpeechSynthesisUtterance(this.message);
                window.speechSynthesis.speak(msg);
            },

            post() {
                axios.post(this.posturl +"/message" + this.updateId, this.getFormData())
                    .then(response => {
                        console.log(response);
                    }).catch(error => {
                    this.isLoading = false;
                    this.errors = error.response.data.errors;
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
