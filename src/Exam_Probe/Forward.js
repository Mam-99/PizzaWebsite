let request = new XMLHttpRequest();

let text = "";

let hashValue = "";

function requestData() { // fordert die Daten asynchron an
    "use strict";
    //ToDo - vervollständigen **************
    request.open("GET", "CalculateHash.php?URL=" + text);
    request.onreadystatechange = processData;
    request.send(null);
}

function processData() {
    "use strict";
    if (request.readyState === 4) { // Uebertragung = DONE
        if (request.status === 200) { // HTTP-Status = OK
            if (request.responseText != null){
                process(request.responseText);
            }
                //ToDo - vervollständigen ************
            else console.error("Dokument ist leer");
        } else console.error("Uebertragung fehlgeschlagen");
    } // else; // Uebertragung laeuft noch
}

function process(str){
    "use strict";
    let data = JSON.parse(str);

    document.getElementById('hash').value = data['hash'];
}

function getHash(value){
    "use strict";
    text = value;
    requestData();
}
