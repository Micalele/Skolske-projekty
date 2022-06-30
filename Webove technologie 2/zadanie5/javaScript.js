let x = [], y1 = [], y2 = [], y3 = [];

let displayY1 = true;
let displayY2 = true;

let data1, data2, data3;

let turnedOn = 1;


let source = new EventSource("https://147.175.121.210:4543/zadanie5/sse.php?y1=1&y2=1&y3=1");
let message;

function changeA() {
    let value = parseInt(document.getElementById("konstanta").value);
    if (Number.isInteger(value)){
        console.dir("gut");
        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'https://147.175.121.210:4543/zadanie5/changeA.php?konstanta='+value, true);
        xhr.send();
    }
    else console.dir(value);
}

function messageInc()
{
    source.addEventListener("message", function(e)
    {
        message = e.data;
        message = JSON.parse(message);
        if(turnedOn){
            x.push(message.x);
            y1.push(message.y1);
            y2.push(message.y2);
            y3.push(message.y3);
            drawGraf();
        }
    });
}

function toogleY1()
{
    if(displayY1 === true)
    {
        displayY1 = false;
    }
    else
    {
        displayY1 = true;
    }
    drawGraf();
}

function toogleY2()
{
    if(displayY2 === true)
    {
        displayY2 = false;
    }
    else
    {
        displayY2 = true;
    }
    drawGraf();
}


function drawGraf() {
    let trace1 = {
        x: x,
        y: y1,
        line: {
            color: "rgb(255,0,0)",
        },
        name: "Y1",
        type: 'scatter'
    };

    let trace2 = {
        x: x,
        y: y2,
        line: {
            color: "rgb(0,0,255)",
        },
        name: "Y2",
        type: 'scatter'
    };

    let trace3 = {
        x: x,
        y: y3,
        line: {
            color: "rgb(0,255,0)",
        },
        name: "Y3",
        type: 'scatter'
    };

    let layout = {
        title: 'Graf zašumeného sínusu a kosínusu',
        showlegend: true
    };

    data1 = [trace1];
    data2 = [trace2];
    data3 = [trace3];

    Plotly.newPlot('graph', [], layout);

    if(displayY1 === true && displayY2 === true)
    {
        Plotly.addTraces(graph, data1);
        Plotly.addTraces(graph, data2);
        Plotly.addTraces(graph, data3);
    }
    else if(displayY1 === true && displayY2 === false)
    {
        Plotly.addTraces(graph, data1);
    }
    else if(displayY1 === false && displayY2 === true)
    {
        Plotly.addTraces(graph, data2);
    }
}

function turnOffOn() {
    if(turnedOn){
        document.getElementById("turnOffOn").innerHTML = "Updating Off";
        turnedOn = false;
    }
    else{
        document.getElementById("turnOffOn").innerHTML = "Updating On";
        turnedOn = true;
    }

}