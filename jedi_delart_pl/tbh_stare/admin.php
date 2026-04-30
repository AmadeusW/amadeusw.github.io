<?
$login="MeusH";
$pass="jedaje";
if(!isset($PHP_AUTH_USER) ||
strcmp($PHP_AUTH_USER,$login)
||
strcmp($PHP_AUTH_PW,$pass)) {
Header("WWW-Authenticate: Basic realm=\"MeusH\"");
Header("HTTP/1.0 401 Unauthorized");
echo "Brak uprawnien do przegl±dania strony";
exit;
}

/*
akcja:
0-wybór plików
1-pokaz
2-edycja
3-zapisz i pokaz
*/

if ($_GET['akcja'] == "0")
{
echo'

<h1>Panel Administracyjny</h1>
<form name="form1" method="post" action="admin.php?akcja=1">
  <p>Nazwa pliku 
    <input name="nazwa" type="text" id="nazwa" size="30">
  </p>
  <p> 
    <input name="Zmien" type="submit" id="Zmien" value="Zmien lub Utw&oacute;rz">
</p>
</form>
';

}

else if ($_GET['akcja'] == "1")
{

if (file_exists($nazwa))
{
$op0=fopen($nazwa, "r+");
$tresc0=fread($op0, filesize($nazwa));
fclose($op0);

echo'
<h1>Zawartosc pliku $nazwa</h1>
<br>
<br>
$tresc0
';
}
else
{
$op0=fopen($nazwa, "w+");

echo'
<h1>Plik $nazwa zostal utworzony</h1>
<br>
<br>
$tresc0
';
}


echo'
<br>
<br>
<table width="200" border="0">
  <tr>
    <td>
	<form name="form1" method="post" action="admin.php?akcja=2"> 
    <input type="submit" name="Submit" value="Zmien">
	</form>
</td>
    <td>
	<form name="form2" method="post" action="admin.php?akcja=0"> 
    <input type="submit" name="Submit" value="Menu">
	</form>
	</td>
  </tr>
</table>
';
}

else if ($_GET['akcja'] == "2")
{

$op=fopen($nazwa, "r+");
$tresc=fread($op, filesize($nazwa));
fclose($op);

echo'

<form name="form1" method="post" action="admin.php?akcja=3"> 
  <h1>Edycja pliku $nazwa</h1>
  <p>
    <textarea name="nowa_tresc" cols="120" rows="20">$tresc</textarea>
  </p>
  <p align="center">
    <input type="submit" name="Submit" value="Wy&#347;lij">
</p>
</form>

';
}

else if ($_GET['akcja'] == "3")
{

$op1=fopen($nazwa, "r+");
fwrite($op1, $nowa_tresc);
fclose($op1); 

echo'
<h1>Zmiany zosta³y zapisane!<br>Nowa zawartooæ pliku $nazwa</h1>
<br>
<br>
$nowa_tresc
<br>
<br>
<table width="200" border="0">
  <tr>
    <td>
	<form name="form1" method="post" action="admin.php?akcja=2"> 
    <input type="submit" name="Submit" value="Zmien">
	</form>
</td>
    <td>
	<form name="form2" method="post" action="admin.php?akcja=0"> 
    <input type="submit" name="Submit" value="Menu">
	</form>
	</td>
  </tr>
</table>
';
}

?>


</body>
</html>
