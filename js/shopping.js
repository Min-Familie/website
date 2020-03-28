function run(){
    let item = document.getElementById('nyItem').value;
    let amount = document.getElementById('amount').value;
    let price = document.getElementById('price').value;
    let family_id = document.getElementById('family_id').value;
    if(!price){
        price = null;
    }
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          location.reload();
        }
      };
    xhttp.open("GET", `shoppingAdd.php?item="${item}"&amount=${amount}&price=${price}&family_id=${family_id}`, true);
    xhttp.send();
    document.getElementById("nyItemForm").reset();
 }
