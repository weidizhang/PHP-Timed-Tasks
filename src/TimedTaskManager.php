<?php
/*
 * @author Weidi Zhang
 */

namespace weidizhang\PHPTimedTasks;
 
class TimedTaskManager
{
	private $tasks = array();
	
	public function addTask($task) {
		$this->tasks[] = $task;
		
		end($this->tasks);
		return key($this->tasks);
	}
	
	public function removeTask($taskIndex) {
		if (isset($this->tasks[$taskIndex])) {
			unset($this->tasks[$taskIndex]);
			
			return true;
		}
		return false;
	}
	
	public function runTasks() {
		while (true) {
			sleep(1);
				
			foreach ($this->tasks as $taskIndex => $task) {
				$task->incrementTimeElapsed();
				
				if ($task->runTask()) {
					if (($task->getTimesRun() >= $task->getMaxTimes()) && $task->getMaxTimes() > 0) {
						$this->removeTask($taskIndex);
					}
				}
			}
		}
	}
}
?>