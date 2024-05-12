
function togglePageSidebar() {
  console.log(window.location.pathname);
  if(!window.location.pathname.endsWith('video.php')){
    hideSidebar();
  } else{
    displaySidebar();
  }
}

function hideSidebar() {

  var sidebar = document.querySelector("sidebar");
  var maxElements = sidebar.querySelector(".sidebar-max");
  var minElements = sidebar.querySelector(".sidebar-min");
  var frontpage = document.getElementById("frontpage");

  if(!maxElements.classList.contains('hide')){
    maxElements.classList.add('hide');
    minElements.classList.remove('hide');
    frontpage.style.marginLeft = "80px";
  } else {
    maxElements.classList.remove('hide');
    minElements.classList.add('hide');
    
    frontpage.style.marginLeft = "200px";
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

document.addEventListener("DOMContentLoaded", function() { //to hide sidebar by default on video page
  if(window.location.pathname.endsWith("/video.php")){
    var sidebar = document.querySelector(".sidebar-max");
    sidebar.style.display = "none";
  }
});

function displaySidebar(){
  var sidebar = document.querySelector(".sidebar-max");
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
  var commentText = document.getElementsByName("comment-writer")[0];
  console.log(commentText);
  var commentHTML = `
                <div class="comments">
                  <img src="Images/user.png" width="30px">
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
  
  var form = document.createElement('form');
  form.method = 'post';
  form.action = 'make_comment.php';
  form.target = '_blank';

  var comment = document.createElement('input');
  comment.type = 'hidden';
  comment.name = 'comment';
  comment.value = commentText.value;

  form.appendChild(comment);

  var ID = document.createElement('input');
  ID.type = 'hidden';
  ID.name = 'videoID';
  ID.value = videoID;

  form.appendChild(ID);

  document.body.appendChild(form);
  form.submit();
  document.body.removeChild(form);

  commentText.value = "";
}

function onUserInfoClick(){
  // document.querySelector('.dropdown').style.display = 'flex';
  const dropdown = document.querySelector('.dropdown');
  dropdown.classList.toggle("open-menu");
}

var likeButton = document.getElementById('like-button');
var dislikeButton = document.getElementById('dislike-button');
const urlParams = new URLSearchParams(window.location.search);
const videoID = urlParams.get('videoID');

function likeVideo(){
  const likeIcon = document.getElementById('like-icon');
  if (likeIcon.classList.contains('fa-thumbs-o-up')) { //Like Button Pressed
    likeIcon.classList.remove('fa-thumbs-o-up');
    likeIcon.classList.add('fa-thumbs-up');
    dislikeButton.disabled = true;

    updateLikes('increment');

  } else { //Like Button Unpressed
    likeIcon.classList.remove('fa-thumbs-up');
    likeIcon.classList.add('fa-thumbs-o-up');

    updateLikes('decrement');

    dislikeButton.disabled = false;
  }

}

function dislikeVideo(){
  const dislikeIcon = document.getElementById('dislike-icon');
  
  if (dislikeIcon.classList.contains('fa-thumbs-o-down')) { //Dislike Button Pressed
    dislikeIcon.classList.remove('fa-thumbs-o-down');
    dislikeIcon.classList.add('fa-thumbs-down');
    likeButton.disabled = true;
    updateDislikes('increment');
  } else { //Dislike Button Unpressed
    dislikeIcon.classList.remove('fa-thumbs-down');
    dislikeIcon.classList.add('fa-thumbs-o-down');
    likeButton.disabled = false;
    updateDislikes('decrement');
  }
}



function updateLikes(action){
  var form = document.createElement('form');
  form.method = 'post';
  form.action = 'like_dislike.php';
  // form.target = '_blank';

  var input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'likes';
  input.value = action;

  form.appendChild(input);

  var ID = document.createElement('input');
  ID.type = 'hidden';
  ID.name = 'videoID';
  ID.value = videoID;

  form.appendChild(ID);

  document.body.appendChild(form);
  form.submit();

  document.body.removeChild(form);
}

function updateDislikes(action){
  var form = document.createElement('form');
  form.method = 'post';
  form.action = 'like_dislike.php';
  // form.target = '_blank';

  var input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'dislikes';
  input.value = action;

  form.appendChild(input);

  var ID = document.createElement('input');
  ID.type = 'hidden';
  ID.name = 'videoID';
  ID.value = videoID;

  form.appendChild(ID);

  document.body.appendChild(form);
  form.submit();

  document.body.removeChild(form);
}