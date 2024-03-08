function hideSidebar() {

  var sidebar = document.querySelector("sidebar");
  var sidebarMin = document.querySelector("sidebar-min");
  var maxElements = sidebar.getElementsByClassName("sidebar-max");
  var minElements = sidebar.getElementsByClassName("sidebar-min");
  var frontpage = document.getElementById("frontpage");

  if (maxElements[0].style.display == "none") {
    for(var i=0; i<maxElements.length;i++){
      maxElements[i].style.display = "block";
    }
    for(var i=0; i<minElements.length;i++){
      minElements[i].style.display = "none";
    }
    frontpage.style.marginLeft = "200px";
  } else {
    for(var i=0; i<maxElements.length;i++){
      maxElements[i].style.display = "none";
    }
    for(var i=0; i<minElements.length;i++){
      minElements[i].style.display = "block";
    }
    frontpage.style.marginLeft = "80px";
  }
}

function showMore() {
  var show = document.getElementById("show-more");
  if(show.style.display == "block"){
    show.style.display = "none";
  } else{
    show.style.display = "block";
  }
}