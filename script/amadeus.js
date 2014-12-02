$(document).ready(function(){
  a1();
  $( "#article1link" ).click(a1);
  $( "#article2link" ).click(a2);
  $( "#article3link" ).click(a3);
  $( "#article4link" ).click(a4);
  $( "#article5link" ).click(a5);
  $( "#article6link" ).click(a6);

  $( "#a1s1link" ).click(a1s1);
  $( "#a1s2link" ).click(a1s2);
  $( "#a1s3link" ).click(a1s3);

  $( "#a2s1link" ).click(a2s1);
  $( "#a2s2link" ).click(a2s2);  
  $( "#a2s3link" ).click(a2s3);
  $( "#a2s4link" ).click(a2s4);

  $( "#a3s1link" ).click(a3s1);
  $( "#a3s2link" ).click(a3s2);
  $( "#a3s3link" ).click(a3s3);  

  $( "#a4s1link" ).click(a4s1);
  $( "#a4s2link" ).click(a4s2);
  $( "#a4s3link" ).click(a4s3); 

  $( "#a5s1link" ).click(a5s1);
  $( "#a5s2link" ).click(a5s2);
  $( "#a5s3link" ).click(a5s3); 

  $( "#a6s1link" ).click(a6s1);
  $( "#a6s2link" ).click(a6s2);
});

function a1() {
  $("#article1").show();
  $("#article2").hide();
  $("#article3").hide();
  $("#article4").hide();
  $("#article5").hide();
  $("#article6").hide();
  a1s1();
  showArticle("article1");
}

function a2() {
  $("#article1").hide();
  $("#article2").show();
  $("#article3").hide();
  $("#article4").hide();
  $("#article5").hide();
  $("#article6").hide();  
  a2s1();
  showArticle("article2");
}

function a3() {
  $("#article1").hide();
  $("#article2").hide();
  $("#article3").show();
  $("#article4").hide();
  $("#article5").hide();
  $("#article6").hide();  
  a3s1();
  showArticle("article3");
}

function a4() {
  $("#article1").hide();
  $("#article2").hide();
  $("#article3").hide();
  $("#article4").show();
  $("#article5").hide();
  $("#article6").hide();  
  a4s1();
  showArticle("article4");
}

function a5() {
  $("#article1").hide();
  $("#article2").hide();
  $("#article3").hide();
  $("#article4").hide();
  $("#article5").show();
  $("#article6").hide();  
  a5s1();
  showArticle("article5");
}

function a6() {
  $("#article1").hide();
  $("#article2").hide();
  $("#article3").hide();
  $("#article4").hide();
  $("#article5").hide();
  $("#article6").show();  
  a6s1();
  showArticle("article6");
}

function a1s1() {
  showSection("a1s1");
  hideSection("a1s2");
  hideSection("a1s3");
}

function a1s2() {
  hideSection("a1s1");
  showSection("a1s2");
  hideSection("a1s3");
}

function a1s3() {  
  hideSection("a1s1");
  hideSection("a1s2");
  showSection("a1s3");
}

function a2s1() {
  showSection("a2s1");
  hideSection("a2s2");
  hideSection("a2s3");
  hideSection("a2s4");
}

function a2s2() {
  hideSection("a2s1");
  showSection("a2s2");
  hideSection("a2s3");
  hideSection("a2s4");
}

function a2s3() {
  hideSection("a2s1");
  hideSection("a2s2");
  showSection("a2s3");
  hideSection("a2s4");
}

function a2s4() {
  hideSection("a2s1");
  hideSection("a2s2");
  hideSection("a2s3");
  showSection("a2s4");
}

function a3s1() {
  showSection("a3s1");
  hideSection("a3s2");
  hideSection("a3s3");
}

function a3s2() {
  hideSection("a3s1");
  showSection("a3s2");
  hideSection("a3s3");
}

function a3s3() {
  hideSection("a3s1");
  hideSection("a3s2");
  showSection("a3s3");
}

function a4s1() {
  showSection("a4s1");
  hideSection("a4s2");
  hideSection("a4s3");
}

function a4s2() {
  hideSection("a4s1");
  showSection("a4s2");
  hideSection("a4s3");
}

function a4s3() {
  hideSection("a4s1");
  hideSection("a4s2");
  showSection("a4s3");
}

function a5s1() {
  showSection("a5s1");
  hideSection("a5s2");
  hideSection("a5s3");
}

function a5s2() {
  hideSection("a5s1");
  showSection("a5s2");
  hideSection("a5s3");
}

function a5s3() {
  hideSection("a5s1");
  hideSection("a5s2");
  showSection("a5s3");
}

function a6s1() {
  showSection("a6s1");
  hideSection("a6s2");
}

function a6s2() {
  hideSection("a6s1");
  showSection("a6s2");
}

function showSection(id) {
  $( "#" + id ).stop().show()
    .css({
      'paddingLeft': '30px',
      'paddingRight': '10px',
       'opacity': '0'})
    .animate({
      'paddingLeft': '40px',
      'paddingRight': '0px',
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
      'paddingLeft': '60px',
      'opacity': '0'
    })
    .animate({
      'paddingLeft': '40px',
      'opacity': '1'
    }, 'slow');
  $( "#"+id+" > nav" ).stop()
    .css({
      'paddingLeft': '80px',
      'opacity': '0'
    })
    .animate({
      'paddingLeft': '40px',
      'opacity': '1'
    }, 'slow');    
}
