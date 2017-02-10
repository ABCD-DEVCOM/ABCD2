<?php
$current=dirname(__FILE__).'/';
include_once($current . "./include.php");

$reload = $_REQUEST["reload"];
$expire = 3600*6;         //cache expire time
$rssCount = 0;

if ($reload == "rss")    //flag to force reload of all RSS
    $expire = -1;

define('MAGPIE_DIR', $current. 'rss/');
define('MAGPIE_CACHE_DIR', $def['DATABASE_PATH'] . "rss/");
define('MAGPIE_CACHE_AGE', $expire); // set cache timeout

require_once(MAGPIE_DIR.'rss_fetch.inc');

if ( $url ) {

    $url = str_replace("%HTTP_HOST%", $_SERVER["HTTP_HOST"], $url );

    // caso seja RSS do componente REDES adiciona o parametro bvs para navegacao no site
    if ( preg_match("/\/bvsnet\/rss/i", $url ) ){
        if ( strpos($url,"?") === false ){
            $url .= "?";
        }
        $url .= "&bvs=" . $def["SERVERNAME"];
    }

    preg_match("/count=([0-9])/",$url, $matches);
    if ($matches[1] != ''){
        $rssCount = $matches[1];
    }

    $rss = fetch_rss( $url );
    if ($rss == false){
        echo "rss error: " . $MAGPIE_ERROR;
    }else{
        $channel = $rss->channel['title'];
        if ($channel == 'BVS Network'){
            /* lista de bandeira dos paises */
            echo $rss->items[0]['description'];
        }else{
            if (preg_match('/^Newsletter/i',$channel)){
                /*
                    $channel = "Ed. " . eregi_replace('Newsletter|VHL|BVS',"",$channel);
                */
                $channel = "";
                $rss->channel['link'] = "";
                /* logo j� deve estar definido como titulo do componente no bvs-site */
                $rss->image = null;
            }
            if ($rss->image['url'] != ''){
                echo "<a href=\"" . htmlentities($rss->image['link'])  . "\" target=\"news\">" .
                        "<img src=\"" . $rss->image['url'] . "\" class=\"logo\" alt=\"logo\"/>" .
                     "</a><br/>";
            }

            if ($rss->channel['link'] != ''){
                echo "<a href=\"" . htmlentities($rss->channel['link'])  . "\" target=\"news\">" .
                        "<span class=\"channel\">" . $channel . "</span></a>";
            }
            echo "<ul>";

            $i = count($rss->items);
            $rssCount = $rssCount > 0? min(array( $i, $rssCount)) : $i;

            for($i=0; $i < $rssCount; $i++) {
                $href = htmlentities($rss->items[$i]['link']);
                $title = $rss->items[$i]['title'];
                echo "<li><a href=\"$href\" target=\"_blank\">$title</a></li>";
            }
            echo "</ul>";
        }
    }
}
?>
