<?
function query_server($serveradr, $serverport)
{
  require("class.jk2.php");
  require("config.php");
  $servervars2show = array_flip($servervars2show);
  $server=new jk2;
  $status=$server->getServerStatus($serveradr,$serverport,1500);
  ksort($server->m_servervars);
  if ($status)
  {
  ?>
    <table border="0" bgcolor="<?=$table_border_color ?>" cellspacing="1" cellpadding="2" width="<?=$table_width ?>">
     <tr bgcolor="<?=$table_title_background ?>">
       <td width="100%" colspan="3"><font size="<?=$font_titel_size ?>" color="<?=$font_servername_color ?>"><?=v($server->m_servervars["sv_hostname"])?></font><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"> (<?=v($serveradr)?>:<?=v($serverport)?>)</font></td>
     </tr>
     <tr bgcolor="<?=$table_default_background ?>">
       <td width="33%" align="left"><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"><b><?=v($server->m_servervars["sv_currentclients"])?></b> out of <b><?=v($server->m_servervars["sv_maxclients"]-$server->m_servervars["sv_privateClients"]) ?></b> players on map <b><?=v($server->m_servervars["mapname"])?></b><br />
       <?=v(date("n/j/Y g:i:s A", time())) ?></font>
       </td>
       <td width="33%" rowspan="2" valign="top">
       <table border="0" cellpadding="0" cellspacing="0" bgcolor="<?=$table_default_background ?>" width="100%">
         <tr>
           <td align="left"><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"><b><u>Players</u></b></font></td>
           <td width="30" align="center"><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"><b><u>Score</u></b></font></td>
           <td width="30" align="center"><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"><b><u>Ping</u></b></font></td>
         </tr>
       <?
         if (is_array($server->m_playerinfo))
         {
           while (list(,$player) = each($server->m_playerinfo))
           {
           if($player["ping"] == 999 AND $player["frags"] == 0)
             $temp_color = $player_color_joining;
           elseif($player["ping"] >= $lag)
             $temp_color = $player_color_lagging;
           elseif($player["frags"] < 0)
             $temp_color = $player_color_teamkiller;
           else
             $temp_color = $font_default_color;
           ?>
            <tr>
              <td align="left"><font size="<?=$font_default_size ?>" color="<?=$temp_color ?>"><?=v($player["name"])?></font></td>
              <td width="30" align="center"><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"><?=v($player["frags"])?></font></td>
              <td width="30" align="center"><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"><?=v($player["ping"])?></font></td>
            </tr>
           <?
           }
         }
       ?>
       </table>
       </td>
       <td width="33%" rowspan="2" valign="top">
       <table border="0" cellpadding="0" cellspacing="0" bgcolor="<?=$table_default_background ?>" width="100%">
         <tr>
           <td align="left"><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"><b><u>Rule</u></b></font></td>
           <td align="right"><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"><b><u>Setting</u></b></font></td>
         </tr>
       <? while (list($name,$value) = each ($server->m_servervars))
       {
         $show = FALSE;
         if($limitservervars)
         {
           if(isset($servervars2show[strtolower($name)]))
             $show = TRUE;
         }
         else
           $show = TRUE;
         if($show)
          echo '<tr>
             <td align="left"><font size="'.$font_default_size.'" color="'.$font_default_color.'">'.v($name).'</font></td>
             <td align="right"><font size="'.$font_default_size.'" color="'.$font_default_color.'">'.v($value).'</font></td>
           </tr>';
       }
       if($allowad)
          echo '<tr>
             <td align="left"><font size="'.$font_default_size.'" color="'.$font_default_color.'">Jedi&nbsp;Livecast</font></td>
             <td align="right"><a href="http://www.jedi.delart.pl/" target="_blank"><font size="'.$font_default_size.'" color="'.$font_default_color.'">serwis o Jedi Academy</font></a></td>
           </tr>';
       ?>
       </table>
       </td>
     </tr>
     <tr bgcolor="<?=$table_default_background ?>">
       <td width="33%" align="center"><p>&nbsp;</p><img src="<?=$url_levelshots ?><?=v($server->m_servervars["mapname"])?>.jpg" border="0" width="<?=$img_width ?>" height="<?=$img_height ?>"><br /><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"><?=v($server->m_servervars["mapname"])?></font><p>&nbsp;</p></td>
     </tr>
     <tr bgcolor="<?=$table_title_background ?>">
       <td align="left"><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"><?=v($server->m_servervars["version"])?></font></td>
       <td colspan="2" align="right"><font size="<?=$font_default_size ?>" color="<?=$font_default_color ?>"><nobr>Player Color Chart: <font color="<?=$player_color_joining ?>">Joining Server</font> - <font color="<?=$player_color_teamkiller ?>">Teamkiller/Selfkiller</font> - <font color="<?=$player_color_lagging ?>">Lagging</font></nobr></font></td>
     </tr>
    </table>
  <?
  }
  else
    echo $server->errmsg;
}
?>