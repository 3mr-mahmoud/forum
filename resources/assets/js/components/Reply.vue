<script>
import Favorite from './Favorite.vue';
	export default {
		props:['attributes','path'],
		components: { Favorite },
		data() {
			return {
				editing: false,
				body:this.attributes.body
			};
		},
		methods: {
			update() {
				axios.patch(this.path,{
					body: this.body
				}).then(response => {
					this.editing = false;
					flash('Updated!');
				});

			},
			destroy() {
				axios.delete(this.path).then(response => {
					$(this.$el).fadeOut(300,() => {
						flash('Deleted!');
					});
					
				});
			}
		}
	}
</script>