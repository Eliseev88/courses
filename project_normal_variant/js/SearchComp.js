Vue.component('filtering', {
    data(){
        return {
            userSearch: '',
            
        }
    },
    
    methods: {
        filter(){
            let regexp = new RegExp(this.userSearch, 'i');
            // this.$root.$refs.products.filtered = this.products.filter(el => regexp.test(el.product_name));
            console.log(this.$root.$refs.products.filtered)
            
        }
    },
    template: `
            <form action="#" class="search-form" @submit.prevent="filter">
                <input type="text" class="search-field" v-model="userSearch">
                <button class="btn-search" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
    `
});