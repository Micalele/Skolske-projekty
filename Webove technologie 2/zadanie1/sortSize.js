function normalBubble(sizeArray) {
    let len = sizeArray.length;
    for (let i = 0; i < len; i++) {
        for (let j = 0; j < len; j++) {
            if (sizeArray[j] > sizeArray[j + 1]) {
                console.dir(sizeArray[j], sizeArray[j + 1]);
                let tmp = sizeArray[j];
                sizeArray[j] = sizeArray[j + 1];
                sizeArray[j + 1] = tmp;

                let tmp2 = document.getElementById("r" + (j + 1)).innerHTML;
                document.getElementById("r" + (j + 1)).innerHTML = document.getElementById("r" + (j + 2)).innerHTML;
                document.getElementById("r" + (j + 2)).innerHTML = tmp2;
            }
        }
    }
}
function reverseBubble(sizeArray) {
    let len = sizeArray.length;
    for (let i = 0; i < len; i++) {
        for (let j = 0; j < len; j++) {
            if (sizeArray[j] < sizeArray[j + 1]) {
                let tmp = sizeArray[j];
                sizeArray[j] = sizeArray[j + 1];
                sizeArray[j + 1] = tmp;

                let tmp2 = document.getElementById("r" + (j + 1)).innerHTML;
                document.getElementById("r" + (j + 1)).innerHTML = document.getElementById("r" + (j + 2)).innerHTML;
                document.getElementById("r" + (j + 2)).innerHTML = tmp2;
            }
        }
    }
}

function sortSize() {
    let name = document.getElementById("name").innerHTML;
    let size = document.getElementById("size").innerHTML;
    if (name[name.length-1]==="▼" || name[name.length-1]==="▲"){
        document.getElementById("size").innerHTML = size + "▼";
        size = size + "▼";
        document.getElementById("name").innerHTML = name.substring(0, name.length - 1);
        console.dir(size);
    }
    if (size[size.length-1]==="▼"){
        document.getElementById("size").innerHTML = size.substring(0, size.length - 1) + "▲";
        //let nameArray = [];
        let sizeArray = [];
        //let updateArray = [];
        let pc = 1;
        while (document.getElementById("size" + pc)) {
            //nameArray.push(document.getElementById("name" + pc).innerHTML);
            if (document.getElementById("size" + pc).innerHTML=== "") sizeArray.push("0");
            else sizeArray.push(document.getElementById("size" + pc).innerHTML);
            //updateArray.push(document.getElementById("update" + pc).innerHTML);
            pc++;
        }
        normalBubble(sizeArray);
        console.dir(sizeArray);
    }
    else if (size[size.length-1]==="▲"){
        document.getElementById("size").innerHTML = size.substring(0, size.length - 1) + "▼";
        //let nameArray = [];
        let sizeArray = [];
        //let updateArray = [];
        let pc = 1;
        while (document.getElementById("size" + pc)) {
            //nameArray.push(document.getElementById("name" + pc).innerHTML);
            if (document.getElementById("size" + pc).innerHTML=== "") sizeArray.push("0");
            else sizeArray.push(document.getElementById("size" + pc).innerHTML);
            //updateArray.push(document.getElementById("update" + pc).innerHTML);
            pc++;
        }
        console.dir(sizeArray);
    }
}