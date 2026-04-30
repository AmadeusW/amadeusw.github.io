
<% @Language=VBScript  %>
<% option explicit %>
<% response.buffer = TRUE %>
<%  Dim strPolltitle,intNoofoptions,strNoofoptions,i
	intNoofoptions = cint(request.form("slttNoofoptions"))
    strNoofoptions = request.form("slttNoofoptions")
		
 %>
 <html>
<head>
<title>Poll Generation</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
 
<body bgcolor="#FFFFFF">					   

<center>
  <b><font size="4">Generate the Poll</font></b> 
</center>
<form method="get" action="GenerateForm.asp" name="quizgenerate">
  <p><i><b>Step 2.</b></i></p>
  <p>Please enter your question here:<br>
    <input type="text" name="txtQuestion" maxlength="80" size="80"><br>
	<p><b><i>Step 3.</i></b></p>
	<p>Please enter your choices of answers here:</p>
    <% for i = 1 to  intNoofoptions %> <p></p>
  
  
  <p></p>
   		
  <p><font color="#FF0033" size="3" face="Verdana, Arial, Helvetica, sans-serif"><b>Polling 
    Option </b></font><font face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#FF0033"><%=i %></font></b></font> 
    <input type="text" name= <%= "txtQ" & i %> size="40" >
   	    <br>
  	 <% next %> 
	
	<input type="hidden" name="hidOptions" value= <%= strNoofoptions  %> >
	<p> 
    <input type="submit" name="btnGenerate" value="Continue..">
  </p>
  <%= strPolltitle  %> 
  <p>&nbsp;</p>
</form>
<div align="center"><br>
  <br>
  &copy; All rights reserved. <a href="http://www.stylusinc.com/">Stylusinc.com</a> 
  2000 Developed by Stylusinc.com Web development team. </div>
<center>
<!-- Start of GoldStats  Web Stats Code. Do not alter this code!-->
 <SCRIPT language="javascript"><!--
	var sw="";
	var sh="";
	var c="";
	var j="u";
	var r=""+escape(top.document.referrer);
        var p="";
	var js="1.0";
	var acc="o]ciuysmteabyo[tlsn[cm";
	var tag = "<A HREF=\"http://goldstats.com/cgi-bin/stats-bin/do/link.cgi?id=o]ciuysmteabyo[tlsn[cm\">"+
	"<IMG SRC=\"http://goldstats.com/cgi-bin/stats-bin/do/stats.cgi?j=u&r="+r+
	"&js="+js+"&id=o]ciuysmteabyo[tlsn[cm\""+" BORDER=0 target=_top></A>";
 //--></SCRIPT> 
 <SCRIPT language="javascript1.1"><!--
	js="1.1";
 //--></SCRIPT>
 <SCRIPT language="javascript1.2"><!--
	sw=screen.width;
	sh=screen.height;
	js="1.2";
	var v=navigator.appName;
  	if (v != "Netscape") {
		c=screen.colorDepth;
	} else {
		c=screen.pixelDepth;
	};
	j=navigator.javaEnabled();
	if (v == "Netscape")  {
	    for (i = 0; i < navigator.plugins.length; ++i) p += navigator.plugins[i].name + ';';
	    p = escape(p);
	}
	if (v == "Opera")  {
  	    for (i = 0; i < navigator.plugins.length; ++i) p += navigator.plugins[i].name + ';';
            p = escape(p);
  	}
 //--></SCRIPT>
 <SCRIPT language="javascript1.3"><!--
	js="1.3";
 //--></SCRIPT>
 <SCRIPT language="javascript1.4"><!--
	js="1.4%2B";
 //--></SCRIPT> 
 <SCRIPT SRC="http://goldstats.com/cgi-bin/stats-bin/do/get_code.cgi"><!--
 //--></SCRIPT>
 <script language="javascript"><!--
	document.write(tag); //-->
 </script>
 <NOSCRIPT>
 <A HREF="http://goldstats.com/cgi-bin/stats-bin/do/link.cgi?id=o]ciuysmteabyo[tlsn[cm" target="_blank"><IMG 
 SRC="http://goldstats.com/cgi-bin/stats-bin/do/stats.cgi?j=u&r=u&id=o]ciuysmteabyo[tlsn[cm"
 BORDER=0></A>
 </NOSCRIPT>
<!-- End of GoldStats  Web Stats Code -->


</center>
</body>
</html>
