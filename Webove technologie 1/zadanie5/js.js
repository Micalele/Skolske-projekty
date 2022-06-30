function startWebWorker() {
    if(allOk()){
        let worker = new Worker("wWorker.js");
        let input = [document.getElementById("zaciatok").value, document.getElementById("koniec").value];
        worker.postMessage(input);
        let last = document.getElementById("zaciatok").value;
        worker.onmessage = function (e) {
            if(last != e.data[0]){
                last = e.data[0];
                if(!isNaN(e.data[0])) document.getElementById("output").value += last + ", ";
            }

            let x = (e.data[1] - document.getElementById("zaciatok").value)/
                (document.getElementById("koniec").value - document.getElementById("zaciatok").value);
            document.getElementById("output").style.display ="inherit";
            document.getElementById("myProgress").style.display ="inherit";

            document.getElementById("myBar").innerText = x*100 + "%";
            document.getElementById("myBar").style.width = x*100 + "%";
        }
    }
}

function clearText() {
    document.getElementById("output").value = " ";
}

function allOk() {
    let zaciatok = parseInt(document.getElementById("zaciatok").value);
    let koniec = parseInt(document.getElementById("koniec").value);
    if(zaciatok<0 || koniec<0){
        alert("From or To is less then 0.");
        return false;
    }
    else if(isNaN(zaciatok) || isNaN(koniec)){
        alert("From or To are not numbers.");
        return false;
    }
    else if(zaciatok === "" || koniec === ""){
        alert("From or To are not specified.");
        return false;
    }
    else if(koniec<zaciatok){
        alert("To is less then From.");
        return false;
    }
    return true;
}