<?php class EasyPeasyICS{protected $calendarName;protected $events=array();public function __construct($calendarName=""){$this->calendarName=$calendarName;}public function addEvent($start,$end,$summary="",$description="",$url=""){$this->events[]=array("start"=>$start,"end"=>$end,"summary"=>$summary,"description"=>$description,"url"=>$url);}public function render($output=true){$ics="";$ics.="BEGIN:VCALENDAR
METHOD:PUBLISH
VERSION:2.0
X-WR-CALNAME:".$this->calendarName."
PRODID:-//hacksw/handcal//NONSGML v1.0//EN";foreach($this->events as $event){$ics.="
BEGIN:VEVENT
UID:".md5(uniqid(mt_rand(),true))."@EasyPeasyICS.php
DTSTAMP:".gmdate('Ymd').'T'.gmdate('His')."Z
DTSTART:".gmdate('Ymd',$event["start"])."T".gmdate('His',$event["start"])."Z
DTEND:".gmdate('Ymd',$event["end"])."T".gmdate('His',$event["end"])."Z
SUMMARY:".str_replace("\n","\\n",$event['summary'])."
DESCRIPTION:".str_replace("\n","\\n",$event['description'])."
URL;VALUE=URI:".$event['url']."
END:VEVENT";}$ics.="
END:VCALENDAR";if($output){header('Content-type: text/calendar; charset=utf-8');header('Content-Disposition: inline; filename='.$this->calendarName.'.ics');echo $ics;}else{return $ics;}}} ?>