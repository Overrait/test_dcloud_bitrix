<?php
define('TASK_IB', 1);
define('EXECUTOR_IB', 2);

define('TASK_STATUS_PROP_CODE', 'STATUS');
define('TASK_EXECUTOR_PROP_CODE', 'EXECUTOR');
define('EXECUTOR_POSITION_PROP_CODE', 'POSITION');

//classes
require_once __DIR__ . '/classes/sup_class.php';
require_once __DIR__ . '/classes/base.php';
require_once __DIR__ . '/classes/executor.php';
require_once __DIR__ . '/classes/task.php';