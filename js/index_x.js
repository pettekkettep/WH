function onHoverU()
{
    var a = document.getElementById("przyp_u");
    a.src = "blok/zapisyimg/przyp.png";
}

function offHoverU()
{
    var a = document.getElementById("przyp_u");
    a.src = "blok/zapisyimg/przyp2.png";
}

function onHoverN()
{
    var a = document.getElementById("przyp_n");
    a.src = "blok/zapisyimg/przyp.png";
}

function offHoverN()
{
    var a = document.getElementById("przyp_n");
    a.src = "blok/zapisyimg/przyp2.png";
}

function toggleMe(a, b){

    var e=document.getElementById(a);
    var f=document.getElementById(b);

    if(!f)return true;
    if(f.value=="Pokaż resztę komunikatu" || f.value=="Ukryj resztę komunikatu") {
        if(f.value=="Pokaż resztę komunikatu") f.value = "Ukryj resztę komunikatu";
        else f.value = "Pokaż resztę komunikatu";
    }
    if(f.value=="Dodaj komentarz" || f.value=="Ukryj dodawanie komentarza") {
        if(f.value=="Dodaj komentarz") f.value = "Ukryj dodawanie komentarza";
        else f.value = "Dodaj komentarz";
    }
    if(f.value=="Pokaż komentarze" || f.value=="Ukryj komentarze") {
        if(f.value=="Pokaż komentarze") f.value = "Ukryj komentarze";
        else f.value = "Pokaż komentarze";
    }

    if(!e)return true;
    if(e.style.display=="none" || e.style.display==""){
        e.style.display="block";
        window.scrollBy(0,50);
    }
    else {
        e.style.display="none";
    }
    return true;
}

function toggle(a){
    var e=document.getElementById(a);

    if(!e)return true;
    if(e.style.display=="none" || e.style.display==""){
        e.style.display="block";
        window.scrollBy(0,50);
    }
    else {
        e.style.display="none";
    }
    return true; 
}

myID = document.getElementById("demi");

var myScrollFunc = function() {
    var y = window.scrollY;
    if (y >= 4600) {
        myID.className = "dementor show"
    } else {
        myID.className = "dementor hide"
    }
};

window.addEventListener("scroll", myScrollFunc);
function displayNextImage() {
    x = (x === images.length - 1) ? 0 : x + 1;
    document.getElementById("demi-img").src = images[x];
    if(x === 2 || x === 5){
        document.getElementById("on-img-1").style.color = "black";
        document.getElementById("on-img-2").style.color = "black";
    }
    if(x === 4 || x === 0){
        document.getElementById("on-img-1").style.color = "#f9e0d9";
        document.getElementById("on-img-2").style.color = "#f9e0d9";
    }
}

function startTimer() {
    setInterval(displayNextImage, 2000);
}

var images = [], x = -1;
images[0] = "dem1.png";
images[1] = "dem2.png";
images[2] = "dem3.png";
images[3] = "dem4.png";
images[4] = "dem5.png";
images[5] = "dem6.png";

