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

function displaySidebar(){
  var sidebar = document.getElementById("video-sidebar");
  if(sidebar.style.display == "block"){
    sidebar.style.display = "none";
    document.querySelector("main").style.opacity = "100%";
    document.querySelector("main").style.pointerEvents = "auto";
  } else{
    sidebar.style.display = "block";
    document.querySelector("main").style.opacity = "50%";
    document.querySelector("main").style.pointerEvents = "none";
  }
}

function makeComment(){
  const commentContainer = document.querySelector(".comments-container");
  var commentText = document.getElementById("comment-writer").value;
  console.log(commentText);
  var commentHTML = `
                <div class="comments">
                  <img src="/youtube-clone/Images/user.png" width="30px">
                  <div class="comments-data">
                      <div class="comment-name-date">
                          <p class="comment-name">User</p>
                          <p class="comment-date">Just Now</p>
                      </div>
                      <p class="comment-text">`+commentText+`</p>
                      <div class="feedback">
                          <button class="comment-feedback"><i class="fa fa-thumbs-up"></i></button>
                          <button class="comment-feedback"><i class="fa fa-thumbs-down fa-flip-horizontal"></i></button>
                          <button class="comment-feedback"><p>Reply</p></button>
                      </div>
                  </div>
                </div>`
                ;
  commentContainer.innerHTML += commentHTML;
}