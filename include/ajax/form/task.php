<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!check_bitrix_sessid()) {
    die();
}
use Bitrix\Main\Context;

//форма добавления задачи
sup_class::include_module_iblock();
$executor = executor::available_list();
$status = task::status_list();

$task = (new task(Context::getCurrent()->getRequest()))->get_current();
if (is_null($task)) {
    echo '<div class="alert alert-danger">Ошибка получения данных попробуйте позже</div>';
    die();
}
?>
<div class="alert alert-danger d-none"></div>
<form class="js_ajax_task" method="post" action="<?= ($task) ? '/ajax/task/edit.php' : '/ajax/task/add.php'?>">
    <?=bitrix_sessid_post()?>
    <?=$executor ? '<input type="hidden" name="id" value="' . $task['id'] . '">':''?>
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">Название</label>
        <div class="col-md-6">
            <input class="form-control" name="name" id="name" type="text" value="<?=$task ? $task['name'] : ''?>"/>
        </div>
    </div>
    <div class="form-group row">
        <label for="executor" class="col-md-4 col-form-label text-md-right">Исполнитель</label>
        <div class="col-md-6">
            <select name="executor" id="executor" class="form-control">
                <option></option>
                <?php foreach ($executor as $el) {
                    echo '<option value="',$el['ID'],'" ',($task && $task['executor_id'] == $el['ID']) ? 'selected="selected"': '','>',$el['NAME'],'</option>';
                }?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="status" class="col-md-4 col-form-label text-md-right">Статус</label>
        <div class="col-md-6">
            <select name="status" id="status" class="form-control">
                <option></option>
                <?php foreach ($status as $el) {
                    echo '<option ',($task && $task['status_id'] == $el['ID']) ? 'selected="selected"': '','>',$el['VALUE'],'</option>';
                }?>
            </select>
        </div>
    </div>
    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">cancel</button>
        </div>
    </div>
</form>