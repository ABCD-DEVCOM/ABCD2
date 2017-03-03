<?php
/**
 * Classe que defini os metodos e acoes para gerenciamento dos
 * Fasciculos de uma colecao
 *
 * @author domingos.teruel
 * @package defaultPackage
 */
class facicData {
	var $year = 0;
	var $vol= 0;
	var $num= 0;
	var $mask= "";
	var $type = 0;
	var $status= 0;
	var $qtd= 0;
	var $note= 0;
	var $mfn= 0;
	var $idmfn= 0;
	var $data = array();

/*
					"database" => "1",
					"literatureType" => "5",
					"treatmentLevel" => "6",
					"centerCode" => "10",
					"titleCode" => "30",
					"notes" => "900",
					"codeNameMask" => "910",
					"year" => "911",
					"volume" => "912",
					"issue" => "913",
					"number" => "913",
					"status" => "914",
					"quantity" => "915",
					"publicationType" => "916",
					"inventoryNumber" => "917",
					"eAddress" => "918",
					"sequentialNumber" => "920",
					"textualDesignation" => "925",
					"standardizedDate" => "926",
					"creationDate" => "940",
					"changeDate" => "941",
					"documentalistCreation" => "950",
					"documentalistChange" => "951",
*/

	function getData($name){
		return $this->data[$name];
	}
	function setData($name, $v){
		$this->data[$name] = $v;
	}

	function set_year($y){
		$this->year = $y;
	}
	function set_vol($v){
		$this->vol = $v;
	}
	function set_num($n){
		$this->num = $n;
	}
	function set_mask($m){
		$this->mask = $m;
	}
	function set_type($y){
		$this->type = $y;
	}
	function set_status($v){
		$this->status = $v;
	}
	function set_qtd($n){
		$this->qtd = $n;
	}
	function set_note($m){
		$this->note = $m;
	}
	function set_mfn($m){
		$this->mfn = $m;
	}
	function set_idmfn($m){
		$this->idmfn = $m;
	}

	function get_year(){
		return $this->year ;
	}
	function get_vol(){
		return $this->vol;
	}
	function get_num(){
		return $this->num;
	}
	function get_mask(){
		return $this->mask;
	}
	function get_type(){
		return $this->type ;
	}
	function get_status(){
		return $this->status;
	}
	function get_qtd(){
		return $this->qtd;
	}
	function get_note(){
		return $this->note;
	}
	function get_mfn(){
		return $this->mfn;
	}
	function get_idmfn(){
		return $this->idmfn;
	}
}

