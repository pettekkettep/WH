function toggleMe(a){
    var e=document.getElementById(a);

    if(!e)return true;
    if(e.style.display=="none" || e.style.display==""){
        e.style.display="block";
        window.scrollBy(0,200);
    }
    return true;
}
