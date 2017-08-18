<?php

class futureIssues{
    var $_debug = 0;
	function __construct()
		{
			
		}
		
	function getNextSeqNumber($lastSeqNumber){
		if (strlen($lastSeqNumber)==0)  $lastSeqNumber = 0;
		return $lastSeqNumber + 100;
	}

    function findCurrentIssueIndex($vol, $num, $yearIssueInfo){
        $i=0;
        $found = -1;
        if ($this->_debug) {
            echo "findCurrentIssue\n";
            var_dump($vol);
            var_dump($num);
            var_dump($yearIssueInfo);
        }
        while (($i<count($yearIssueInfo['vol'])) && ($found==-1)){
            if (trim($yearIssueInfo['vol'][$i]) == trim($vol)){
                if (trim($yearIssueInfo['num'][$i]) == trim($num)){
                    $found = $i;
                } else {


                }
            }
            $i++;
        }
        if ($this->_debug) {
            echo "found\n";
            var_dump($found);
        }
        return $found;
    }

    function findFistYearInfo($vol, $num, $maskSample){
        if ($this->_debug) echo "findFistYearInfo\n";
        $qIssuePerYear = count($maskSample['vol']);
        $qVolPerYear = $maskSample['vol'][$qIssuePerYear-1];
        $qNumPerVol = $qIssuePerYear / $qVolPerYear;
//var_dump($qIssuePerYear);
//var_dump($qVolPerYear);
//var_dump($qNumPerVol);

        $r = $maskSample;

        if ($maskSample['volSeq']=='0'){
            // infinite
            if ($vol > 1){

//echo $vol ."\n";
//echo $qVolPerYear ."\n";
//echo $volGrp ."\n";

                $volGrp = $vol % $qVolPerYear;
                if ($volGrp == 0) {
                    $volGrp = $qVolPerYear;
                }
                $j=0;
                for ($k=0;$k<$qVolPerYear;$k++){
                    for ($i=0;$i<$qNumPerVol;$i++){
                        $r['vol'][$j] = $vol + $maskSample['vol'][$j] - $volGrp;
                        $j++;
                    }                    
                }
            }
        }
        if ($this->_debug){
            echo "rvol\n";
            var_dump($r);
        }
        if ($maskSample['numSeq']=='0'){
            // infinite
            if ($num > $qIssuePerYear) {
                $qYear = ($num / $qIssuePerYear) + 1;
            } else {
                $qYear = 1;
            }


            $lastNumberOfPrevYear  = ($qYear-1) * $maskSample['num'][$qIssuePerYear-1];
            if ($this->_debug){
                echo "lastNumberOfPrevYear - qYear\n";
                var_dump($qYear);
                echo "lastNumberOfPrevYear - lastNumberOfPrevYear\n";
                var_dump($lastNumberOfPrevYear);
            }
            for ($i=0;$i<$qIssuePerYear;$i++){
                $r['num'][$i] = $maskSample['num'][$i] + $lastNumberOfPrevYear;
            }
        }
        if ($this->_debug) {
            echo "found year\n";
            var_dump($r);
        }
        //var_dump($r);
        return $r;
    }

    function generateFutureIssues($maskSample, $issueIndex, $yearInfo, $year, $vol, $num, $lastSeqNumber, $maskID){
        if ($this->_debug) echo "generateFutureIssues\n";
        $qIssuePerYear = count($maskSample['vol']);
        $qVolPerYear = $maskSample['vol'][$qIssuePerYear];
        $qNumPerVol = $qIssuePerYear / $qVolPerYear;
        $currYear = date("Y");
        $index =  $issueIndex;
        if ($lastSeqNumber != '0') {
            /* o titulo ja possui issues */
                $index = $issueIndex + 1;
        }
        $v = $vol;
        $n = $num;

        if ($this->_debug) {
            echo "qIssuePerYear:"; var_dump($qIssuePerYear);
            echo "qVolPerYear:"; var_dump($qVolPerYear);
            echo "qNumPerYear:"; var_dump($qNumPerYear);
            echo "lastSeqNumber: ";var_dump($lastSeqNumber);
            echo "index:";var_dump($index);
            echo "v:";var_dump($v);
            echo "n:";var_dump($n);
            echo "maskSample:";var_dump($maskSample);
            echo "yearInfo:";var_dump($yearInfo);
        }

        if ($maskSample['volSeq']== '1'){            
            $prevIssueLastVol = ''; // vol - finite
        } else {
            $prevIssueLastVol = $yearInfo['vol'][0]-1;
        }
        if ($maskSample['numSeq']== '1'){         
            $prevIssueLastNum = '';   // num - finite
        } else {
            $prevIssueLastNum = $yearInfo['num'][0]-1;
        }
        if ($this->_debug) {
            echo "prevIssueLastVol:"; var_dump($prevIssueLastVol);
            echo "prevIssueLastNum:"; var_dump($prevIssueLastNum);
        }

        for ($y=$year;$y<=$currYear;$y++){
            for ($i=$index;$i<$qIssuePerYear;$i++){

                if ($maskSample['vol'][$i]==" "  || $prevIssueLastVol == ''){
                    $v = $maskSample['vol'][$i];
                } else {
                    $v = $maskSample['vol'][$i] + $prevIssueLastVol;
                }
                if ($maskSample['num'][$i]==" "){
                    $n = $maskSample['num'][$i] ;
                } else {
                    if ($prevIssueLastNum == ''){
                        $n = $maskSample['num'][$i] ;
                    } else {
                        $n = $maskSample['num'][$i] + $prevIssueLastNum;
                    }
                }
        if ($this->_debug) {
            echo "v:";var_dump($v);
            echo "n:";var_dump($n);
        }
                $newIssue = new facicData();
                $newIssue->set_year($y);
                $newIssue->set_vol($v);
                $newIssue->set_num($n);
                $newIssue->set_mask($maskID);
                $newIssue->set_type("");
                $newIssue->set_status("P");
                $newIssue->set_qtd("1");
                $newIssue->set_note("");
                $newIssue->set_mfn("New");
                $newIssue->set_idmfn("New");
                $lastSeqNumber = $this->getNextSeqNumber($lastSeqNumber);
                $newIssue->setData("sequentialNumber",$lastSeqNumber);
                $issues[] = $newIssue;
            }
            if ($maskSample['volSeq']== '0'){
                // vol - infinite
                $prevIssueLastVol = $v;
            }
            if ($maskSample['numSeq']== '0'){
                // vol - infinite
                $prevIssueLastNum = $n;
            }
            $index = 0;
        }
        if ($this->_debug) {
            echo "generateFutureIssues return\n";
            var_dump($issues);
        }

        return $issues;
    }

	function getFutureIssues($initialYear, $year, $vol, $num, $maskSample, $maskID, $lastSeqNumber, $prevMask){

            $prevMask = trim($prevMask);
            $maskID = trim($maskID);
            if ($this->_debug){
                echo "getFutureIssues\ninitialYear: "; var_dump($initialYear);
                echo "Year: "; var_dump($year);
                echo "vol: "; var_dump($vol);
                echo "num: "; var_dump($num);
                echo "maskSample: "; var_dump($maskSample);
                echo "maskId: "; var_dump($maskID);
                echo "lastSeqNumber: "; var_dump($lastSeqNumber);
            }
            if ($vol == 'null' || !$vol){
                    $vol = '';
            }
            if ($num == 'null' || !$num){
			$num = '';
            }
            if ($year == 'null' || !$year){
                    $year = $initialYear;
            }
            if ($year !=0){
                if ($prevMask != $maskID) {
                    $vol = $maskSample['vol'][0];
                    $num = $maskSample['num'][0];
                }
                $r = $this->findFistYearInfo($vol, $num, $maskSample);
                //var_dump($r)            ;
                $issueIndex = $this->findCurrentIssueIndex($vol, $num, $r);
                $issues = $this->generateFutureIssues($maskSample, $issueIndex, $r, $year, $vol, $num, $lastSeqNumber, $maskID);
                if ($this->_debug){
                    echo "getFutureIssues\n";
                    var_dump($issues);
                }
            }
            return $issues;
	}
	
}
?>