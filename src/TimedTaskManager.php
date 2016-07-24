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
	}
	
	public function runTasks() {
		while (true) {
			sleep(1);
				
			foreach ($this->tasks as $taskIndex => $task) {
				$task->incrementTimeElapsed();
				
				if ($task->runTask()) {
					if (($task->getTimesRun() >= $task->getMaxTimes()) && $task->getMaxTimes() > 0) {
						unset($this->tasks[$taskIndex]);
					}
				}
			}
		}
	}
}
?>