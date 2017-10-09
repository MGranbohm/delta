<script>
import particles from "particles.js";

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
    		var msg = new SpeechSynthesisUtterance(this.message);
			window.speechSynthesis.speak(msg);
    	},

    }
};
</script>
