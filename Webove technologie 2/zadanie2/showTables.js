function showTables() {
    let selected;

    let len = document.getElementById("listbox").options.length;
    for (let pc = 0; pc<len; pc++){
        if (document.getElementById("listbox").options[pc].selected){
            selected = document.getElementById("listbox").options[pc].value;
        }
    }
    for (let pc = 1; pc<=len; pc++){
        if (""+pc === selected){
            console.log(selected);
            document.getElementById(""+pc).style.display = "block";
        }
        else document.getElementById(""+pc).style.display = "none";
    }
    console.log(selected);
}