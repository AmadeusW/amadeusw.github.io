// Used to control the direction of animation
var newSectionId = 0;
var lastSectionId = 0;

$(document).ready(function(){
  setTimeout(a1, 100);

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
  newSectionId = 1;
  showSection("a1s1");
  hideSection("a1s2");
  hideSection("a1s3");
  lastSectionId = 1;
}

function a1s2() {
  newSectionId = 2;
  hideSection("a1s1");
  showSection("a1s2");
  hideSection("a1s3");
  lastSectionId = 2;
}

function a1s3() {  
  newSectionId = 3;
  hideSection("a1s1");
  hideSection("a1s2");
  showSection("a1s3");
  lastSectionId = 3;
}

function a2s1() {
  newSectionId = 1;
  showSection("a2s1");
  hideSection("a2s2");
  hideSection("a2s3");
  hideSection("a2s4");
  lastSectionId = 1;
}

function a2s2() {
  newSectionId = 2;
  hideSection("a2s1");
  showSection("a2s2");
  hideSection("a2s3");
  hideSection("a2s4");
  lastSectionId = 2;
}

function a2s3() {
  newSectionId = 3;
  hideSection("a2s1");
  hideSection("a2s2");
  showSection("a2s3");
  hideSection("a2s4");
  lastSectionId = 3;
}

function a2s4() {
  newSectionId = 4;
  hideSection("a2s1");
  hideSection("a2s2");
  hideSection("a2s3");
  showSection("a2s4");
  lastSectionId = 4;
}

function a3s1() {
  newSectionId = 1;
  showSection("a3s1");
  hideSection("a3s2");
  hideSection("a3s3");
  lastSectionId = 1;
}

function a3s2() {
  newSectionId = 2;
  hideSection("a3s1");
  showSection("a3s2");
  hideSection("a3s3");
  lastSectionId = 2;
}

function a3s3() {
  newSectionId = 3;
  hideSection("a3s1");
  hideSection("a3s2");
  showSection("a3s3");
  lastSectionId = 3;
}

function a4s1() {
  newSectionId = 1;
  showSection("a4s1");
  hideSection("a4s2");
  hideSection("a4s3");
  lastSectionId = 1;
}

function a4s2() {
  newSectionId = 2;
  hideSection("a4s1");
  showSection("a4s2");
  hideSection("a4s3");
  lastSectionId = 2;
}

function a4s3() {
  newSectionId = 3;
  hideSection("a4s1");
  hideSection("a4s2");
  showSection("a4s3");
  lastSectionId = 3;
}

function a5s1() {
  newSectionId = 1;
  showSection("a5s1");
  hideSection("a5s2");
  hideSection("a5s3");
  lastSectionId = 1;
}

function a5s2() {
  newSectionId = 2;
  hideSection("a5s1");
  showSection("a5s2");
  hideSection("a5s3");
  lastSectionId = 2;
}

function a5s3() {
  newSectionId = 3;
  hideSection("a5s1");
  hideSection("a5s2");
  showSection("a5s3");
  lastSectionId = 3;
}

function a6s1() {
  newSectionId = 1;
  showSection("a6s1");
  hideSection("a6s2");
  lastSectionId = 1;
}

function a6s2() {
  newSectionId = 2;
  hideSection("a6s1");
  showSection("a6s2");
  lastSectionId = 2;
}

function showSection(id) {

  var initialPaddingLeft = '30px';
  var initialPaddingRight = '20px';
  if (newSectionId >= lastSectionId)
  {
    initialPaddingLeft = '50px';
    initialPaddingRight = '0px';
  }

  $( "#" + id ).stop().show()
    .css({
      'paddingLeft': initialPaddingLeft,
      'paddingRight': initialPaddingRight,
       'opacity': '0'})
    .animate({
      'paddingLeft': '40px',
      'paddingRight': '10px',
      'opacity': '1'
    }, 'slow');
  $( "#" + id + "link").addClass("selected"); 
  ga('send', 'event', 'menu', 'navigation', id);
}

function hideSection(id) {
  $( "#" + id ).stop().hide();
  $( "#" + id + "link").removeClass("selected");
}

function showArticle(id) {
  $( "#"+id+" > header" ).stop()
    .css({
      'paddingLeft': '20px',
      'opacity': '0'
    })
    .animate({
      'paddingLeft': '40px',
      'opacity': '1'
    }, 'slow');
  $( "#"+id+" > nav" ).stop()
    .css({
      'paddingLeft': '10px',
    })
    .animate({
      'paddingLeft': '40px',
    }, 'slow')
    .find( "li" ).each(function(id) {
      $(this).stop().css({
        'opacity': '0',
        'margin-right': '20px'
      })
      .delay(100 + id*200)
      .animate({
        'opacity': '1',
        'margin-right': '30px'
      }, 'slow');
    });
}
