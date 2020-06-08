<?php
$current=dirname(__FILE__).'/';
include_once($current . "./include.php");

$reload = $_REQUEST["reload"];
$expire = 3600*6;         //cache expire time

if ($reload == "rss")    //flag to force reload of all RSS
    $expire = -1;

define('MAGPIE_DIR', $current. 'rss/');
define('MAGPIE_CACHE_DIR', $def['DATABASE_PATH'] . "rss/");
define('MAGPIE_CACHE_AGE', $expire); // set cache timeout

require_once(MAGPIE_DIR.'rss_fetch.inc');

if ( $url ) {

    $url = str_replace("%HTTP_HOST%", $_SERVER["HTTP_HOST"], $url );

    $rss = fetch_rss( $url );
    if ($rss == false){
        echo "rss error: " . $MAGPIE_ERROR;
    }else{
        $channel = $rss->channel['title'];

            print <<< RSS
            <p class="channel">{$rss->items[0]['category'][0]}</p>
            <p class="title">
                <a href="{$rss->items[0]['link']}">{$rss->items[0]['title']}</a>
            </p>
RSS;
        $description = $rss->items[0]['description'];

        if( strlen($description) > 150 ){
                $description = substr($description,0,150) . "...";
        }
        print "<p class=\"description\">".$description."</p>";

    }
}
?>
