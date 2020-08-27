let getRequest = (url) => {
  return new Promise((resolve, reject) => {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.onreadystatechange = () => {
      if(xhr.readyState === 4) {
        if(xhr.status !== 200) {
          let error = new Error(xhr.statusText);
          error.code = xhr.status;
          reject(error);
        } else resolve(xhr.responseText);
      }
    }
    xhr.send();
  });
};

class GoodsList {

  constructor (container = '.products') {
    this.container = container;
    this.goods = [];
    this.allProducts = [];
    this.basket = null;
    this.url = 'https://raw.githubusercontent.com/Eliseev88/courses/master/project/goods.json';

    this.#getProducts(this.url);
    this.#render();
  }

  #getProducts(url) {
    getRequest(url)
      .then(response => {
        this.goods = JSON.parse(response);
        this.#render();
      })
      .catch(error => {
        console.error(`Всё плохо... ${error}`);
      });
  }

  // #fetchProducts(url) {
  //   fetch(url)
  //   .then(data => data.json())
  //   .then(items => {this.goods = items})
    
  // }

  #render() {
      const block = document.querySelector(this.container);
      for (let product of this.goods) {
        const productObject = new ProductItem(product);
        this.allProducts.push(productObject);
        block.insertAdjacentHTML("beforeend", productObject.render());
      }
        this.basket = new GoodsCart();
        block.addEventListener('click', evt => this.basket.addProductToBasket(evt));
  }
}

class ProductItem {
  constructor (product, amount = 1) {
    this.id = product.id;
    this.title = product.title;
    this.price = product.price;
    this.img = product.img;
    this.amount = amount;
  }

  render() {
    return `<div class="card" style="width: 18rem;">
                <img src="${this.img}" class="card-img-top" alt="${this.title}">
                <div class="card-body">
                  <h5 class="card-title">${this.title}</h5>
                  <p class="card-text">${this.price} $</p>
                  <button
                   name="add"
                   data-id="${this.id}" 
                   data-title="${this.title}"
                   data-price="${this.price}"
                   data-img="${this.img}"
                   type="submit" class="btn btn-primary">
                    Buy
                  </button>
                </div>
            </div>`;
  }
}

class GoodsCart {
  constructor() {
    this.items = [];
  }
  
  addProductToBasket(evt) {
    if(evt.target.name = "add") {
      let datas = evt.target.dataset;
      let product = {
        id: datas.id,
        title: datas.title,
        price: datas.price,
        img: datas.img,
      }
      this.createBasketProduct(product);
    }
  }

  createBasketProduct(product) {
    let find = this.items.find(el => el.id == product.id);
    if (!find) this.items.push(Object.assign(product, { amount: 1 }));
    else find.amount++;
  }
  
  getTotalSum() {
    let sum = 0;
    for(let key in this.items) {
      sum += this.items[key].price * this.items[key].amount;
    }
    return sum;
  }
}

let list = new GoodsList();