<?php
$id = uniqid("kole");

//moja funkcja - ¿eby dzia³a³y polskie znaki
function polskie_znaki($tekst)
{

$tekst = str_replace("¹", "a", $tekst);
$tekst = str_replace("œ", "s", $tekst);

/*$tekst = str_replace("¹", "&#261;", $tekst);
$tekst = str_replace("æ", "&#263;", $tekst);
$tekst = str_replace("ê", "&#281;", $tekst);
$tekst = str_replace("³", "&#322;", $tekst);
$tekst = str_replace("ó", "&oacute;", $tekst);
$tekst = str_replace("œ", "&#347;", $tekst);
$tekst = str_replace("Ÿ", "&#378;", $tekst);
$tekst = str_replace("¿", "&#380;", $tekst);

$tekst = str_replace("¥", "&#260;", $tekst);
$tekst = str_replace("Æ", "&#262;", $tekst);
$tekst = str_replace("Ê", "&#280;", $tekst);
$tekst = str_replace("£", "&#321;", $tekst);
$tekst = str_replace("Ó", "&Oacute;", $tekst);
$tekst = str_replace("Œ", "&#346;", $tekst);
$tekst = str_replace("", "&#377;", $tekst);
$tekst = str_replace("¯", "&#379;", $tekst);
*/
return $tekst;

}

//Info
$kto = $_GET['koles'] . '.txt';

if ( file_exists( $kto ) == false )
{
	$tytol = "B³¹d: Ten koleœ nie istnieje!";
}
else
{
	$handle = fOpen( $kto, 'r' );
	$plik  = fRead( $handle, fileSize( $kto ) );
	fClose( $handle );

	$plik = polskie_znaki($plik);
	$linika = explode ("*", $plik);
}

/*Rangi
	$handle2 = fOpen( 'rangi.txt', 'r' );
	$rangi  = fRead( $handle2, fileSize( 'rangi.txt' ) );
	fClose( $handle2 );
	$linikar = explode ("!", $rangi);
*/


$nick = $linika[0];
//$numer = $linika[1];
//$ranga = $linikar[$numer]; 
$ranga = $linika[1];
$wiek = $linika[2];
$bronie = $linika[3];
$skin = $linika[4];
$gg = $linika[5]; 
$strona = $linika[6];
$czemu = $linika[7];
$nagrody = $linika[8];

?>

<html>

<head>
<meta http-equiv="Content-Language" content="pl">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<meta name="author" content="Amadeusz Wieczorek (MeusH),  amadeuszw@wp.pl, jedi@delart.pl, meush@hotmail.com" />
<meta name="Keywords" content="Jedi,Academy,Jedi Academy,Knight,Jedi Knight,Jedu,Iedi,Yedi,Jedaj,Yeday,Game,Mod,Download,File,Free,MeusH,Amadeus,Amadeusz,Wieczorek,Mozart,Lightsaber,Blaster,Ass,Laser,Star,Wars,Star Wars,Gwiezdne,Wojny,Gwiezdne Wojny,Nowa Nadzieja,Vader,Maul,Luke,Han,Solo,Skywalker,Darth,Kody,Cheats,Mods,Downloads,Force,Light,Dark,War, Poradnik, Tutorial, Mapy, Mapki, Maps, Map, Radiant, GTK, GKT, CSG, CGS, bsp, compile, kompiluj, kompilacja" />
<meta name="description" content="Ramka przestawiaj¹ca dobrego gracza" />

<meta http-equiv="Content-Type" content="text/html; charset=windows-1250">

<title><?php echo "$ranga $nick"; ?></title>

</head>

<meta http-equiv="Content-Language" content="pl">
<body text="#FFFFFF" bgcolor="#000048">


<?

print"
<p><img src='logo.gif' width='300' height='30'></p>
<table width='325' border='0'cellpadding='0' cellspacing='0'>
  <tr>
    <td width='126'><img src='linia1.gif' width='126' height='3'></td>
    <td width='183'><img src='linia2.gif' width='183' height='3'></td>
  </tr>
  <tr>
    <td width='126'>Nick</td>
    <td width='183'>$nick</td>
  </tr>
  <tr>
    <td width='126'><img src='linia1.gif' width='126' height='3'></td>
    <td width='183'><img src='linia2.gif' width='183' height='3'></td>
  </tr>
  <tr>
    <td>Ranga</td>
    <td>$ranga</td>
  </tr>
    <tr>
    <td width='126'><img src='linia1.gif' width='126' height='3'></td>
    <td width='183'><img src='linia2.gif' width='183' height='3'></td>
  </tr>
  <tr>
    <td>Wiek</td>
    <td>$wiek</td>
  </tr>
    <tr>
    <td width='126'><img src='linia1.gif' width='126' height='3'></td>
    <td width='183'><img src='linia2.gif' width='183' height='3'></td>
  </tr>
  <tr>
    <td>GG</td>
    <td>$gg</td>
  </tr>
    <tr>
    <td width='126'><img src='linia1.gif' width='126' height='3'></td>
    <td width='183'><img src='linia2.gif' width='183' height='3'></td>
  </tr>
  <tr>
    <td>Ulubiona bro&#324;</td>
    <td>$bronie</td>
  </tr>
    <tr>
    <td width='126'><img src='linia1.gif' width='126' height='3'></td>
    <td width='183'><img src='linia2.gif' width='183' height='3'></td>
  </tr>
  <tr>
    <td>Ulubiony skin </td>
    <td>$skin</td>
  </tr>
    <tr>
    <td width='126'><img src='linia1.gif' width='126' height='3'></td>
    <td width='183'><img src='linia2.gif' width='183' height='3'></td>
  </tr>
  <tr>
    <td>Strona mocy </td>
    <td>$strona</td>
  </tr>
    <tr>
    <td width='126'><img src='linia1.gif' width='126' height='3'></td>
    <td width='183'><img src='linia2.gif' width='183' height='3'></td>
  </tr>
  <tr>
    <td height='64'>Dlaczego w TBH</td>
    <td>$czemu</td>
  </tr>
    <tr>
    <td width='126'><img src='linia1.gif' width='126' height='3'></td>
    <td width='183'><img src='linia2.gif' width='183' height='3'></td>
  </tr>
</table>

"; ?>