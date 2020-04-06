var open = false;

function openNav() {
    // if (!open) {
        // if (window.innerWidth <= 800) {
        //     document.getElementById("sidebar").style.height = "253px";
        //     document.getElementById("sidebar").style.width = "100%";
        //     document.getElementById("main").style.marginLeft = "0";
        // }
        // else {
        //     document.getElementById("sidebar").style.height = "100%";
        //     document.getElementById("sidebar").style.width = "225px";
        //     document.getElementById("main").style.marginLeft = "225px";
        // }
        // open = true;
    let nav = document.getElementById('sidebar');
    if (window.innerWidth <= 800) {
        nav.classList.toggle('sidebar_toggled_mobile');
        document.getElementById("main").style.marginLeft = "0";
    }
    else {
        nav.classList.toggle('sidebar_toggled');
        if (nav.classList.contains('sidebar_toggled')) {
            document.getElementById("main").style.marginLeft = "225px";
        }
        else{
            document.getElementById("main").style.marginLeft = "0";
        }
    }



    // }
    //
    // else {
    //     /*
    //     if (window.innerWidth <= 800) {
    //         document.getElementById("sidebar").style.height = "0";
    //         document.getElementById("sidebar").style.width = "100%";
    //         document.getElementById("main").style.marginLeft = "0";
    //     }
    //     else {
    //         document.getElementById("sidebar").style.height = "100%";
    //         document.getElementById("sidebar").style.width = "0";
    //         document.getElementById("main").style.marginLeft = "0";
    //     }
    //     */
    //     document.getElementById("sidebar").style.height = "0";
    //     document.getElementById("sidebar").style.width = "0";
    //     document.getElementById("main").style.marginLeft = "0";
    //     open = false;
    // }
}
