// function openNav() {
//   document.getElementById("mySidenav").style.width = "250px";
// }

// function closeNav() {
//   document.getElementById("mySidenav").style.width = "0";
// }

// function myToggle() {
//   var x = document.getElementById("mySidenav");
//   if (x.style.display === "none") {
//     x.style.display = "block";
//   } else {
//     x.style.display = "none";
//   }
// }

$(document).ready(function(){
  $("#mainToggle").click(function(){
    $("#mySidenav").toggle();
  });
});
