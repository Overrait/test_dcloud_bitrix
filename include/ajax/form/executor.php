<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!check_bitrix_sessid()) {
    die();
}
use Bitrix\Main\Context;

sup_class::include_module_iblock();
$executor = (new executor(Context::getCurrent()->getRequest()))->get_current();

if (is_null($executor)) {
    echo '<div class="alert alert-danger">Ошибка получения данных попробуйте позже</div>';
    die();
}

//форма добавления/редактирования исполнителя ?>
<div class="alert alert-danger d-none"></div>
<form class="js_ajax_executor" method="post" action="<?=($executor ? '/ajax/executor/edit.php' : '/ajax/executor/add.php')?>">
    <?=bitrix_sessid_post()?>
    <?=$executor ? '<input type="hidden" name="id" value="' . $executor['id'] . '">':''?>
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">Имя</label>
        <div class="col-md-6">
            <input class="form-control" name="name" id="name" type="text" value="<?=$executor ? $executor['name'] : ''?>"/>
        </div>
    </div>
    <div class="form-group row">
        <label for="position" class="col-md-4 col-form-label text-md-right">Должность</label>
        <div class="col-md-6">
            <input class="form-control" name="position" id="position" type="text" value="<?=$executor ? $executor['position'] : ''?>"/>
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">cancel</button>
        </div>
    </div>
</form>