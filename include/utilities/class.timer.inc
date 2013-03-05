<?php
	
	/*
		
		Usage:
			$timer = new Timer;
			$timer->start_time();

			sleep(5); //sleep for a while

			$timer->end_time();
			echo "Script ran in: ";
			echo $timer->elapsed_time();
			echo " seconds."; 
	*/

	//Timer class
	class Timer
	{

		var $stime; //value of start time
		var $etime; //value of end time
 
		//default constructor
		function Timer()
		{
			$this->stime = 0.0;
		}

		function get_microtime()
		{
			$tmp = explode(" ",microtime());
			$rtime = (double)$tmp[0] + (double)$tmp[1];
			return $rtime;
		}
 
		function start_time()
		{
			$this->stime = $this->get_microtime();
		}
 
		function end_time()
		{
			$this->etime = $this->get_microtime();
		}	
 
		function elapsed_time($decimal = 3)
		{
			return round(($this->etime - $this->stime),$decimal);
		} 
 
	}
	
?>