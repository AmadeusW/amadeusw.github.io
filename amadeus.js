$( "#article1link" ).click(function() {
  $( "#test" )
    .animate({
      width: "90%"
    }, {
      queue: false,
      duration: 3000
    })
    .animate({ fontSize: "24px" }, 1500 )
    .animate({ borderRightWidth: "15px" }, 1500 );
});
 
$( "#go2" ).click(function() {
  $( "#block2" )
    .animate({ width: "90%" }, 1000 )
    .animate({ fontSize: "24px" }, 1000 )
    .animate({ borderLeftWidth: "15px" }, 1000 );
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