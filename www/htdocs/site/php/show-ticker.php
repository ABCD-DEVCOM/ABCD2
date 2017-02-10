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

    // caso seja RSS do componente REDES adiciona o parametro bvs para navega��o no site
    preg_match("/count=([0-9])/",$url, $matches);
    if ($matches[1] != ''){
        $rssCount = $matches[1];
    }

    $rss = fetch_rss( $url );
    if ($rss == false){
        echo "rss error: " . $MAGPIE_ERROR;
    }else{
        $channel = $rss->channel['title'];

        echo "<ul>";

        $i = count($rss->items);
        $rssCount = $rssCount > 0? min(array( $i, $rssCount)) : $i;

        for($i=0; $i < $rssCount; $i++) {
            $href = htmlentities($rss->items[$i]['link']);
            $title = $rss->items[$i]['title'];

            print '<li>';
            if( $rss->items[$i]['enclosure'] ){
                $imgTitle = htmlentities($rss->items[$i]['title']);
                print "<a href=\"{$rss->items[$i]['link']}\">";
                print "<img title=\"{$imgTitle}\" alt=\"{$imgTitle}\" src=\"{$rss->items[$i]['enclosure']['url']}\" />";
                print "</a>";
            }
            print <<< RSS
                    <h4>{$rss->items[$i]['category'][0]}</h4>
                    <h3><a href="{$rss->items[$i]['link']}">{$rss->items[$i]['title']}</a></h3>
                    <span class="description">
                        {$rss->items[$i]['description']}
                    </span>
                </li>
RSS;

        }
        echo "</ul>";

    }
}
?>
