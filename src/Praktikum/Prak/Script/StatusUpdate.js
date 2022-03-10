'use strict';

let statusView = document.getElementById('status-block');

function updateStatus(pizza){
    let newPizza = document.createElement('div');
    newPizza.setAttribute('class', 'pizza-kunde');

    let order = document.createElement('p').appendChild(
                document.createTextNode("Bestellung #" + pizza.orderID + " - Pizza "
                + pizza.name));

    newPizza.appendChild(order);

    // table erstellen
    let table = document.createElement('table');

    // bestellt
    let tr = document.createElement('tr');

    let td2 = document.createElement('td');

    let bestellt = document.createElement('input');
    bestellt.setAttribute('type', 'radio');
    bestellt.setAttribute('id', "status-0");
    if(pizza.status == 0) bestellt.checked;
    bestellt.setAttribute('onclick', 'return false;');
    td2.appendChild(bestellt);

    let td1 = document.createElement('td');

    let bestelltLabel = document.createElement('label');
    bestelltLabel.setAttribute('for', 'status-0');
    bestelltLabel.innerText = "bestellt";
    bestelltLabel.appendChild(document.createElement('br'));
    td1.appendChild(bestelltLabel);

    tr.appendChild(td1);
    tr.appendChild(td2);

    table.appendChild(tr);

    // Im Offen

    tr = document.createElement('tr');

    td2 = document.createElement('td');

    let imOffen = document.createElement('input');
    imOffen.setAttribute('type', 'radio');
    imOffen.setAttribute('id', "status-1");
    if(pizza.status == 1) imOffen.checked;
    imOffen.setAttribute('onclick', 'return false;');
    td2.appendChild(imOffen);

    td1 = document.createElement('td');

    let imOffenLabel = document.createElement('label');
    imOffenLabel.setAttribute('for', 'status-1');
    imOffenLabel.innerText = "Im Offen";
    imOffenLabel.appendChild(document.createElement('br'));
    td1.appendChild(imOffenLabel);

    tr.appendChild(td1);
    tr.appendChild(td2);

    table.appendChild(tr);

    // fertig

    tr = document.createElement('tr');

    td2 = document.createElement('td');

    let fertig = document.createElement('input');
    fertig.setAttribute('type', 'radio');
    fertig.setAttribute('id', "status-2");
    if(pizza.status == 2) fertig.checked;
    fertig.setAttribute('onclick', 'return false;');
    td2.appendChild(fertig)

    td1 = document.createElement('td');

    let fertigLabel = document.createElement('label');
    fertigLabel.setAttribute('for', 'status-2');
    fertigLabel.innerText = "fertig";
    fertigLabel.appendChild(document.createElement('br'));
    td1.appendChild(fertigLabel);

    tr.appendChild(td1);
    tr.appendChild(td2);

    table.appendChild(tr);

    // unterwegs

    tr = document.createElement('tr');

    td2 = document.createElement('td');

    let unterwegs = document.createElement('input');
    unterwegs.setAttribute('type', 'radio');
    unterwegs.setAttribute('id', "status-3");
    if(pizza.status == 3) unterwegs.checked;
    unterwegs.setAttribute('onclick', 'return false;');
    td2.appendChild(unterwegs);

    td1 = document.createElement('td');

    let unterwegsLabel = document.createElement('label');
    unterwegsLabel.setAttribute('for', 'status-3');
    unterwegsLabel.innerText = "unterwegs";
    unterwegsLabel.appendChild(document.createElement('br'));
    td1.appendChild(unterwegsLabel);

    tr.appendChild(td1);
    tr.appendChild(td2);

    table.appendChild(tr);

    // geliefert

    tr = document.createElement('tr');

    td2 = document.createElement('td');

    let geliefert = document.createElement('input');
    geliefert.setAttribute('type', 'radio');
    geliefert.setAttribute('id', "status-4");
    if(pizza.status == 4) geliefert.checked;
    geliefert.setAttribute('onclick', 'return false;');
    td2.appendChild(geliefert);

    td1 = document.createElement('td');

    let geliefertLabel = document.createElement('label');
    geliefertLabel.setAttribute('for', 'status-4');
    geliefertLabel.innerText = "geliefert";
    geliefertLabel.appendChild(document.createElement('br'));
    td1.appendChild(geliefertLabel);

    tr.appendChild(td1);
    tr.appendChild(td2);

    table.appendChild(tr);

    newPizza.appendChild(table);
}

function process(string){
    let orders = JSON.parse(string);

    if(orders.length == 0) return;

    while(statusView.firstChild){
        statusView.removeChild(statusView.lastChild);
    }

    for(let order of orders){
        updateStatus(order);
    }
}

function requestData(){
    // request als globale Variable anlegen (haesslich, aber bequem)
    let request = new XMLHttpRequest();

    function requestData() { // fordert die Daten asynchron an
        request.open("GET", "KundenStatus.php"); // URL für HTTP-GET
        request.onreadystatechange = processData; //Callback-Handler zuordnen
        request.send(); null// Request abschicken
    }
}

function processData() {
    if(request.readyState == 4) { // Uebertragung = DONE
        if (request.status == 200) {   // HTTP-Status = OK
            if(request.responseText != null)
                process(request.responseText);// Daten verarbeiten
            else console.error ("Dokument ist leer");
        }
        else console.error ("Uebertragung fehlgeschlagen");
    } else ;          // Uebertragung laeuft noch
}

window.onload = function (){
    window.setInterval(requestData, 2000);
}