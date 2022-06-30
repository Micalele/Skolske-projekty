function hideDoprava() {
    let all = document.getElementsByClassName("Doprava");
    for (let pc = 0; pc < all.length; pc++) {
        all[pc].style.display = "none";
    }
}
function hideFinancie() {
    let all = document.getElementsByClassName("Financie");
    for (let pc = 0; pc < all.length; pc++) {
        all[pc].style.display = "none";
    }
}
function hideSkolstvo() {
    let all = document.getElementsByClassName("Školstvo");
    for (let pc = 0; pc < all.length; pc++) {
        all[pc].style.display = "none";
    }
}
function hideVnutro() {
    let all = document.getElementsByClassName("Vnútro");
    for (let pc = 0; pc < all.length; pc++) {
        all[pc].style.display = "none";
    }
}
function hideZdravotnictvo() {
    let all = document.getElementsByClassName("Zdravotníctvo");
    for (let pc = 0; pc < all.length; pc++) {
        all[pc].style.display = "none";
    }
}
function showDoprava() {
    let all = document.getElementsByClassName("Doprava");
    for (let pc = 0; pc < all.length; pc++) {
        all[pc].style.display = "table-row";
    }
}
function showFinancie() {
    let all = document.getElementsByClassName("Financie");
    for (let pc = 0; pc < all.length; pc++) {
        all[pc].style.display = "table-row";
    }
}
function showSkolstvo() {
    let all = document.getElementsByClassName("Školstvo");
    for (let pc = 0; pc < all.length; pc++) {
        all[pc].style.display = "table-row";
    }
}
function showVnutro() {
    let all = document.getElementsByClassName("Vnútro");
    for (let pc = 0; pc < all.length; pc++) {
        all[pc].style.display = "table-row";
    }
}
function showZdravotnictvo() {
    let all = document.getElementsByClassName("Zdravotníctvo");
    for (let pc = 0; pc < all.length; pc++) {
        all[pc].style.display = "table-row";
    }
}

function filter() {
    if(document.getElementById("all").checked){
        showDoprava();
        showFinancie();
        showSkolstvo();
        showVnutro();
        showZdravotnictvo();
    }
    else if (document.getElementById("doprava").checked){
        hideZdravotnictvo();
        hideVnutro();
        hideSkolstvo();
        hideFinancie();
        showDoprava();
    }
    else if (document.getElementById("vnutro").checked){
        hideZdravotnictvo();
        showVnutro();
        hideSkolstvo();
        hideFinancie();
        hideDoprava();
    }
    else if (document.getElementById("skolstvo").checked){
        hideZdravotnictvo();
        hideVnutro();
        showSkolstvo();
        hideFinancie();
        hideDoprava();
    }
    else if (document.getElementById("financie").checked){
        hideZdravotnictvo();
        hideVnutro();
        hideSkolstvo();
        showFinancie();
        hideDoprava();
    }
    else if (document.getElementById("zdravotnictvo").checked){
        showZdravotnictvo();
        hideVnutro();
        hideSkolstvo();
        hideFinancie();
        hideDoprava();
    }
}