<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include("../common/get_post.php");
#foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
//Prepara los datos para envío  al presentador en flash

include ("chart_library/charts.php");

$data=$_SESSION['matriz'];
$tipo=trim($arrHttp['tipo']); //tipo de gráfico
if ($tipo=="") {
    $tipo="column";
}

$chart=array();
$height="250";
$width="650";
$xleft=40;          //margen desde el margen izquierdo de recuadro hasta el márgen de inicio del gráfico
$ytop=60;           //margen desde el márgen superior del  recuadro hasta el márgen de inicio del gráfico
$xlegend=40;
$ylegend=30;
$chart_transition="slide_up";
$delay=1;
$cols=0;

$chart[ 'series_color' ] = array ("aa0000","FFFFC0",
								  "8C63C3","ff8800" ,
								  "00FF00","225522",
								  "F8C768","008080",
								  "aa00C0","ffaaee",
								  "44ffff","0000ff",
								  "5F0000","ee9a00",
								  "F8FB05","69B54F",
								  "F09E88","AAFAF7",
								  "ee0000", "A8FB05",
								  "5C5FE2","ff6600",
								  "69B54F","ff0000",
								  "5F0000","ee0000",
								  "3e454a","05fbfa" );

for ($i=0;$i<30;$i++){    $j=$i+1;	mt_srand((double)microtime()* 100000);
    $c = '';
    while(strlen($c)<6){
        $c .= sprintf("%02X", mt_rand(0, 255));
    }
    foreach ($chart["series_color"] as $value){    	if (abs($c-$value)<10){    		$c="";
    		$i=$i-1;
    		break;    	}    }    if ($c!="") $chart[ 'series_color' ][] =$c;
}
$order="series";
$duration=0.5;
$orientation="diagonal_up";
switch ($tipo) {
    case "pie":
		$xlegend=40;
		$ylegend=20;
		$height=220;
		$delay=1;
		$duration=0.5;
		$chart_transition="spin";
		$order="category";
        break;
    case "3d pie":
		$xlegend=50;
		$ylegend=20;
		$height=150;
		$delay=1;
		$duration=0.5;
		$chart_transition="spin";
		$order="category";
        break;
    case "bar":
		$width=500;
		$xleft=100;
		$height=210;
	case "stacked bar":
        $chart_transition="slide_right";
		$width=500;
		$xleft=100;
		$height=210;
		$orientation="vertical";
        break;

	case "column":
		$height=200;
		$ytop=60;
        $chart_transition="slide_up";
		$delay=1;
		$duration=0.5;
		$order="series";
		$orientation="horizontal";
        break;
	case "stacked column":
		$height=200;
        $chart_transition="slide_up";
		$delay=1;
		$duration=0.5;
		$order="series";
		$orientation="horizontal";
        break;
	case "3d column":
		$ytop=55;
		$height=220;
        $chart_transition="slide_up";
		$delay=1;
		$duration=0.5;
		$order="series";
        break;
	case "parallel 3d column":
   		$ytop=43;
		$height=230;
        $chart_transition="slide_down";
		$delay=1;
		$duration=0.5;
		$order="series";
        break;
	case "stacked 3d column":
   		$ytop=48;
		$height=225;
        $chart_transition="slide_up";
		$delay=1;
		$duration=0.5;
		$order="series";
		$orientation="diagonal";
        break;

	case "area":
        $ytop=60;
		$height=200;
        $chart_transition="slide_down";
		$delay=1;
		$duration=0.5;
		$order="series";
//		$chart[ 'series_color' ] = array ( "8C63C3", "69B54F","F09E88","0AFAF7","ee0000", "F8FB05","5C5FE2" );
		$orientation="horizontal";
        break;


        $ytop=60;
	case "stacked area":
		$height=200;
        $chart_transition="slide_down";
		$delay=1;
		$duration=0.5;
		$order="series";
		$orientation="horizontal";
        break;
	case "line":
        $ytop=60;
		$height=200;
        $chart_transition="drop";
		$delay=1;
		$duration=0.5;
		$order="series";
        break;
}
$mat=explode('###',$data);
if (strpos($tipo,"pie")===false) {
	$rows=-1;
	foreach ($mat as $linea){

    	$filas=explode('|',$linea);
		$rows++;
		$cols=-1;
		foreach ($filas as $celda){
			$celda=trim($celda);
			$cols++;
			if ($rows==0 or $cols==0) {
				$celda=trim($celda);
				// Hay que eliminar los caracteres acentuados porque de otra forma el graficador da error
				$search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
				$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");
				$celda = str_replace($search, $replace, $celda);
			   	if ($rows==0) {
			       	$chart [ 'chart_data' ][$rows][$cols]=substr($celda,0,10);  //."\n".substr($celda,10,10);
			   	} else{
			   		$chart [ 'chart_data' ][$rows][$cols]=$celda;
			   	}
			}else{
				$chart [ 'chart_data' ][$rows][$cols]=intval($celda);
			}
		}
	}

}else{

	$rows=-1;
	$chart [ 'chart_data' ][0][0]=" ";
	$chart [ 'chart_data' ][1][0]=" ";
	foreach($mat as $linea){

		$rows++;
		$filas=explode('|',$linea);
		// Hay que eliminar los caracteres acentuados porque de otra forma el graficador da error
		$search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
		$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");
		$filas[0]= str_replace($search, $replace, $filas[0]);
		$chart [ 'chart_data' ][0][$rows]=trim($filas[0]);
		$chart [ 'chart_data' ][1][$rows]=intval($filas[1]);
	}
}



$chart[ 'chart_type' ] = $tipo;
 if ($rows>8 or $cols>8) {
     $delay=0;
	 $duration=0.5;
	 $ylegend=0;
	 $order="category";
	$chart_transition="drop";
	 $orientation="horizontal";
 }

$chart[ 'axis_category' ] = array ( 'font'=>"Arial",
									'bold'=>true,
									'size'=>10,
									'color'=>"000022",
									'alpha'=>50,
									'skip'=>0 ,
									'orientation'=>$orientation);
$chart[ 'axis_ticks' ] = array ( 	'value_ticks'=>false,
									'category_ticks'=>true,
									'major_thickness'=>0,
									'minor_thickness'=>0,
									'minor_count'=>3,
									'major_color'=>"000000", 'minor_color'=>"888888" ,'position'=>"outside" );

$chart[ 'axis_value' ] = array ( 	'font'=>"Arial",
									'bold'=>true,
									'size'=>8,
									'color'=>"000022",
									'alpha'=>50, 'steps'=>3,
									'prefix'=>"",
									'suffix'=>"",
									'decimals'=>0,
									'separator'=>"",
									'show_min'=>true ,
									'orientation'=>"horizontal");


$chart[ 'chart_border' ] = array ( 	'color'=>"000000",
									'top_thickness'=>0,
									'bottom_thickness'=>0,
									'left_thickness'=>3,
									'right_thickness'=>0 );
$chart[ 'chart_grid_h' ] = array ( 'alpha'=>10, 'color'=>"000000", 'thickness'=>5 );
$chart[ 'chart_grid_v' ] = array ( 'alpha'=>10, 'color'=>"000000", 'thickness'=>1 );
$chart[ 'chart_rect' ] = array (	'x'=>$xleft,
									'y'=>$ytop,
									'width'=>$width,
									'height'=>$height,
									'positive_color'=>"00ff00",
									'negative_color'=>"ff0000",
									'positive_alpha'=> 20,
									'negative_alpha'=>20 );

$chart[ 'chart_transition' ] = array ( 'type'=> $chart_transition,
										'delay'=>$delay, 'duration'=>$duration,
										'order'=>$order );

/*
$chart[ 'draw' ] = array ( array ( 'transition'=>"slide_up",
									'delay'=>0,
									'duration'=>1,
									'type'=>"text",
									'color'=>"000033",
									'alpha'=>15,
									'font'=>"Arial",
									'rotation'=>0,
									'bold'=>true,
									'size'=>30, 'x'=>20,
									'y'=>6, 'width'=>400,
									'height'=>100,
									'text'=>"imprimir",
									'h_align'=>"right",
									'v_align'=>"bottom" ),
                           			array ( 'transition'=>"dissolve",
						   					'delay'=>1.5,
											'duration'=>.5,
											'type'=>"text",
											'color'=>"ffffff",
											'alpha'=>15,
											'font'=>"Arial",
											'rotation'=>-5,
											'bold'=>true,
											'size'=>150,
											'x'=>110,
											'y'=>40,
											'width'=>400,
											'height'=>600,
											'text'=>"  ",
											'h_align'=>"left",
											'v_align'=>"bottom"
									)
								);

$chart[ 'draw' ] = array ( array ( 'type'=>"image", 'transition'=>"dissolve", 'delay'=>1, 'duration'=>.6, 'url'=>"http://localhost/unimet-dda/admin/img/autoridades.gif", 'x'=>300, 'y'=>250, 'width'=>70, 'height'=>25 ) );
*/

$chart[ 'legend_label' ] = array ( 	'layout'=>"horizontal",
									'bullet'=>"circle",
									'font'=>"Arial",
									'bold'=>true,
									'size'=>10,
									'color'=>"000022",
									'alpha'=>50 );
$chart[ 'legend_rect' ] = array ( 	'x'=>$xlegend,
									'y'=>$ylegend,
									'width'=>600,
									'height'=>5,
									'margin'=>0,
									'fill_color'=>"000066",
									'fill_alpha'=>0,
									'line_color'=>"000000",
									'line_alpha'=>0,
									'line_thickness'=>0 );
$chart[ 'legend_transition' ] = array ( 'type'=>"dissolve", 'delay'=>1.5, 'duration'=>.5 );


$chart [ 'chart_value' ] = array (  'prefix'         =>  "",
                                    'suffix'         =>  "",
                                    'decimals'       =>  0,
                                    'decimal_char'   =>  "",
                                    'separator'      =>  "",
                                    'position'       =>  "cursor",
                                    'hide_zero'      =>  true,
                                    'as_percentage'  =>  false,
                                    'font'           =>  "Arial",
                                    'bold'           =>  true,
                                    'size'           =>  16,
                                    'color'          =>  "000022",
                                    'alpha'          =>  100
                                 );
SendChartData($chart);
?>