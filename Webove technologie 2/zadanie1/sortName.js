function fNameSort() {
    let nameArray = [];
    //let sizeArray = [];
    //let updateArray = [];
    let pc = 1;
    while (document.getElementById("name" + pc)) {
        nameArray.push(document.getElementById("name" + pc).innerHTML);
        //sizeArray.push(document.getElementById("size" + pc).innerHTML);
        //updateArray.push(document.getElementById("update" + pc).innerHTML);
        pc++;
    }
    let len = nameArray.length;
    for (let i = 0; i < len; i++) {
        for (let j = 0; j < len; j++) {
            if (nameArray[j] < nameArray[j + 1]) {
                let tmp = nameArray[j];
                nameArray[j] = nameArray[j + 1];
                nameArray[j + 1] = tmp;

                let tmp2 = document.getElementById("r" + (j + 1)).innerHTML;
                document.getElementById("r" + (j + 1)).innerHTML = document.getElementById("r" + (j + 2)).innerHTML;
                document.getElementById("r" + (j + 2)).innerHTML = tmp2;
            }
        }
    }
}

function sortName() {
    let name = document.getElementById("name").innerHTML;
    let size = document.getElementById("size").innerHTML;
    if (size[size.length-1]==="▼" || size[size.length-1]==="▲"){
        document.getElementById("name").innerHTML = name + "▼";
        name = name + "▼";
        document.getElementById("size").innerHTML = size.substring(0, size.length - 1);
    }
    if (name[name.length-1]==="▼"){
        document.getElementById("name").innerHTML = name.substring(0, name.length - 1) + "▲";
        fNameSort();
    }
    else if (name[name.length-1]==="▲"){
        document.getElementById("name").innerHTML = name.substring(0, name.length - 1) + "▼";
        fNameSort();
    }
}
