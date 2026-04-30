<?
class jk2 {
        var $m_playerinfo                ="";
        var $m_servervars                ="";
        function timenow() {
                return doubleval(ereg_replace('^0\.([0-9]*) ([0-9]*)$','\\2.\\1',microtime()));
        }
        function removefunchars($data) {
                $result="";
                $skipnextchar=false;
                for ($i=0;$i<strlen($data);$i++) {
                        if (!$skipnextchar) {
                                $currentchar=ord(substr($data,$i,1));
                                if (($currentchar==27) || ($currentchar==94)) {
                                        $skipnextchar=true;
                                } else {
                                        if (($currentchar>=32) && ($currentchar<=127)) $result=$result.chr($currentchar);
                                        if (($currentchar>=160) && ($currentchar<=255)) $result=$result.chr($currentchar-128);
                                }
                        } else {
                                $skipnextchar=false;
                        }
                }
                return $result;
        }
        function getServerData($command,$serveraddress,$portnumber,$waittime) {
                $serverdata                ="";
                $serverdatalen=0;

                if ($waittime< 500) $waittime= 500;
                if ($waittime>2000) $waittime=2000;
                $waittime=doubleval($waittime/1000.0);

                if (!$jk2socket=fsockopen("udp://".$serveraddress,$portnumber,$errnr)) {
                        $this->errmsg="Brak po³¹czenia";
                        return "";
                }
                socket_set_blocking($jk2socket,true);
                socket_set_timeout($jk2socket,0,500000);
                fwrite($jk2socket,$command,strlen($command));
                $starttime=$this->timenow();
                do {
                        $serverdata.=fgetc($jk2socket);
                        $serverdatalen++;
                        $socketstatus=socket_get_status($jk2socket);
                        if ($this->timenow()>($starttime+$waittime)) {
                                $this->errmsg="Connection timed out";
                                fclose($jk2socket);
                                return "";
                        }
                } while ($socketstatus["unread_bytes"] );
                fclose($jk2socket);
                return $serverdata;
        }
        function getServerStatus($serveraddress,$portnumber,$timeout) {

                $cmd="\xFF\xFF\xFF\xFFgetstatus\n";
                $serverdata=$this->getServerData($cmd,$serveraddress,$portnumber,$timeout);
                if (strlen($serverdata)>20) {
                        $serverdata=substr($serverdata,20);
                } else {
                        return false;
                }

                $srvvars=substr($serverdata,0,strpos($serverdata,"\n"))."\\";
                $players=substr($serverdata,strpos($serverdata,"\n")+1);
                $players=substr($players,0,strlen($players)-1);
                $playercount=0;
                if (strlen($players)) {
                        $playercollection=explode("\n",$players);
                        while (list($key,$data) = each ($playercollection)) {
                                eregi("^([-0-9]+) ([-0-9]+) \"(.*)\"",$data,$player);
                                $this->m_playerinfo[$key]=array("frags"=>$player[1],"ping"=>$player[2],"name"=>$this->removefunchars($player[3]));
                                $playercount++;
                        }
                }
                $this->m_servervars["sv_currentclients"]=$playercount;
                if ($playercount>0) usort($this->m_playerinfo,"fragsort");
                $name_tok = strtok ($srvvars,"\\");
                $val_tok  = strtok ("\\");
                while (strlen($name_tok)) {
                        $this->m_servervars[$name_tok]=$val_tok;
                        $name_tok = strtok ("\\");
                        $val_tok  = strtok ("\\");
                }
                return true;
        }
}

function fragsort ($a, $b) {
        if ($a["frags"] == $b["frags"]) return 0;
        if ($a["frags"] > $b["frags"]) {
                return -1;
        } else {
                return 1;
        }
}
function v($string)
{
 return htmlentities($string);
}
?>