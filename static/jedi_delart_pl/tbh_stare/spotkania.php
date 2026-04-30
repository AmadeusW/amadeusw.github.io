<?

$login="MeusH";
$pass="jedaje";
if(!isset($PHP_AUTH_USER) ||
strcmp($PHP_AUTH_USER,$login)
||
strcmp($PHP_AUTH_PW,$pass)) {
Header("WWW-Authenticate: Basic realm=\"Drogi szefie, podaj u¿ytkownika i has³o a zobaczysz ciekawe informacje\"");
Header("HTTP/1.0 401 Unauthorized");
echo "Brak uprawnien do przegl±dania strony";
exit;
}
?>

<style type="text/css">
body
{
background-color: #000048;
}
body,td,th {
	color: #FFFFFF;
}
a:link {
	color: #FFFFFF;
}
a:visited {
	color: #00CCFF;
}
</style>

<title>Spotkania</title>
<img src="logo.gif" width="300" height="30"><br><br>

<?

$lol = "1";



$file=fopen("spotkania.txt", "r");
$tresc = fread($file, filesize("spotkania.txt"));
fclose($file);


if($_GET['zapisz'] != 1)
{

echo"
$tresc
<br><br>
<form name='form1' method='post' action='spotkania.php?zapisz=1'>
  <p>
    <textarea name='textarea' cols='80' rows='7'>$tresc</textarea>
</p>
  <p>
    <input type='submit' name='Submit' value='Wy&#347;lij'>
</p>
</form>
";

}

else
{

echo"
<h1>Zmiany zostaly zapisane:</h1>
$textarea
";

$file2=fopen("spotkania.txt", "w");
fwrite($file2, $textarea);		
fclose($file2);
}
?>

