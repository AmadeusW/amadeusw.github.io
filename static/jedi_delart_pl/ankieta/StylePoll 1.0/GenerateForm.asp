<% @Language= VBScript  %>
<% Option Explicit %>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Generate Form</title>
</head><body><p align="center"> <b><font size="5">Generate the Poll</font></b></p>
  <p>&nbsp;</p>	
<script language  = JavaScript>
function resultswindow()
{
window.open("poll.asp")
}	
</script>


 <% 

	Dim conn,RsUpdate,Rst,RstCheck,CheckSQL,UpSQL,InstSQL,strAns1,strAns2,strAns3,strAns4,strAns5,strAns6 
    Dim strNoofOptions,strPolltitle,datPolldate
	if not (request.Querystring("txtQuestion")) = "" then
		strAns1 = request.Querystring("txtQ1")
		strAns2 = request.Querystring("txtQ2")
		strAns3 = request.Querystring("txtQ3")
		strAns4 = request.Querystring("txtQ4")
		strAns5 = request.Querystring("txtQ5")
		strAns6 = request.Querystring("txtQ6")
		strNoofOptions = request.Querystring("hidOptions")
		strPolltitle = request.querystring("txtQuestion")
		Response.Write "<center>You have successfully created a new poll.<br> "
		Response.write "The title of your Poll is <b> " & strPolltitle & "</b><br>"
		Response.write "Click <b>Test</b> button to take the poll <Br>"
		Response.write "Follow the instructions in README.txt to integrate the Poll to your site. <Br>"
		datPolldate = date
		set conn = server.createobject("ADODB.Connection")
		conn.open "DSN=advteamdsn;UID=;PWD=;"
			UpSQL = "Update stylepoll set fldPollstate = No"
			Set RsUpdate = conn.execute(UpSQL)
			InstSQL = "INSERT INTO stylepoll (fldpollquestion,fldpollstate,fldAns1,fldAns2, " _
			& " fldAns3,fldAns4,fldAns5,fldAns6,fldAns1tot,fldAns2tot,fldAns3tot,fldAns4tot, " _
			& " fldAns5tot,fldAns6tot,fldPolldate,fldNoofanswers) values " _
			& "('" & strPolltitle & "',yes,'" & strAns1 & "','" & strAns2 & "','" & strAns3 & "', " _
			& " '" & strAns4 & "','" & strAns5 & "','" & strAns6 & "',0,0,0,0,0,0, '" & datPolldate & "' ,'" & strNoofOptions & "')"
			set Rst = conn.execute(InstSQL)
			Response.write "The Poll Question and the Answers are added to the database ! <Br>"
			response.write " You can test the Poll and start using it."
			conn.close
			set RstCheck = nothing
			set RsUpdate = nothing
			set rst = nothing
			set conn = nothing
	end if

%> 
<div align="center">
  <p>&nbsp;</p>
  <p><br>
    <input type="submit" name="Submit" value="Test" onClick ="resultswindow()">
  </p>
</div>
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
