let xhttp = new XMLHttpRequest();

function loadDoc() {
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            myFunction(this);
        }
    };
    xhttp.open("GET", "img.xml", true);
    xhttp.send();
}
function myFunction(xml) {
    let xmlDoc = xml.responseXML;
    let string = "";
    imageCount = xmlDoc.getElementsByTagName("image").length;
    for (let i = 0; i < xmlDoc.getElementsByTagName("image").length; i++){
        string += "<div class='prev'><img onclick='openImg("+ i +")' class='prevImg' src=\"" + xmlDoc.getElementsByTagName("src")[i].childNodes[0].nodeValue + "\" alt='IMG_ERR'></div>";
    }

    string +="<div id='fullScreenImg'>";

    for (let i = 0; i < xmlDoc.getElementsByTagName("image").length; i++){
        string+="<div class='slide' id=\"slide"+i+"\">";
        string+="<p class='titles' id=\"title"+ i +"\">\"" + xmlDoc.getElementsByTagName("title")[i].childNodes[0].nodeValue + "\"</p>";
        string+="<img class='fullImg' id=\"img"+ i +"\" src=\"" + xmlDoc.getElementsByTagName("src")[i].childNodes[0].nodeValue + "\" style='display: none' alt='imgErr'>";
        string+="<p class='desc' id=\"desc"+ i +"\">\"" + xmlDoc.getElementsByTagName("desc")[i].childNodes[0].nodeValue + "\"</p>";
        string+="</div>";
    }
    string += "<div class='slide'>";
    string += "<span class='commands' onclick='prevSlide()'><--      |</span>";
    string += "<span class='commands' id='close' onclick='closeImg()'>| CLOSE |</span>";
    string += "<span class='commands' id='slideShow' onclick='slideShow()'>| Slideshow: start |</span>";
    string += "<span class='commands' onclick='nextSlide()'>|      --></span><br>";
    string += "</div></div>";

    document.getElementById("myArticle").innerHTML = string;
}

let imageCount = 0;
let currentSlide = -1;
function openImg(i) {
    currentSlide = i;
    document.getElementById("fullScreenImg").style.display = "block";
    document.getElementById("img"+i).style.display = "block";
    document.getElementById("title"+i).style.display = "block";
    document.getElementById("desc"+i).style.display = "block";
}

function closeImg() {
    for (let i = 0; i < imageCount; i++){
        document.getElementById("img"+i).style.display = "none";
        document.getElementById("title"+i).style.display = "none";
        document.getElementById("desc"+i).style.display = "none";
    }
    document.getElementById("fullScreenImg").style.display = "none";
}

function nextSlide() {
    currentSlide++;
    if (currentSlide>=imageCount){
        currentSlide=0;
    }
    closeImg();
    openImg(currentSlide);
}

function prevSlide() {
    currentSlide--;
    if (currentSlide<=0){
        currentSlide=imageCount-1;
    }
    closeImg();
    openImg(currentSlide);
}

let show = 0;
let timer = null;
function slideShow() {
    if(show === 0)
    {
        document.getElementById("slideShow").innerText = "| Slideshow: stop |";
        timer = setInterval("nextSlide()", 2000);
        show = 1;
    }
    else
    {
        document.getElementById("slideShow").innerText = "| Slideshow: start |";
        clearInterval(timer);
        show = 0;
    }
}