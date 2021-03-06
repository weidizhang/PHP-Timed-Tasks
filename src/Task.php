<?php
/*
 * @author Weidi Zhang
 */

namespace weidizhang\PHPTimedTasks;
 
class Task
{
	private $function;
	private $interval;
	
	private $parameters = array();
	private $maxTimesToRun = -1;
	
	private $timesRun = 0;	
	private $timeElapsed = 0;
	
	private $randIntervalMin = 0;
	private $randIntervalMax = 0;
	
	public function __construct($function, $interval = 1) {
		$this->function = $function;
		$this->interval = $interval;
	}
	
	public function addParameters($params) {
		$this->parameters = $params;
		return $this;
	}
	
	public function setMaxTimes($max) {
		$this->maxTimesToRun = $max;
		return $this;
	}
	
	public function setRandomIntervalRange($min, $max) {
		$this->randIntervalMin = $min;
		$this->randIntervalMax = $max;
		return $this;
	}
		
	public function updateInterval() {
		if ($this->randIntervalMin > 0 && $this->randIntervalMax > 0) {
			$this->interval = rand($this->randIntervalMin, $this->randIntervalMax);
		}
	}
	
	public function getMaxTimes() {
		return $this->maxTimesToRun;
	}
	
	public function getTimesRun() {
		return $this->timesRun;
	}
	
	public function runTask() {
		if ($this->timeElapsed == $this->interval) {
			if (count($this->parameters) > 0) {
				call_user_func_array($this->function, $this->parameters);
			}
			else {
				call_user_func($this->function);
			}
			
			$this->timesRun++;
			$this->timeElapsed = 0;
			
			return true;
		}
		return false;
	}
	
	public function incrementTimeElapsed() {
		$this->timeElapsed++;
	}
}
?>