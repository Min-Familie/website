function onClick(){
  let text = document.getElementById("nyItem").value;
  let userID = document.getElementById("user").value;
  let familyID = document.getElementById("family").value;

  if (!text.replace(/\s/g, '').length){
    document.getElementById("errorMessage").innerHTML = "Feltet er tomt";
    document.getElementById("nyItemForm").reset();
    setTimeout(function(){
      document.getElementById("errorMessage").innerHTML = "";
***REMOVED***, 2000);


    return;
  }
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        location.reload();

  ***REMOVED***
***REMOVED***;
  xhttp.open("GET", `addItem.php?t="${text}"&user=${userID}&family=${familyID}`, true);
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
    ***REMOVED***
  ***REMOVED***;
    xhttp.open("GET", `addItem.php?id=${id}&s=0`, true);
    xhttp.send();
  }
  else if (document.getElementById(`item${id}`).checked == true){
    console.log("Checked");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById(`label${id}`).style.textDecoration = "line-through";
    ***REMOVED***
  ***REMOVED***;
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
  ***REMOVED***
***REMOVED***;
  xhttp.open("GET", `../inc/delItem.inc.php?id=${id}`, true);
  xhttp.send();
}
