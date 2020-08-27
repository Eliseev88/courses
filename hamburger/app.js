class Hamburger {
    constructor() {
        this.container = null;
        this.size = 'small';
        this.price = 0;
        this.calories = 0;
        this.stuffing = [];
        this.topping = [];

        this.init();
    }

    init() {
        this.container = document.querySelector('#form');
        this.checkBox();
        this.calculate();
        this.getValues();
        this.render();
        this.reset();
    }

    getValues() {
        this.container.addEventListener('click', evt => {
            if(evt.target.name == 'burger') {
                let burger = document.getElementsByName('burger');
                burger.forEach(el => {
                    if(el.checked) {
                        this.size = el.value;
                        this.calculate();
                    } 
                })  
            }
            else if(evt.target.name == 'stuffing') this.getStuffing(evt);
            else if (evt.target.name == 'topping') this.getTopping(evt);
        });
    }

    getStuffing(evt) {
        let datas = evt.target.dataset;

        let stuffing = {
            name: datas.name,
            price: +datas.price,
            calories: +datas.calories
        }

        let find = this.stuffing.find(el => el.name == stuffing.name);
        if (!find) this.stuffing.push(stuffing);
        else this.stuffing.splice(this.stuffing.indexOf(find), 1);
        this.calculate();   
    }

    getTopping(evt) {
        let datas = evt.target.dataset;

        let topping = {
            name: datas.name,
            price: +datas.price,
            calories: +datas.calories
        }

        let find = this.topping.find(el => el.name == topping.name);
        if (!find) this.topping.push(topping);
        else this.topping.splice(this.topping.indexOf(find), 1);
        this.calculate(); 
    }

    calculate() {
        let burger = document.getElementsByName('burger');
        burger.forEach(el => {
            if(el.checked) {
                this.price = +el.dataset.price;
                this.calories = +el.dataset.calories; 
            }
        });

       let localPriceStuffing = this.calculatePrice(this.stuffing);
       let locaPriceTopping = this.calculatePrice(this.topping);
       this.price += (locaPriceTopping + localPriceStuffing);
       
       let localCaloriesStuffing = this.calculateCalories(this.stuffing);
       let localCaloriesTopping = this.calculateCalories(this.topping);
       this.calories += (localCaloriesStuffing + localCaloriesTopping);
       this.render();
    }

    calculatePrice(array) {
        let local = array.reduce((acc, currentValue) => 
             acc + currentValue.price, 0
        );
        return local;
    }

    calculateCalories(array) {
        let local = array.reduce((acc, currentValue) => 
             acc + currentValue.calories, 0
        );
        return local;
    }

    checkBox() {
        let checkBox = document.getElementsByName('stuffing');
        checkBox.forEach(el => {
            let datas = el.dataset;
            let stuffing = {
                name: datas.name,
                price: +datas.price,
                calories: +datas.calories
            }           
            if(el.checked) this.stuffing.push(stuffing);
        });
    }

    render() {
        document.querySelector('#render-pr').textContent = `Your order costs: ${this.price}$`;
        document.querySelector('#render-cl').textContent = `Your order calories: ${this.calories}`;
    }

    reset() {
        document.querySelector('#reset').addEventListener('click', () => {
            this.size = "small"
            this.price = 60;
            this.calories = 40;
            this.stuffing = [{name: "cheese", price: 10, calories: 20}];
            this.topping = [];

            size.style.display = "block";
            next.style.display = "block";
            next2.style.display = "none";
            complite.style.display = "none";
            stuff.style.display = "none";
            topp.style.display = "none";

        });
    }
}

const begin = document.querySelector("#begin");
const size = document.querySelector(".size__div");
const stuff = document.querySelector(".stuffing");
const topp = document.querySelector(".topping");
const next = document.querySelector("#next");
const next2 = document.querySelector("#next2");
const complite = document.querySelector("#complite");
const results = document.querySelector(".results");

begin.addEventListener('click', () => {
    document.querySelector('#page').classList.add('blur');
    document.querySelector("#form").style.visibility = "visible";   
});

next.addEventListener('click', () => {
   size.style.display = "none";
   stuff.style.display = "block";
   
   next2.style.display = "block";
   next.style.display = "none";
});

next2.addEventListener('click', () => {
    stuff.style.display = "none";
    topp.style.display = "block";

    complite.style.display = "block";
    next2.style.display = "none";
});

complite.addEventListener('click', () => {
    document.querySelector('#page').classList.remove('blur');
    document.querySelector("#form").style.visibility = "hidden";  

    begin.style.display = "none";
    results.style.display = "flex";

});


let order = new Hamburger()
 

