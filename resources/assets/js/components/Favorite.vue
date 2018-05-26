<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply','path'],
        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited
            }
        },
        computed: {
            classes() {
                return [
                    'btn',
                    this.active ? 'btn-primary' : 'btn-default'
                ];
            }
        },
        methods: {
            toggle() {
                this.active ? this.destroy() : this.create();
            },
            create() {
                axios.post(this.path).then(() => {
                this.active = true;
                this.count++; 
                });
                
            },
            destroy() {
                axios.delete(this.path).then(() => {
                this.active = false;
                this.count--;
                });
                
            }
        }
    }
</script>