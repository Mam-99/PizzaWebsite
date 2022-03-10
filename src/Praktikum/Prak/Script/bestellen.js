'use strict';

let currentCart = [];
let cartView = document.getElementById('cart');
let cartForm = document.getElementById('cart-hidden');

/*
function createElement(html) {
    let container = document.createElement('div');
    container.innerHTML = html.trim();
    return container.firstChild;
}

function addPizza(pizza){
    let count = currentCart.filter(element => element.name == pizza.name).length;
    if(count > 0){      // Objekt ist existiert und muss nur die Anzahl inkrementieren
        cartView.removeChild(document.getElementById(pizza.name));
    }

    count++;
    currentCart.push(pizza);

    let newPizza = createElement(`<div id="${pizza.name}">${count}x Pizza ${pizza.name} - price: ${pizza.price}</div>`);

    cartView.appendChild(newPizza);
}
 */

function addPizza(pizza){
     let count = currentCart.filter(element => element.name == pizza.name).length;
     if(count > 0){
         cartView.removeChild(document.getElementById(pizza.name));
     }

     count++;
     currentCart.push(pizza);

     let newPizza = document.createElement("div");
     newPizza.setAttribute("id", pizza.name);
     let text = document.createTextNode(count + "x Pizza " + pizza.name + " - price: " + pizza.price + "€");
     newPizza.appendChild(text);

     let img = document.createElement("img");
     img.setAttribute("alt", "Löschen");
     img.setAttribute("src", "delete-icon.jpg");
     img.setAttribute("height", "16");
     img.setAttribute("onclick", "deletePizza('" + pizza.name + "')");

     newPizza.appendChild(img);

     cartView.appendChild(newPizza);

     OnChangeCart();
}

function deletePizza(name){
    let index = -1;
    for(let i=0; i<currentCart.length; i++){
        if(currentCart[i].name == name){
            index = i;
            break;
        }
    }

    let pizza = currentCart[index];
    currentCart.splice(index, 1);
    let count = currentCart.filter(el => el.name === name).length;

    console.log(currentCart);
    console.log(count);

    cartView.removeChild(document.getElementById(name));

    if(count == 0){
        OnChangeCart();
        return;
    }

    let newPizza = document.createElement('div');
    newPizza.setAttribute('id', name);
    let text = document.createTextNode(count + "x Pizza " + name + " - price: " + pizza.price + "€");
    newPizza.appendChild(text);

    let img = document.createElement("img");
    img.setAttribute("alt", "Löschen");
    img.setAttribute("src", "delete-icon.jpg");
    img.setAttribute("height", "16");
    img.setAttribute("onclick", "deletePizza('" + pizza.name + "')");

    newPizza.appendChild(img);

    cartView.appendChild(newPizza);

    OnChangeCart();
}

function deleteAll(){
    if(currentCart.length == 0){
        return;
    }

    // loop to delete all child of cartView
    while(cartView.firstChild){
        cartView.removeChild(cartView.lastChild);
    }

    let newStatus = document.createElement("div");
    newStatus.setAttribute("id", "placeholder");
    let text = document.createTextNode("Keine Artikel");
    newStatus.appendChild(text);
    cartView.appendChild(newStatus);

    currentCart = [];
    OnChangeCart();
}

function OnChangeCart(){
    let placeholder = document.getElementById("placeholder");
    placeholder.style.display = (currentCart.length == 0)? "block" : "none";

    // Link for array.map() https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/map?retiredLocale=vi
    /*
    let idForHiddenValue = [];
    for(let i=0; i<currentCart.length; i++){
        idForHiddenValue.push(currentCart[i].price);
    }
    cartForm.value = JSON.stringify(idForHiddenValue);
     */
    cartForm.value = JSON.stringify(currentCart.map(item => item.id));

    // update total price
    let sum = 0;
    for(let i=0; i<currentCart.length; i++){
        let price = currentCart[i].price;
        sum += parseFloat(price);
    }

    document.getElementById("total-price").innerText = sum.toFixed(2);
}

























