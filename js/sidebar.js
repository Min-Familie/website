var open = false;

function openNav() {
    if (!open) {
        document.getElementById("sidebar").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
        open = true;
    }
    
    else {
        document.getElementById("sidebar").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
        open = false;
    }
}