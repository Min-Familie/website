function checkEmpty(){
    let text = document.getElementById('nyItem').value.replace(/\s+/g, ' ').trim();
    if (!text.replace(/\s/g, '').length){
      error();
      return false;
    }
    return true;
}
function error(){
    document.getElementById("errorMessage").innerHTML = "Feltet er tomt";
    document.getElementById("nyItemForm").reset();
    setTimeout(function(){
      document.getElementById("errorMessage").innerHTML = "";
    }, 2000);
}