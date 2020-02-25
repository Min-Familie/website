function onClick(){
  let text = document.getElementById("nyItem").value;
  if (!text.replace(/\s/g, '').length){
    document.getElementById("errorMessage").innerHTML = "Feltet er tomt";
    document.getElementById("nyItemForm").reset();
    return;
  }
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        location.reload();

      }
    };
  xhttp.open("GET", `addItem.php?t="${text}"`, true);
  xhttp.send();
  document.getElementById("nyItemForm").reset();
  // addedFeedback(text);
}
function checkMark(id){
  let xhttp = new XMLHttpRequest();
  if (document.getElementById(`item${id}`).checked == false){
    console.log("Unchecked");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById(`label${id}`).style.textDecoration = "none";
        }
      };
    xhttp.open("GET", `addItem.php?id=${id}&s=0`, true);
    xhttp.send();
  }
  else if (document.getElementById(`item${id}`).checked == true){
    console.log("Checked");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById(`label${id}`).style.textDecoration = "line-through";
        }
      };
    xhttp.open("GET", `addItem.php?id=${id}&s=1`, true);
    xhttp.send();
  }
  else {
    window.alert("Something went wrong");
    return;
  }
}
// function addedFeedback(todo) {
//   let liveRegion = document.querySelector('[role="status"]');
//   liveRegion.textContent = `${todo} lagt til.`;
// }
function delItem(id){
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(`entity${id}`).remove();
        location.reload();
      }
    };
  xhttp.open("GET", `../inc/delItem.inc.php?id=${id}`, true);
  xhttp.send();
}
