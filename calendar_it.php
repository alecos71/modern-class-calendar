<?php
  /**
  * @author  Xu Ding
  * @website https://www.StarTutorial.com
  * @revised by Alessandro Marinuzzi
  * @website https://www.alecos.it/
  * @revised 10.17.2017
  **/
  class Calendar {
    /**
    ** Constructor
    **/
    public function __construct() {
      $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }
    /********************* PROPERTY ********************/
    private $dayLabels = array("Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom");
    private $currentYear = 0;
    private $currentMonth = 0;
    private $currentDay = 0;
    private $currentDate = null;
    private $daysInMonth = 0;
    private $naviHref = null;
    /********************* PUBLIC **********************/
    /**
    ** Print out the calendar
    **/
    public function show() {
      $year = null;
      $month = null;
      if (null == $year && isset($_GET['year'])) {
        $year = htmlentities($_GET['year'], ENT_QUOTES);
      } elseif (null == $year) {
        $year = date("Y", time());
      }
      if ((!is_numeric($year)) || ($year == "")) {
        $year = date("Y", time());
      }
      if (null == $month && isset($_GET['month'])) {
        $month = htmlentities($_GET['month'], ENT_QUOTES);
      } elseif (null == $month) {
        $month = date("m", time());
      }
      if ((!is_numeric($month)) || ($month == "")) {
        $month = date("m", time());
      }
      $this->currentYear = $year;
      $this->currentMonth = $month;
      $this->daysInMonth = $this->_daysInMonth($month, $year);
      $content = '<div id="calendar">' . "\r\n" . '<div class="calendar_box">' . "\r\n" . $this->_createNavi() . "\r\n" . '</div>' . "\r\n" . '<div class="calendar_content">' . "\r\n" . '<div class="calendar_label">' . "\r\n" . $this->_createLabels() . '</div>' . "\r\n";
      $content .= '<div class="calendar_clear"></div>' . "\r\n";
      $content .= '<div class="calendar_dates">' . "\r\n";
      $weeksInMonth = $this->_weeksInMonth($month, $year);
      // Create weeks in a month
      for ($i = 0; $i < $weeksInMonth; $i++) {
        // Create days in a week
        for ($j = 1; $j <= 7; $j++) {
          $content .= $this->_showDay($i * 7 + $j);
        }
      }
      $content .= '</div>' . "\r\n";
      $content .= '<div class="calendar_clear"></div>' . "\r\n";
      $content .= '</div>' . "\r\n";
      $content .= '</div>' . "\r\n";
      return $content;
    }
    /********************* PRIVATE **********************/ 
    /**
    ** Create the calendar days
    **/
    private function _showDay($cellNumber) {
      if ($this->currentDay == 0) {
        $firstDayOfTheWeek = date('N', strtotime($this->currentYear . '-' . $this->currentMonth . '-01'));
        if (intval($cellNumber) == intval($firstDayOfTheWeek)) {
          $this->currentDay = 1;
        }
      }
      if (($this->currentDay != 0) && ($this->currentDay <= $this->daysInMonth)) {
        $this->currentDate = date('Y-m-d', strtotime($this->currentYear . '-' . $this->currentMonth . '-' . ($this->currentDay)));
        $cellContent = $this->currentDay;
        $this->currentDay++;
      } else {
        $this->currentDate = null;
        $cellContent = null;
      }
      $today_day = date("d");
      $today_mon = date("m");
      $today_yea = date("Y");
      $class_day = ($cellContent == $today_day && $this->currentMonth == $today_mon && $this->currentYear == $today_yea ? "calendar_today" : "calendar_days");
      return '<div class="' . $class_day . '">' . $cellContent . '</div>' . "\r\n";
    }
    /**
    ** Create navigation
    **/
    private function _createNavi() {
      $nextMonth = $this->currentMonth == 12 ? 1 : intval($this->currentMonth)+1;
      $nextYear = $this->currentMonth == 12 ? intval($this->currentYear)+1 : $this->currentYear;
      $preMonth = $this->currentMonth == 1 ? 12 : intval($this->currentMonth)-1;
      $preYear = $this->currentMonth == 1 ? intval($this->currentYear)-1 : $this->currentYear;
      $getMonth = date('Y M', strtotime($this->currentYear . '-' . $this->currentMonth . '-1'));
      $english = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
      $italian = array("Gen","Feb","Mar","Apr","Mag","Giu","Lug","Ago","Set","Ott","Nov","Dic");
      $thisMonth = str_ireplace($english, $italian, $getMonth);
      return '<div class="calendar_header">' . "\r\n" . '<a class="calendar_prev" href="' . $this->naviHref . '?month=' . sprintf('%02d', $preMonth) . '&amp;year=' . $preYear.'">Precedente</a>' . "\r\n" . '<span class="calendar_title">' . $thisMonth . '</span>' . "\r\n" . '<a class="calendar_next" href="' . $this->naviHref . '?month=' . sprintf("%02d", $nextMonth) . '&amp;year=' . $nextYear . '">Prossimo</a>' . "\r\n"  . '</div>';
    }
    /**
    ** Create calendar week labels
    **/
    private function _createLabels() {
      $content = '';
      foreach ($this->dayLabels as $index => $label) {
        $content .= '<div class="calendar_names">' . $label . '</div>' . "\r\n";
      }
      return $content;
    }
    /**
    ** Calculate number of weeks in a particular month
    **/
    private function _weeksInMonth($month = null, $year = null) {
      if (null == ($year)) {
        $year = date("Y", time());
      }
      if (null == ($month)) {
        $month = date("m", time());
      }
      // Find number of days in this month
      $daysInMonths = $this->_daysInMonth($month, $year);
      $numOfweeks = ($daysInMonths % 7 == 0 ? 0 : 1) + intval($daysInMonths / 7);
      $monthEndingDay = date('N',strtotime($year . '-' . $month . '-' . $daysInMonths));
      $monthStartDay = date('N',strtotime($year . '-' . $month . '-01'));
      if ($monthEndingDay < $monthStartDay) {
        $numOfweeks++;
      }
      return $numOfweeks;
    }
    /**
    ** Calculate number of days in a particular month
    **/
    private function _daysInMonth($month = null, $year = null) {
      if (null == ($year)) $year = date("Y",time());
      if (null == ($month)) $month = date("m",time());
      return date('t', strtotime($year . '-' . $month . '-01'));
    }
  }
  $calendar = new Calendar();
  echo $calendar->show();
?>
