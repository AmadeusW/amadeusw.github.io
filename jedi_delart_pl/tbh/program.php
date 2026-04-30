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

<title>program</title>
<img src="logo.gif" width="300" height="30"><br><br>

<?




$file=fopen("program1.txt", "r");
$tresc = fread($file, filesize("program1.txt"));
fclose($file);
$file0=fopen("program0.txt", "r");
$tresc0 = fread($file0, filesize("program0.txt"));
fclose($file0);
$fileV=fopen("program_wersja.txt", "r");
$ver = fread($fileV, filesize("program_wersja.txt"));
fclose($fileV);


if($_GET['zapisz'] != 1)
{

echo"
$tresc
<br><br><br>
$tresc0
<br><br>
<br><br>
<form name='form1' method='post' action='program.php?zapisz=1'>
  <p>Nadchodz¹ce spotkanie:<br>
    <textarea name='textarea' cols='80' rows='7'>$tresc</textarea>
</p>
  <p>Ostatnie spotkanie:<br>
    <textarea name='textarea0' cols='80' rows='7'>$tresc0</textarea>
  </p>
  <p>
    Wersja programu:<br>
    <input name='wersja' type='text' id='wersja' value='$ver' size='10'>
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
<br><br>
$textarea0
";

$file2=fopen("program1.txt", "w");
fwrite($file2, $textarea);		
fclose($file2);
$file20=fopen("program0.txt", "w");
fwrite($file20, $textarea0);		
fclose($file20);
$fileV2=fopen("program_wersja.txt", "w");
fwrite($fileV2, $wersja);		
fclose($fileV2);
}
?>


