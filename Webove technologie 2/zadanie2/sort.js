let x = 0;
let smer = "az";


function sortU3(n) {
    x = n;
    let rows = document.getElementsByClassName("row");
    let table = [];
    for (let pc = 0; pc<rows.length; pc++){
        let row = [];
        row.push(rows[pc].childNodes[0].innerHTML);
        row.push(rows[pc].childNodes[1].innerHTML);
        row.push(rows[pc].childNodes[2].innerHTML);
        row.push(rows[pc].childNodes[3].innerHTML);
        row.push(rows[pc].childNodes[4].innerHTML);
        if (rows[pc].childNodes[5].innerHTML === "-") row.push(0);
        else row.push(parseInt(rows[pc].childNodes[5].innerHTML, 10));
        table.push(row);
    }
    if (smer === "az"){
        table.sort(sortFunctionAZ);
        smer = "za";
    }
    else{
        table.sort(sortFunctionZA);
        smer = "az";
    }

    for (let pc = 0; pc<rows.length; pc++){
        document.getElementsByClassName("row")[pc].childNodes[0].innerHTML = table[pc][0];
        document.getElementsByClassName("row")[pc].childNodes[1].innerHTML = table[pc][1];
        document.getElementsByClassName("row")[pc].childNodes[2].innerHTML = table[pc][2];
        document.getElementsByClassName("row")[pc].childNodes[3].innerHTML = table[pc][3];
        document.getElementsByClassName("row")[pc].childNodes[4].innerHTML = table[pc][4];
        if (table[pc][5] === 0) document.getElementsByClassName("row")[pc].childNodes[5].innerHTML = "-";
        else document.getElementsByClassName("row")[pc].childNodes[5].innerHTML = "" + table[pc][5];
    }
}

function sortFunctionAZ(a, b) {
    if (a[x] === b[x]) {
        return 0;
    }
    else {
        return (a[x] < b[x]) ? -1 : 1;
    }
}
function sortFunctionZA(a, b) {
    if (a[x] === b[x]) {
        return 0;
    }
    else {
        return (a[x] > b[x]) ? -1 : 1;
    }
}

function sortU4(n , m) {
    x = n;
    console.log(document.getElementsByClassName("row"+m).length);
    let rows = document.getElementsByClassName("row"+m);
    let table = [];
    for (let pc = 0; pc<rows.length; pc++){
        let row = [];
        row.push(rows[pc].childNodes[0].innerHTML);
        row.push(rows[pc].childNodes[1].innerHTML);
        row.push(rows[pc].childNodes[2].innerHTML);
        row.push(parseInt(rows[pc].childNodes[3].innerHTML, 10));
        table.push(row);
    }
    if (smer === "az"){
        table.sort(sortFunctionAZ);
        smer = "za";
    }
    else{
        table.sort(sortFunctionZA);
        smer = "az";
    }

    for (let pc = 0; pc<rows.length; pc++){
        document.getElementsByClassName("row"+m)[pc].childNodes[0].innerHTML = table[pc][0];
        document.getElementsByClassName("row"+m)[pc].childNodes[1].innerHTML = table[pc][1];
        document.getElementsByClassName("row"+m)[pc].childNodes[2].innerHTML = table[pc][2];
        document.getElementsByClassName("row"+m)[pc].childNodes[3].innerHTML = "" + table[pc][3];
    }
}