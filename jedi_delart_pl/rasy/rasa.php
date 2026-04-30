<?php
$id = uniqid("nazw");

//Naglowek
$adres = 'dane/' . $_GET['nazwa'] . '_info.txt';

if ( file_exists( $adres ) == false )
{
	$tytol = "Błšd: Ta rasa nie istnieje!";
}
else
{
	$handle = fOpen( $adres, 'r' );
	$tytol  = fRead( $handle, fileSize( $adres ) );
	fClose( $handle );
}
//Opis
$adres2 = 'dane/' . $_GET['nazwa'] . '.txt';

if ( file_exists( $adres2 ) == false )
{
	$tresc = "Błšd: Ta rasa nie istnieje!";
}
else
{
	$handle2 = fOpen( $adres2, 'r' );
	$tresc  = fRead( $handle2, fileSize( $adres2 ) );
	fClose( $handle2 );
}
//Metryczka
$adres3 = 'dane/' . $_GET['nazwa'] . '_metryczka.txt';

if ( file_exists( $adres3 ) == false )
{
	$tresc = "Błšd: Ta rasa nie istnieje!";
}
else
{
	$handle3 = fOpen( $adres3, 'r' );
	$metr  = fRead( $handle3, fileSize( $adres3 ) );
	fClose( $handle3 );
}

?>

<html>

<head>
<meta http-equiv="Content-Language" content="pl">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<meta name="author" content="Amadeusz Wieczorek (MeusH),  amadeuszw@wp.pl, jedi@delart.pl, meush@hotmail.com" />
<meta name="Keywords" content="Jedi,Academy,Jedi Academy,Knight,Jedi Knight,Jedu,Iedi,Yedi,Jedaj,Yeday,Game,Mod,Download,File,Free,MeusH,Amadeus,Amadeusz,Wieczorek,Mozart,Lightsaber,Blaster,Ass,Laser,Star,Wars,Star Wars,Gwiezdne,Wojny,Gwiezdne Wojny,Nowa Nadzieja,Vader,Maul,Luke,Han,Solo,Skywalker,Darth,Kody,Cheats,Mods,Downloads,Force,Light,Dark,War, Poradnik, Tutorial, Mapy, Mapki, Maps, Map, Radiant, GTK, GKT, CSG, CGS, bsp, compile, kompiluj, kompilacja" />
<meta name="description" content="Ramka przestawiajšca charakterystykę rasy" />

<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">

<title><?php echo $tytol; ?></title>

</head>

<meta http-equiv="Content-Language" content="pl">
<body text="#FFFFFF" bgcolor="#000048">


<?

echo"
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\" width=\"419\" id=\"AutoNumber1\" height=\"430\" background=\"prawy_dol.gif\">
  <tr>
    <td width=\"14\" background=\"lewy_gora.gif\" height=\"5\">&nbsp;</td>
    <td width=\"32\" background=\"gora_b.gif\" height=\"5\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
    <td width=\"182\" background=\"gora.gif\" height=\"5\"><b>&nbsp;$tytol</b></td>
    <td width=\"181\" background=\"gora.gif\" height=\"5\">&nbsp;</td>
    <td width=\"20\" background=\"prawy_gora.gif\" height=\"5\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"14\" height=\"437\" background=\"lewy.gif\" rowspan=\"2\">&nbsp;</td>
    <td width=\"32\" height=\"437\" bgcolor=\"#000048\" rowspan=\"2\">&nbsp;</td>
    <td width=\"219\" height=\"130\" bgcolor=\"#000048\" align=\"left\" valign=\"top\">
    <br><img border=\"0\" src=http://www.starwars.com/databank/species/$nazwa/img/movie_sm.jpg width=\"174\" height=\"108\"></td>
    <td height=\"130\" bgcolor=\"#000048\" align=\"left\" valign=\"top\">
<br>
$metr
</td>
    <td width=\"20\" height=\"437\" background=\"prawy.gif\" rowspan=\"2\">&nbsp;</td>
  </tr>
  <tr>
    <td width=\"363\" bgcolor=\"#000048\" colspan=\"2\" align=\"left\" valign=\"top\">
    $tresc</td>
  </tr>
  <tr>
    <td width=\"14\" height=\"6\" background=\"lewy_dol.gif\">&nbsp;</td>
    <td width=\"32\" height=\"6\" background=\"dol.gif\">&nbsp;</td>
    <td width=\"363\" height=\"6\" background=\"dol.gif\" colspan=\"2\">&nbsp;</td>
    <td width=\"20\" height=\"6\" background=\"prawy_dol.gif\">&nbsp;</td>
  </tr>
</table>

"; ?>