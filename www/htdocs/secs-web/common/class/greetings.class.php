<?
class greeting
{
    var $hour;
    var $minute;
    var $seconds;
    var $day;
    var $month;
    var $year;
    var $week;
    var $curWeek;
    var $curMonth;
    var $greet;
    
    function greeting()
    {
        $this->now();
    }
    function now()
    {
        $this->setHours();
        $this->setMinute();
        $this->setSeconds();
        $this->setDay();
        $this->setWeek();
        $this->setYear();  
        $this->setGreet();      
        $this->month();
        $this->dayOfWeek();
    }    
    function setHours()
    {
        $this->hour = date("H");
    }
    function setMinute()
    {
        $this->minute = date("i");
    }
    function setSeconds()
    {
        $this->seconds = date("s");
    }
    function setDay()
    {
        $this->day = date("d");
    }
    function setMonth()
    {
        $this->month = date("m");
    }
    function setYear()
    {
        $this->year = date("Y");
    }
    function setWeek()
    {
        $this->week = date("D");
    }
    function dayOfWeek()
    {
        global $BVS_LANG;
        global $BVS_LANG;
        $this->curWeek = $BVS_LANG["weekOfDay"][$this->week];        
    }
    function month()
    {
        global $BVS_LANG;
        $this->setMonth();
        $this->curMonth = $BVS_LANG["monthOfYear"][$this->month];        
    }
    function setGreet()
    {
        global $BVS_LANG;
        if ($this->hour > 00 && $this->hour <= 12) {
            $this->greet = $BVS_LANG["goodMorning"];
        } elseif ($this->hour > 12 && $this->hour <= 18) {
            $this->greet = $BVS_LANG["goodAfternoom"];
        } else {
            $this->greet = $BVS_LANG["goodEvening"];
        }        
    }
    /**
    * @return unknown
    * @desc Enter description here...
    */
    function getGreet()
    {
        return $this->greet;
    }
    function getDay()
    {
        return $this->day;
    }
    function getMonth()
    {
        return $this->curMonth;
    }
    function getWeekDay()
    {
        return $this->curWeek;
    }
    function getYear()
    {
        return $this->year;
    }
    function getHours()
    {
        return $this->hour . ":" . $this->minute;
    }
}
?>