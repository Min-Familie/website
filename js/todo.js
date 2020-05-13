function onClick(){
    let time = new Date().getTime();        // hindre cache
    let text = document.getElementById("nyItem").value;
    let userID = document.getElementById("user").value;
    let familyID = document.getElementById("permission").value;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("permission").value = familyID;
        changeView(familyID, userID);
        document.getElementById("nyItem").value = "";

      }
    };
    xhttp.open("GET", `/minfamilie/todo/addItem.php?t="${text}"&user=${userID}&family=${familyID}&time=${time}`, true);
    xhttp.send();


}
function delItem(id){
    let time = new Date().getTime();        // hindre cache
    let userID = document.getElementById("user").value;
    let familyID = document.getElementById("permission").value;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(`entity${id}`).remove();
        if(this.responseText == "empty"){
            changeView(familyID, userID);
        }
      }
    };
    xhttp.open("GET", `/minfamilie/inc/delItem.inc.php?id=${id}&m=todo&user_id=${userID}&family_id=${familyID}&time=${time}`, true);
    xhttp.send();
}

function changeView(id, user){
    let time = new Date().getTime();        // hindre cache
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('items').innerHTML = this.responseText;
        }
      };
    xhttp.open("GET", `/minfamilie/inc/showTodo.inc.php?family_id=${id}&user_id=${user}&time=${time}`, true);
    xhttp.send();


}
