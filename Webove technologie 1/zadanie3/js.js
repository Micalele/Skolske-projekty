function newsRadioChech() {
    let check = document.getElementById("newsCheckbox");
    if(check.checked){
        document.getElementById("newsRadios").style.display = "inherit";
    }
    else{
        document.getElementById("newsRadios").style.display = "none";
        document.getElementById("newsOnly").checked = false;
        document.getElementById("newsOffers").checked = false;
    }
}

function ageCheck() {
    let age =document.getElementById("age").value;
    let date = new Date();
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();

    let birthdate = document.getElementById("birthdate").value;
    let date2 = new Date(birthdate);
    let day2 = date2.getDate();
    let month2 = date2.getMonth() + 1;
    let year2 = date2.getFullYear();

    if (parseInt(age) === year - year2 || (parseInt(age)-1 === year - year2 && month2>month && day2>day)) {
        document.getElementById("dateError").style.display = "none";
        document.getElementById("age").style.backgroundColor = "white";
        document.getElementById("age").style.borderColor = "white";
        return true;
    } else {
        document.getElementById("dateError").style.display = "inherit";
        document.getElementById("age").style.backgroundColor = "#e8665d";
        document.getElementById("age").style.borderColor = "red";
        document.getElementById("age").style.borderStyle = "solid";
        return false;
    }
}

function raceChange() {
    if(document.getElementById("faction").value === "aliance"){
        race.options[0].text ="Human";
        race.options[0].value = "human";
        race.options[1].text ="Dwarf";
        race.options[1].value = "dwarf";
        race.options[2].text ="Gnome";
        race.options[2].value = "gnome";
        race.options[3].text ="Night elf";
        race.options[3].value = "nightElf";
    }
    else if(document.getElementById("faction").value === "horde"){
        race.options[0].text ="Orc";
        race.options[0].value = "orc";
        race.options[1].text ="Tauren";
        race.options[1].value = "tauren";
        race.options[2].text ="Troll";
        race.options[2].value = "troll";
        race.options[3].text ="Undead";
        race.options[3].value = "undead";
    }
}

function specChange() {
    if(document.getElementById("race").value ==="human"){
        spec.options[0].text = "Mage";
        spec.options[0].value = "mage";
        spec.options[1].text = "Paladin";
        spec.options[1].value = "paladin";
        spec.options[2].text = "Priest";
        spec.options[2].value = "priest";
        spec.options[3].text = "Rogue";
        spec.options[3].value = "rogue";
        spec.options[4].text = "Warlock";
        spec.options[4].value = "warlock";
    }
    if(document.getElementById("race").value ==="dwarf"){
        spec.options[0].text = "Hunter";
        spec.options[0].value = "hunter";
        spec.options[1].text = "Paladin";
        spec.options[1].value = "paladin";
        spec.options[2].text = "Priest";
        spec.options[2].value = "priest";
        spec.options[3].text = "Rogue";
        spec.options[3].value = "rogue";
        spec.options[4].text = "Warrior";
        spec.options[4].value = "warrior";
    }
    if(document.getElementById("race").value ==="gnome"){
        spec.options[0].text = "Mage";
        spec.options[0].value = "mage";
        spec.options[3].text = "Rogue";
        spec.options[3].value = "rogue";
        spec.options[4].text = "Warlock";
        spec.options[4].value = "warlock";
        spec.options[2].text = "Warrior";
        spec.options[2].value = "warrior";
        spec.options[1].text = "Paladin";
        spec.options[1].value = "paladin";
    }
    if(document.getElementById("race").value ==="nightElf"){
        spec.options[0].text = "Druid";
        spec.options[0].value = "druid";
        spec.options[1].text = "Hunter";
        spec.options[1].value = "hunter";
        spec.options[2].text = "Warrior";
        spec.options[2].value = "warrior";
        spec.options[3].text = "Rogue";
        spec.options[3].value = "rogue";
        spec.options[4].text = "Mage";
        spec.options[4].value = "mage";
    }
    if(document.getElementById("race").value ==="orc"){
        spec.options[0].text = "Druid";
        spec.options[0].value = "druid";
        spec.options[1].text = "Hunter";
        spec.options[1].value = "hunter";
        spec.options[2].text = "Warrior";
        spec.options[2].value = "warrior";
        spec.options[3].text = "Rogue";
        spec.options[3].value = "rogue";
        spec.options[4].text = "Mage";
        spec.options[4].value = "mage";
    }
    if(document.getElementById("race").value ==="tauren"){
        spec.options[0].text = "Mage";
        spec.options[0].value = "mage";
        spec.options[3].text = "Rogue";
        spec.options[3].value = "rogue";
        spec.options[4].text = "Warlock";
        spec.options[4].value = "warlock";
        spec.options[2].text = "Warrior";
        spec.options[2].value = "warrior";
        spec.options[1].text = "Paladin";
        spec.options[1].value = "paladin";
    }
    if(document.getElementById("race").value ==="troll"){
        spec.options[0].text = "Hunter";
        spec.options[0].value = "hunter";
        spec.options[1].text = "Paladin";
        spec.options[1].value = "paladin";
        spec.options[2].text = "Priest";
        spec.options[2].value = "priest";
        spec.options[3].text = "Rogue";
        spec.options[3].value = "rogue";
        spec.options[4].text = "Warrior";
        spec.options[4].value = "warrior";
    }
    if(document.getElementById("race").value ==="undead"){
        spec.options[0].text = "Mage";
        spec.options[0].value = "mage";
        spec.options[1].text = "Paladin";
        spec.options[1].value = "paladin";
        spec.options[2].text = "Priest";
        spec.options[2].value = "priest";
        spec.options[3].text = "Rogue";
        spec.options[3].value = "rogue";
        spec.options[4].text = "Warlock";
        spec.options[4].value = "warlock";
    }
}

function elseWeapon() {
    if (document.getElementById("elseCheck").checked){
        document.getElementById("else").style.display = "inherit";
    }
    else {
        document.getElementById("else").style.display = "none";
        document.getElementById("else").value = "";
    }
}

function firstNameCheck() {
    if(document.getElementById("firstName").value === ""){
        document.getElementById("firstName").style.backgroundColor = "#e8665d";
        document.getElementById("firstName").style.borderColor = "red";
        document.getElementById("firstName").style.borderStyle = "solid";
        document.getElementById("firstNameError").style.display = "inherit";
        return false;
    }
    else {
        document.getElementById("firstName").style.backgroundColor = "white";
        document.getElementById("firstName").style.borderColor = "white";
        document.getElementById("firstNameError").style.display = "none";
        return true;
    }
}

function lastNameCheck() {
    if(document.getElementById("lastName").value === ""){
        document.getElementById("lastName").style.backgroundColor = "#e8665d";
        document.getElementById("lastName").style.borderColor = "red";
        document.getElementById("lastName").style.borderStyle = "solid";
        document.getElementById("lastNameError").style.display = "inherit";
        return false;
    }
    else {
        document.getElementById("lastName").style.backgroundColor = "white";
        document.getElementById("lastName").style.borderColor = "white";
        document.getElementById("lastNameError").style.display = "none";
        return true;
    }
}

function mailCheck() {
    let mail = document.getElementById("mail").value;
    let reg = /^[A-Za-z0-9._%+-]{3,}@[a-zA-Z]{3,}([.]{1}[a-zA-Z]{2,}|[.]{1}[a-zA-Z]{2,}[.]{1}[a-zA-Z]{2,})$/;

    if(reg.test(mail) === false){
        document.getElementById("mail").style.backgroundColor = "#e8665d";
        document.getElementById("mail").style.borderColor = "red";
        document.getElementById("mail").style.borderStyle = "solid";
        document.getElementById("mailError").style.display = "inherit";
        return false;
    }
    else {
        document.getElementById("mail").style.backgroundColor = "white";
        document.getElementById("mail").style.borderColor = "white";
        document.getElementById("mailError").style.display = "none";
        return true;
    }
}

function charNameCheck() {
    if(document.getElementById("charName").value === ""){
        document.getElementById("charName").style.backgroundColor = "#e8665d";
        document.getElementById("charName").style.borderColor = "red";
        document.getElementById("charName").style.borderStyle = "solid";
        document.getElementById("charNameError").style.display = "inherit";
        return false;
    }
    else {
        document.getElementById("charName").style.backgroundColor = "white";
        document.getElementById("charName").style.borderColor = "white";
        document.getElementById("charNameError").style.display = "none";
        return true;
    }
}

function submitCheck() {
    if(charNameCheck() && firstNameCheck() && lastNameCheck() && ageCheck() && mailCheck()){
        document.getElementById("myForm").submit();
    }
}