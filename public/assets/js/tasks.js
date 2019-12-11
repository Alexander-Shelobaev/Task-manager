function sendForm(e){
  var whereBox = document.search.where;
  var val = whereBox.value;
  console.log(val);
  if (val == '') {whereBox.value = '%%'}; 
}
var sendButton = document.getElementById("btnSearch");
sendButton.addEventListener("click", sendForm);