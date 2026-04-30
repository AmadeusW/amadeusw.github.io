<?
//////////////////////////////////////////
//////////////////////////////////////////
//// JediLive PHP Clone - config file ////
//////////////////////////////////////////
//////////////////////////////////////////

ini_alter("display_errors", '0');
// set to 1 for debugging

$allowad = TRUE;
// set to TRUE to allow a link to http://www.jedi.delart.pl to be displayed - else set to FALSE

$url_levelshots = 'http://members.lycos.co.uk/jediforum/screeny';
/* URL to your directory containing the levelshots.
I didn't include them! You can either download them from http://www.party-planer.ch/creative/images/levelshots/ , extract them yourself from your .pk3 files or keep http://www.party-planer.ch/creative/images/levelshots/ as your path (may won't work forever)
The levelshots must be named <mapname>.jpg
*/

$table_border_color = '#666666';
// the color of the table's border

$table_title_background = '#222222';
// background color of the title

$table_default_background = '#000000';
// table's background color

$table_width = '896';
// the table's width

$font_default_color = '#EEEEEE';
// the default font color

$font_default_size = '1';
// the default font size

$font_titel_size = '2';
// the default font size for the title containing the servername

$font_servername_color = 'yellow';
// the color the servername will appear

$player_color_joining = #222222;
// color for players currently joining

$player_color_teamkiller = 'yellow';
// color for players having less then 0 frags

$player_color_lagging = 'red';
// color for players having a ping higher then $lag

$lag = 350;
// pings higher this value will be counted as lag

$img_width = '200';
$img_height = '180';
// width and height the levelshots will use

$limitservervars = TRUE;
// set to TRUE to only display servervars defined by $servervars2show.

// if $limitservervars is set to TRUE only this servervars will be displayed - do NOT use capital letters!
$servervars2show = array(
   'timelimit',
   'gamename',
   'g_gametype',
   'capturelimit',
   'sv_allowanonymous',
   'sv_floodprotect',
   'sv_maxping',
   'sv_minping',
   'sv_maxrate',
   'sv_privateclients',
   'g_privateduel',
   'g_password',
   'protocol',
   'g_saberlocking',
   'g_forcebasedteams',
   'g_forcepowerdisable',
   'g_forceregentime',
   'g_maxforcerank',
   'g_needpass'
);
?>