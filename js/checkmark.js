function classStyle(cid, status, id){
    let tag = document.getElementById(cid);
    if(status == true){
        tag.classList.add('line_through');
    }
    else{
        tag.classList.remove('line_through');
    }
    // for(let i = 0; i < c.length; i++){
    //     if(status == true){
    //         c[i].style.textDecoration = "line-through";
    //     }
    //     else{
    //         c[i].style.textDecoration = "none";
    //     }
    // }

}
function check(itemID, id, url, cid=null){
    url = url.pathname.split("/").pop();
    let add = `check_${url}`;
    let xhttp = new XMLHttpRequest();
    if (document.getElementById(`${itemID}`).checked == false){
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {

            if(cid){
                classStyle(cid, false);
            }
            else{
                document.getElementById(`text${id}`).style.textDecoration = "none";
            }
          }
        };
      xhttp.open("GET", `${add}?id=${id}&s=0`, true);
      xhttp.send();
    }
    else if (document.getElementById(`${itemID}`).checked == true){
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            if(cid){
                classStyle(cid, true);
            }
            else{
                document.getElementById(`text${id}`).style.textDecoration = "line-through";
            }
          }
        };
      xhttp.open("GET", `${add}?id=${id}&s=1`, true);
      xhttp.send();
  }

}
