var open = false;

function openNav() {
    let nav = document.getElementById('sidebar');
    nav.style.zIndex = 20;
    if (window.innerWidth <= 800) {
        nav.classList.toggle('sidebar_toggled_mobile');
        document.getElementById("main").style.marginLeft = "0";
    }
    else {
        nav.classList.toggle('sidebar_toggled');
        if (nav.classList.contains('sidebar_toggled')) {
            document.getElementById("main").style.marginLeft = "200px";
        }
        else{
            document.getElementById("main").style.marginLeft = "0";
        }
    }
}
