$(document).ready(function(){
  a1();
  $( "#article1link" ).click(a1);
  $( "#article2link" ).click(a2);
  $( "#a1s1link" ).click(a1s1);
  $( "#a1s2link" ).click(a1s2);
  $( "#a2s1link" ).click(a2s1);
  $( "#a2s2link" ).click(a2s2);  
  $( "#a2s3link" ).click(a2s3);
});

function a1() {
  $("#article1").show();
  $("#article2").hide();
  a1s1();
  showArticle("article1");
}

function a2() {
  $("#article1").hide();
  $("#article2").show();
  a2s1();
  showArticle("article2");
}

function a1s1() {
  showSection("a1s1");
  hideSection("a1s2");
}

function a1s2() {
  hideSection("a1s1");
  showSection("a1s2");
}

function a2s1() {
  showSection("a2s1");
  hideSection("a2s2");
  hideSection("a2s3");
}

function a2s2() {
  hideSection("a2s1");
  showSection("a2s2");
  hideSection("a2s3");
}

function a2s3() {
  hideSection("a2s1");
  hideSection("a2s2");
  showSection("a2s3");
}

function showSection(id) {
  $( "#" + id ).stop().show()
    .css({
      'marginLeft': '30px',
       'opacity': '0'})
    .animate({
      'marginLeft': '40px',
      'opacity': '1'
    }, 'slow');
  $( "#" + id + "link").addClass("selected");    
}

function hideSection(id) {
  $( "#" + id ).stop().hide();
  $( "#" + id + "link").removeClass("selected");
}

function showArticle(id) {
  $( "#"+id+" > header" ).stop()
    .css({
      'marginLeft': '60px',
      'opacity': '0'
    })
    .animate({
      'marginLeft': '40px',
      'opacity': '1'
    }, 'slow');
  $( "#"+id+" > nav" ).stop()
    .css({
      'marginLeft': '80px',
      'opacity': '0'
    })
    .animate({
      'marginLeft': '40px',
      'opacity': '1'
    }, 'slow');    
}
