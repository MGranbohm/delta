<script>
import particles from "particles.js";
import axios from "axios";

export default {

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
    	    axios.post(this.posturl, this.getData())
                .then(function (response) {
                    
                }).catch(function (errors) {
                
                })
        }
    }
};
</script>
