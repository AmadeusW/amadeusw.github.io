<% @Language= VBScript  %>
<% Option Explicit 
 Response.Buffer = True %>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Poll results</title>
</head>
<%
Dim conn,EnSQL,countSQL,selSQL,rsRecset,intNoofoptions,strPollQuestion,strPollans1,strPollans2
Dim  i,j,k,l,m,n,p,q,intPollvalue,RecCount,UpSQL,RsUpdate,imgColor(6)
Dim strPollans(6),intNoAns(6),percentAns(6),intWidth(6),intTotalpoll 
Response.Clear
Response.Expires = 0 
	if session("CountPoll") = 2 then
		response.write "<Center><b> Sorry! You have already Polled !</b></center>"
	end if
	set conn = server.createobject("ADODB.Connection")
	conn.open "DSN=advteamdsn;UID=;PWD=;" 
  	EnSQL = "select * from Stylepoll where fldPollstate = yes "
	set rsRecset = conn.execute(EnSQL)
	if rsRecset.BOF = true and rsRecset.EOF = true then
		selSQL = "select * from Stylepoll"
		countSQL = "select count (*) from stylepoll"
		set RecCount = conn.execute(countSQL)
		set rsRecset = conn.execute(selSQL)
		while i < RecCount(0)-1 
			rsRecset.movenext
			i = i + 1
		wend 
	end if
  	intNoofoptions = rsRecset(15)
  	strPollQuestion = rsRecset(0)
  	if rsRecset("fldTotalpoll") = "" then
		response.write "<center><b>Nobody has Polled yet ! <br></center>"
		response.write "<center>You can start Polling Now. </b><br></center>"
	elseif rsRecset("fldTotalpoll") = 0 then
		response.write "<center><b>Nobody has Polled yet ! <br></center>"
		response.write "<center>You can start Polling Now. </b><br></center>"
	else
		intTotalpoll = rsRecset("fldTotalpoll")
    	k = 1
 		for j = 2 to 7
  			strPollans(k) = rsRecset(j)
	  		k = k + 1
	 	next
 		l = 1
	 	p = 1
		n = 1
	 	for m = 8 to 13
 			intNoAns(l) = rsRecset(m)
			percentAns(p) = cint((intNoAns(l) / intTotalpoll) * 100)
			intWidth(n) = percentAns(p) * 3 
			'imgColor(q)
			n = n + 1
			p = p + 1
			l = l + 1
		next
		imgColor(1) = "images/blue.gif"
		imgColor(2) = "images/yellow.gif"
		imgColor(3) = "images/orange.gif"
		imgColor(4) = "images/black.gif"
		imgColor(5) = "images/green.gif"
		imgColor(1) = "images/red.gif"
		
%>
 <body>
<center>
<font size="3" color="Maroon"><strong><%= strPollQuestion  %></strong></font>
<br><br>
  <table width="52%" height="30" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
    <% for i = 1 to  intNoofoptions %> 
    <tr>
      <td height="20" width="32%" bgcolor="#CCCCFF"><b><%= strPollans(i) %></b></td>
      <td height="20" width="48%"> 
        <p><img src="<%= imgColor(i) %>" width="<%= intWidth(i) %>" height="10"> 
        </p>
      </td>
      <td height="20" width="20%" bgcolor="#CCFFCC"><%= percentAns(i) & "%" %></td>
  </tr>
   <% next %> 
</table><br>
  <% 
	response.write "<centre> Total Number of Polls are " & intTotalpoll & "<br>"
%> <b><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Powered By</font></b> 
  <a href="http://www.stylusinc.com/website/free_scripts/ASP/stylepoll.htm"><img src="images/stylepoll.gif" width="59" height="19" border="0"></a><br>
<% 
		set rsRecset = nothing
		set RecCount = nothing
		conn.close
		set conn = nothing
		Response.Flush
		response.End
	End if

%>
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
	var tag = "<A HREF=\"http://www.jedi.delart.pl">"+
	"<IMG SRC=\"http://www.jedi.delart.pl/banner.gif"+r+
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

</center></body></html>
