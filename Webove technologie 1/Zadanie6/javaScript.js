let source = new EventSource("http://vmzakova.fei.stuba.sk/sse/sse.php");
let message;

let x = [], y1 = [], y2 = [];

let displayY1 = true;
let displayY2 = true;

let data1, data2;

let turnedOn = 1;

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

    let layout = {
        title: 'Graf zašumeného sínusu a kosínusu',
        showlegend: true
    };

    data1 = [trace1];
    data2 = [trace2];

    Plotly.newPlot('graph', [], layout);

    if(displayY1 === true && displayY2 === true)
    {
        Plotly.addTraces(graph, data1);
        Plotly.addTraces(graph, data2);
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