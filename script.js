
function togglePageSidebar() {
  console.log(window.location.pathname);
  if(window.location.pathname.endsWith('index.php')){
    hideSidebar();
  } else{
    displaySidebar();
  }
}

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

function printCurrentTime(){
  var currentDate = new Date();
  time = currentDate.toLocaleString();
  return time;
}

function handleCommentWriter(event){ //method to call makeComment method when user presses enter on textfield
  if(event.keyCode == 13 && document.getElementById("comment-writer").value != ""){
    makeComment();
  }
}

function makeComment(){
  const commentContainer = document.querySelector(".comments-container");
  var commentText = document.getElementById("comment-writer");
  console.log(commentText);
  var commentHTML = `
                <div class="comments">
                  <img src="/youtube-clone/Images/user.png" width="30px">
                  <div class="comments-data">
                      <div class="comment-name-date">
                          <p class="comment-name">User</p>
                          <p class="comment-date">`+printCurrentTime()+`</p>
                      </div>
                      <p class="comment-text">`+commentText.value+`</p>
                      <div class="feedback">
                          <button class="comment-feedback"><i class="fa fa-thumbs-up"></i></button>
                          <button class="comment-feedback"><i class="fa fa-thumbs-down fa-flip-horizontal"></i></button>
                          <button class="comment-feedback"><p>Reply</p></button>
                      </div>
                  </div>
                </div>`
                ;
  commentContainer.insertAdjacentHTML('afterbegin', commentHTML);
  commentText.value = "";
}

function onUserInfoClick(){
  // document.querySelector('.dropdown').style.display = 'flex';
  const dropdown = document.querySelector('.dropdown');
  dropdown.classList.toggle("open-menu");
}

var likeButton = document.getElementById('like-button');
var dislikeButton = document.getElementById('dislike-button');

function likeVideo(){
  const likeIcon = document.getElementById('like-icon');
  if (likeIcon.classList.contains('fa-thumbs-o-up')) {
    likeIcon.classList.remove('fa-thumbs-o-up');
    likeIcon.classList.add('fa-thumbs-up');
    dislikeButton.disabled = true;
  } else {
    likeIcon.classList.remove('fa-thumbs-up');
    likeIcon.classList.add('fa-thumbs-o-up');
    dislikeButton.disabled = false;
  }

}

function dislikeVideo(){
  const dislikeIcon = document.getElementById('dislike-icon');

  if (dislikeIcon.classList.contains('fa-thumbs-o-down')) {
    dislikeIcon.classList.remove('fa-thumbs-o-down');
    dislikeIcon.classList.add('fa-thumbs-down');
    likeButton.disabled = true;
  } else {
    dislikeIcon.classList.remove('fa-thumbs-down');
    dislikeIcon.classList.add('fa-thumbs-o-down');
    likeButton.disabled = false;
  }
}