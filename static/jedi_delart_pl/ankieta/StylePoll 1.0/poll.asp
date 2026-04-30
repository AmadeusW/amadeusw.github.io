<% @Language= VBScript  %>
<% Option Explicit %>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Poll</title>
		
</head>

<!-- the User can cut this part and use it anywhere in his desired asp file -->
<!-- Cut and paste starts here -->

<script language  = JavaScript>
function resultswindow()
{
window.open("results.asp" ,"popup","top=5, left=30,toolbars=no,maximize=yes,resize=yes,width=300,height=200,location=no,directories=no,scrollbars=yes");
}	
</script>	

<%
Dim conn,EnSQL,countSQL,selSQL,rsRecset,intNoofoptions,strPollQuestion,strPollans1,strPollans2
Dim  strPollans3, strPollans4, strPollans5, i,j,k,intPollvalue,RecCount,UpSQL,RsUpdate
Dim strPollans(6),intNoAns,intTotalpoll,intCountpoll 
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
  intTotalpoll = rsRecset("fldTotalpoll")
  k = 1
  for j = 2 to 7
  strPollans(k) = rsRecset(j)
  k = k + 1
  next
  %>
 <body>
<div align="center"></div>
<table width="23%" bgcolor="#CCCCCC" height="140">
  <tr> 
    <td height="141" colspan="2"> 
      <form method="get" name="Pollform" action="" >
        <br>
        <%= strPollQuestion %> <% for i = 1 to  intNoofoptions %> 
        <p></p>
        <div align="left">
          <input type="radio" name="StylePoll" value=<%=i%>>
          <%= strPollans(i) %> <br>
          <% next %> <br>
          <br>
          <input type="submit" name="btnPoll" value="Poll" >
          <input type="submit" name="btnResults" value="Results" >
        </div>
      </form>
      
    </td>
  </tr>
  <tr> 
    <td height="11">
      <div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b>Powered 
        By</b></font></div>
    </td>
    <td height="11">
      <div align="left"><a href="http://www.stylusinc.com/website/free_scripts/ASP/stylepoll.htm"><img src="images/stylepoll.gif" width="59" height="19" border="0"></a></div>
    </td>
  </tr>
  <tr> 
    <td height="39" colspan="2"><% 
if request.querystring ("btnResults") = "Results" then
		session("countPoll") = 1
	 %> 
      <script language = javascript>resultswindow()</script>
      <% 
Else	

	if session("PollStatus") = true then
		if request.querystring ("btnPoll") = "Poll" then
			session("countPoll") = 2
	
	%> 
      <script language = javascript>resultswindow()</script>
      <% 
		end if
	else
		if request.querystring ("Stylepoll") <> "" then
			intPollvalue = request.querystring ("Stylepoll")
			intNoAns = rsRecset("fldAns" & intPollvalue & "tot")
			UpSQL = "Update stylepoll set fldAns" & intPollvalue & "tot = (" & intNoAns & "+1),fldTotalpoll = (" & intTotalpoll & "+1) where fldpollquestion = '" & strPollquestion & "'" 
			set RsUpdate = conn.execute(UpSQL)
			session("PollStatus") = true
			set RsUpdate = nothing
			set RecCount = nothing
			set rsRecset = nothing
			conn.close
			set conn = nothing
	
%> 
      <script language = javascript> resultswindow()</script>
      <% 	
		end if
	end if 
End if
%>
 <!-- Cut & paste ends here --></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><b><font color="#990033">How to add this Poll to your site?</font></b><br>
  Just open this ASP file in a text editor and cut the code which resides inside 
  the comment tags which you find there and paste it to your html file and upload 
  the page which contains this poll ito your server. Remember poll.asp,results.asp,global.asp 
  and the images folder should be in the same directory where your webpage which 
  has the poll is.<br>
</p>
<p><b>&copy; All rights reserved. <a href="http://www.stylusinc.com/">Stylusinc.com</a> 
  2000 Developed by Stylusinc.com Web development team. </b></p>
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

