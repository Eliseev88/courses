const products = [
  {id: 1, title: 'Notebook', price: 20000, img: 'img/Notebook.jpg',},
  {id: 2, title: 'Mouse', price: 1500, img: 'img/Mouse.jpg',},
  {id: 3, title: 'Keyboard', price: 5000, img: 'img/Keyboard.jpg',},
  {id: 4, title: 'Gamepad', price: 4500, img: 'img/Gamepad.jpg',},
];

const renderProduct = (id, title, price, img = 'http://placehold.it/200x200') => 
        `<div class="card" style="width: 18rem;">
            <img src="${img}" class="card-img-top" alt="${title}">
            <div class="card-body">
              <h5 class="card-title">${title}</h5>
              <p class="card-text">${price} $</p>
              <button
               name="add"
               data-id="${id}" 
               data-title="${title}"
               data-price="${price}"
               data-img="${img}"
               type="submit" class="btn btn-primary">
                Buy
              </button>
            </div>
        </div>`;


const renderProducts = (list) => {
  const productList = list.map((product) => renderProduct(product.id, product.title, product.price, product.img)).join('');
  document.querySelector('.products').innerHTML = productList;
}

renderProducts(products);

const basket = {
  items: [],
}

document.querySelector('.products').addEventListener('click', evt => {
  if(evt.target.name == 'add') {
    let datas = evt.target.dataset;
    let product = {
      id: datas.id,
      title: datas.title,
      price: +datas.price,
      img: datas.img,
    }
    addProductToBasket(product);   
  }
});

function addProductToBasket(product) {
  let find = basket.items.find(el => el.id == product.id);
    if (!find) {
      basket.items.push(Object.assign(product, { amount: 1 }));
  } else {
    find.amount++;
  }
}