function onClick(){
    let text = document.getElementById("nyItem").value;
    let userID = document.getElementById("user").value;
    let familyID = document.getElementById("permission").value;
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        location.reload();

      }
    };
    xhttp.open("GET", `/minfamilie/todo/addItem.php?t="${text}"&user=${userID}&family=${familyID}`, true);
    xhttp.send();
    document.getElementById("nyItemForm").reset();

}
function delItem(id){
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(`entity${id}`).remove();
        location.reload();

      }
    };
    xhttp.open("GET", `/minfamilie/inc/delItem.inc.php?id=${id}&m=todo`, true);
    xhttp.send();
}


function changeView(id, user){
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById('items').innerHTML = this.responseText;

        }
      };
    xhttp.open("GET", `/minfamilie/inc/showTodo.inc.php?family_id=${id}&user_id=${user}`, true);
    xhttp.send();


}
