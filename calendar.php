<?php
/**
*@author  Xu Ding
*@email   thedilab@gmail.com
*@website http://www.StarTutorial.com
**/
class Calendar {  
     
    /**
     * Constructor
     */
    public function __construct(){     
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
		$this->naviQuery = $_SERVER['QUERY_STRING'];
		
		if(isset($_GET["date"]))
			$this->giornoSelezionato = $_GET["date"];
			
    }
     
    /********************* PROPERTY ********************/  
    private $dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
    private $currentYear=0;
    private $currentMonth=0;
    private $currentDay=0;
    private $currentDate=null;
    private $daysInMonth=0;
    private $naviHref = null;
	private $naviQuery = null;
    private $giornoSelezionato = "#";
    /********************* PUBLIC **********************/  
        
    /**
    * print out the calendar
    */
    public function show() 
    {
        if(!isset($_GET['year']) && !isset($_GET['month']))
		{
			if(isset($_GET["date"]))
			{
				$year = date("Y", strtotime($_GET["date"]));
				$month = date("m", strtotime($_GET["date"]));
			}
			else
			{
				$year = date("Y",time()); 
				$month = date("m",time());
			}
		}
		else
		{
			$year = $_GET['year'];
			$month = $_GET['month'];
		}
         
         
        $this->currentYear=$year;
        $this->currentMonth=$month;
        $this->daysInMonth=$this->_daysInMonth($month,$year);  
         
        $content='<div id="calendar">'.
                '<div class="box">'.
                $this->_createNavi().
                '</div>'.
                '<div class="box-content">'.
                '<ul class="label">'.$this->_createLabels().'</ul>';   
        $content.='<div class="clear"></div>';     
        $content.='<ul class="dates">';    

        $weeksInMonth = $this->_weeksInMonth($month,$year);
        // Create weeks in a month
        for( $i=0; $i<$weeksInMonth; $i++ )
              for($j=1;$j<=7;$j++)
                $content.=$this->_showDay($i*7+$j);

        $content.='</ul>';
        $content.='<div class="clear"></div>'; 
        $content.='</div>';
        $content.='</div>';
        return $content;   
    }
     
    /********************* PRIVATE **********************/ 
    /**
    * create the li element for ul
    */
    private function _showDay($cellNumber)
    {
         
        if($this->currentDay==0)
        {
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
                     
            if(intval($cellNumber) == intval($firstDayOfTheWeek))
                $this->currentDay=1;
        }
         
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) )
        {
            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
            $cellContent = $this->currentDay;
            $this->currentDay++;   
        } 
        else
        {
            $this->currentDate =null;
            $cellContent=null;
        }
        
        if($this->currentDate == null)
        	$string = '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                ($cellContent==null?'mask':'').'" style="background-color: white; ">'.$cellContent.'</li>';
        else
		{
        	if($this->currentDate <= Date('Y-m-d', time()))
				$string = '<li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                ($cellContent==null?'mask':'').'" style="background-color: #AAAAAA; ">'.$cellContent.'</li>';
			else
			{
				$string = '<a href="index.php?date='.$this->currentDate.'"><li id="li-'.$this->currentDate.'" class="'.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' '));
				
				if($this->giornoSelezionato == $this->currentDate)
					$string .= ($cellContent==null?'mask':'').' selezionato">'.$cellContent.'</li></a>';
				else
					$string .= ($cellContent==null?'mask':'').'">'.$cellContent.'</li></a>';
			}
		}
        return $string;
    }
     
    /**
    * create navigation
    */
    private function _createNavi()
    {
         
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
        
		if($this->giornoSelezionato == "#")
			$sostegno = $this->naviHref . "?";
		else
			$sostegno = $this->naviHref . "?date=" . $this->giornoSelezionato . "&";
        return
            '<div class="header">'.
                '<a class="prev" href="'.$sostegno.'month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
                    '<span class="title">'.date('Y F',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '<a class="next" href="'.$sostegno.'month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
            '</div>';
			
		
    }
         
    /**
    * create calendar week labels
    */
    private function _createLabels()
    {  
                 
        $content='';
         
        foreach($this->dayLabels as $index=>$label)
        {
            $content.='<li class="'.($label==6?'end title':'start title').' title">'.$label.'</li>';
        }
         
        return $content;
    }
     
     
     
    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null)
    {
         
        if( null==($year) )
            $year =  date("Y",time()); 
         
        if(null==($month))
            $month = date("m",time());
         
        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
         
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
         
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
         
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
         
        if($monthEndingDay<$monthStartDay)
            $numOfweeks++;
         
        return $numOfweeks;
    }
 
    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null)
    {
         
        if(null==($year))
            $year =  date("Y",time()); 
 
        if(null==($month))
            $month = date("m",time());
             
        return date('t',strtotime($year.'-'.$month.'-01'));
    }
     
}