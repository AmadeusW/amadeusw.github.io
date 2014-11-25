$(document).ready(function(){
  showArticle1();
  $( "#article1link" ).click(showArticle1);
  $( "#article2link" ).click(showArticle2);
  $( "#a1s1link" ).click(a1s1);
  $( "#a1s2link" ).click(a1s2);
  $( "#a2s1link" ).click(a2s1);
  $( "#a2s2link" ).click(a2s2);  
  $( "#a2s3link" ).click(a2s3);
});

function showArticle1() {
  $("#article1").show();
  $("#article2").hide();
  a1s1();
  $( "#article1 > header" ).stop()
    .css({
      'marginLeft': '60px',
      'opacity': '0'
    })
    .animate({
      'marginLeft': '40px',
      'opacity': '1'
    }, 'slow');
  $( "#article1 > nav" ).stop()
    .css({
      'marginLeft': '80px',
      'opacity': '0'
    })
    .animate({
      'marginLeft': '40px',
      'opacity': '1'
    }, 'slow');    
}

function a1s1() {
  $( "#a1s2").stop().hide();
  $( "#a1s1" ).stop().show()
    .css({
      'marginLeft': '30px',
       'opacity': '0'})
    .animate({
      'marginLeft': '40px',
      'opacity': '1'
    }, 'slow');
  $( "#a1s1link").addClass("selected");
  $( "#a1s2link").removeClass("selected");
}

function showArticle2() {
  $("#article1").hide();
  $("#article2").show();
  a2s1();
  $( "#article2 > header" ).stop()
    .css({
      'marginLeft': '60px',
      'opacity': '0'
    })
    .animate({
      'marginLeft': '40px',
      'opacity': '1'
    }, 'slow');
  $( "#article2 > nav" ).stop()
    .css({
      'marginLeft': '80px',
      'opacity': '0'
    })
    .animate({
      'marginLeft': '40px',
      'opacity': '1'
    }, 'slow');      
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
