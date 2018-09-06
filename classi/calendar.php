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
         
        $content='<div id="calendar" class="row">'.
                '<div class="box col-xs-12 seven-cols">'.
                $this->_createNavi().
                '</div>'.
                '<div class="box-content col-xs-12">'.
                '<div class="labelNew row">
					<div class="seven-cols">'.$this->_createLabels().'</div>
				</div>';   
        $content.='<div class="clear"></div>';     
        $content.='<div class="dates cols-xs-12">';    

        $weeksInMonth = $this->_weeksInMonth($month,$year);
        // Create weeks in a month
        for( $i=0; $i<$weeksInMonth; $i++ )
              for($j=1;$j<=7;$j++)
                $content.=$this->_showDay($i*7+$j);

        $content.='</div>';
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
        
		if($cellNumber%7==1)
			$string = "<div class='row seven-cols'>";
		else
			$string = "";
		
        if($this->currentDate == null)
        	$string .= '<div id="li-" class="col-xs-1 text-center" style="visibility:hidden;">'.$cellContent.'</div>';
        else
		{
        	if($this->currentDate < Date('Y-m-d', time()))
				$string .= '<div id="li-'.$this->currentDate.'" class="col-xs-1 text-center" style="background-color: #AAAAAA; ">'.$cellContent.'</div>';
        	else if($this->_isClosed($this->currentDate) < 0)
                $string .= '<div id="li-'.$this->currentDate.'" class="col-xs-1 text-center" style="background-color: rgb(255, 128, 0); ">'.$cellContent.'</div>';
			else if($this->_hasNoStagione($this->currentDate))
                $string .= '<div id="li-'.$this->currentDate.'" class="col-xs-1 text-center" style="background-color: rgb(64, 134, 51); ">'.$cellContent.'</div>';
			else
			{
				$string .= '<a href="index.php?date='.$this->currentDate.'"><div id="li-'.$this->currentDate.'" class="';
				
				if($this->giornoSelezionato == $this->currentDate)
					$string .= ' selezionato col-xs-1 text-center">'.$cellContent.'</div></a>';
				else
					$string .= ' col-xs-1 text-center">'.$cellContent.'</div></a>';
			}
		}
		if($cellNumber%7==0)
			$string .= "</div>";
		
        return $string;
    }
     
    /**
    * create navigation
    */
    private function _createNavi()
    {
        $mesi = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"];
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
        
		if($this->giornoSelezionato == "#")
			$sostegno = $this->naviHref . "?";
		else
			$sostegno = $this->naviHref . "?date=" . $this->giornoSelezionato . "&";
        return
            '<div class="header row">'.
                '<a class="prev col-xs-2 text-center" href="'.$sostegno.'month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
                    '<span class="title col-xs-8 text-center">'.date('Y',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')) . " " . $mesi[date('n',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')) - 1] . '</span>'.
                '<a class="next col-xs-2 text-center" href="'.$sostegno.'month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
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
            $content.='<div class="title col-xs-1" style="text-align: center;">'.$label.'</div>';
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

    private function _isClosed($day)
    {
        // Connessione al DB
        $host = "localhost";
        $user = "ristoran_pren";
        $pass = "szc[yPA-hIhB";
        $dbname = "ristoran_prenotazioni";

        $connessione = new mysqli($host, $user, $pass, $dbname);

        if ($connessione->connect_errno) {
            echo "Errore in connessione al DBMS: " . $connessione->error;
        }
		$day_support = "x" . substr($day, strpos($day, "-"));
        $query = "SELECT id_fascia FROM stagioni NATURAL JOIN stagioni_orari WHERE (('$day' >= giorno_inizio and '$day' <= giorno_fine) or (giorno_inizio = '$day_support')) AND giorno_settimana = " . (date("w", strtotime(str_replace('-','/', $day))-1) % 7) . " order by priorita desc;";
        $result = $connessione->query($query);
		
		if($result && $result->num_rows != 0) {
            $row = mysqli_fetch_row($result);
			return $row[0];
        }

        return 0;
    }

    private function _hasNoStagione($day)
    {
        // Connessione al DB
        $host = "localhost";
        $user = "ristoran_pren";
        $pass = "szc[yPA-hIhB";
        $dbname = "ristoran_prenotazioni";

        $connessione = new mysqli($host, $user, $pass, $dbname);

        if ($connessione->connect_errno) {
            echo "Errore in connessione al DBMS: " . $connessione->error;
        }
		$day_support = "x" . substr($day, strpos($day, "-"));
        $query = "SELECT * FROM stagioni WHERE ('$day' >= giorno_inizio and '$day' <= giorno_fine) or (giorno_inizio = '$day_support');";
        $result = $connessione->query($query);

       if($result->num_rows != 0) {
            return false;
        }

        return true;
    }
}
