<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Context;
$request = Context::getCurrent()->getRequest();

$executor = new executor(Context::getCurrent()->getRequest());
echo $executor->edit();

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
die();