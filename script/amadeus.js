
$(document).ready(function(){
  $( "#article1link" ).click(function() {
    $("#article1").show();
    $("#article2").hide();
    $( "#test" )
      .animate({
        margin-right: 20px;
      }
  });
  $( "#article2link" ).click(function() {
    $("#article2").show();
    $("#article1").hide();
    $( "#test" )
      .animate({
        margin-right: 20px;
      }
});

$( "#go3" ).click(function() {
  $( "#go1" ).add( "#go2" ).click();
});
 
$( "#go4" ).click(function() {
  $( "div" ).css({
    width: "",
    fontSize: "",
    borderWidth: ""
  });
});