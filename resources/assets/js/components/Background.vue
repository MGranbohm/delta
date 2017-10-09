<script>
import particles from "particles.js";
export default {

    data() {
        return {

        }
    },

    created() {
		particlesJS.load('particles-js', 'assets/particles.json', function() {
		  console.log('callback - particles.js config loaded');
		});
    },

    methods: {


    }
};
</script>
