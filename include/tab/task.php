<?php
sup_class::include_module_iblock();
$task = task::available_list();
//таблица с задачами ?>
<div class="row">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <td>id</td>
            <td>Название</td>
            <td>Исполнитель</td>
            <td>Статус</td>
            <td>Действия</td>
        </tr>
        </thead>
        <tbody class="js_container_task">

        <?php foreach ($task as $el) {?>
            <tr data-id="<?=$el['ID']?>">
                <td><?=$el['ID']?></td>
                <td class="js_el_name"><?=$el['NAME']?></td>
                <td class="js_el_executor"><?=$el['EXECUTOR']?></td>
                <td class="js_el_status"><?=$el['STATUS']?></td>
                <td>
                    <a href="#" data-toggle="modal" data-target="#add_task" data-id="<?=$el['ID']?>">edit</a>
                    /
                    <a href="#" data-id="<?=$el['ID']?>" class="js_delete_task">delete</a>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-8 offset-md-4">
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add_task">add task</button>
    </div>
</div>