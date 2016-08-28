# PHP-Timed-Tasks

Created by Weidi Zhang

## Installation

```
composer require weidizhang/php-timed-tasks:dev-master
```

## Usage

First, require the autoloader and use the classes.

```
require "vendor/autoload.php";

use weidizhang\PHPTimedTasks\Task;
use weidizhang\PHPTimedTasks\TimedTaskManager;
```

Create a new TimedTaskManager object

```
$manager = new TimedTaskManager();
```


### Using lambda functions

```
$manager->addTask(
	new Task(function() {
		echo "[" . date("h:i:s A") . "] Hello every 10 seconds!\n";
	}, 10)
);
```
Here, this function will run forever every 10 seconds.


### Using already declared functions

```
function myFunc() {
	echo "[" . date("h:i:s A") . "] Hello every 10 seconds!\n";
}

$manager->addTask(
	new Task("myFunc", 10)
);
```
Simply pass in the function name as a string.


### Setting maximum number of times to run

```
$manager->addTask(
	(new Task(function() {
		echo "[" . date("h:i:s A") . "] Hello every 10 seconds!\n";
	}, 10))
	->setMaxTimes(5)
);
```
This is done by calling the setMaxTimes function of the Task class which accepts an integer.

In this example, this task will run 5 times total, once every 10 seconds.


### Setting parameters

```
$manager->addTask(
	(new Task(function($a, $b) {
		echo "[" . date("h:i:s A") . "] Hello every 10 seconds for 5 times with arguments \"" . $a . "\" and \"" . $b . "\"\n";
	}, 10))
	->setMaxTimes(5)
	->addParameters(array(
		"test1",
		"test2"
	))
);
```
This is done by calling the addParameters function of the Task class which accepts an array.

### Using a random interval range

```
$manager->addTask(
    (new Task(function() {
        echo "[" . date("h:i:s A") . "] Hello every 5-10 seconds!\n";
    }))
	->setRandomIntervalRange(5, 10)
);
```
This task will run every 5 to 10 seconds, a random interval between this range is used each time.

### Running tasks
The first option is to use:
```
$manager->runTasks();
```
All code after this will not run while there are still tasks remaining.


If you have other tasks to perform, use your own while loop instead
```
while ($manager->runTasksOnce()) {
	// your additional logic
}
```

### Removing tasks
Removing tasks is simple.
The addTask function returns an integer.
```
$index = $manager->addTask( ... );
```

This can be used to remove the task.
```
$manager->removeTask($index);
```

## License

Please read LICENSE.md to learn about what you can and cannot do with this source code.