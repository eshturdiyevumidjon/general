let header = document.getElementById("header");
let sidenav = document.getElementById("mySidenav");
let sticky = header.offsetTop;
sidenav.style.top = header.offsetHeight + "px";

document.addEventListener("DOMContentLoaded", () => {
  let wrapped = document.getElementById("wrapped");
  if (wrapped) {
    wrapped.addEventListener("scroll", function() {
      let translate = "translate(0, "+this.scrollTop+"px)";
      this.querySelector("thead").style.transform = translate;
    });
  }

  openNav();

  bsCustomFileInput.init();

});

window.onscroll = function() {myFunction()};

function openNav() {
  let sidebar = document.getElementById("sidebar");
  let content = document.getElementById("main");
  if(sidebar.style.display == "block") {
    sidebar.style.display = "none";
    content.style.marginLeft= "0";
  } else {
    sidebar.style.display = "block";
    content.style.marginLeft = sidebar.offsetWidth + "px";
  }
}

function togglePlusMinus(event) {
  let x = event.currentTarget;
  if(x.classList.contains("collapsed")) {
    x.getElementsByTagName('svg')[0].classList.remove("fa-plus");
    x.getElementsByTagName('svg')[0].classList.add("fa-minus");
  } else {
    x.getElementsByTagName('svg')[0].classList.remove("fa-minus");
    x.getElementsByTagName('svg')[0].classList.add("fa-plus");
  }
}

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
