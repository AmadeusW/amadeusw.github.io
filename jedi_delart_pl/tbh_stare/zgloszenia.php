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

<title>Zg³oszenia do klanu</title>
<img src="logo.gif" width="300" height="30"><br>

<!-- TU SIÊ ZACZYNAJ¥ DANE ZIOMKÓW - MO¯NA KASOWAÆ
-->


