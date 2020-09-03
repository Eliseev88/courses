const API = 'https://raw.githubusercontent.com/Eliseev88/courses/master/project';

const vue = new Vue ({
    el: '#app',
    data: {
        catalogUrl: '/goods.json',
        basketUrl: '/getBasket.json',
        products: [],
        basket: [],
        isVisibleCart: false,
        searchLine: '',
        filtered: null,
    },
    methods: {
        getJson(url) {
            return fetch(url)
              .then(result => result.json())
              .catch(error => {
                console.log(error);
              })
          },
          addProduct(product) {
            console.log(product.id_product);
            // let find = this.basket.find(el => el.id_product == product.id_product);
            // if (!find) {
            //     this.basket.push(Object.assign(product, { quantity: 1 }));
            // } else {
            //     find.quantity++;
            // }
          },
          filter(){
            const regexp = new RegExp(this.searchLine, 'i');
            this.filtered = this.products.filter(product => regexp.test(product.product_name));
            this.products.forEach(el => {
                const block = document.querySelector(`.card[data-id="${el.id_product}"]`);
                if(!this.filtered.includes(el)){
                  block.classList.add('invisible');
                } else {
                  block.classList.remove('invisible');
                }
              })
          },   
    },
    created() {
        this.getJson(`${API + this.catalogUrl}`)
          .then(data => {
            for(let el of data) {
              this.products.push(el);
            }
          });
        this.getJson(`${API + this.basketUrl}`)
          .then(data => {this.basket = data.contents})
     }        
});