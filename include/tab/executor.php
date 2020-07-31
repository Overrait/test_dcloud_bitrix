<?php
sup_class::include_module_iblock();
$executor = executor::available_list();
//таблица с исполнителями ?>
<div class="row">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <td>id</td>
            <td>Имя</td>
            <td>Должность</td>
            <td>Действия</td>
        </tr>
        </thead>
        <tbody class="js_container_executor">

        <?php foreach ($executor as $el) {?>
            <tr data-id="<?=$el['ID']?>">
                <td><?=$el['ID']?></td>
                <td class="js_el_name"><?=$el['NAME']?></td>
                <td class="js_el_position"><?=$el['POSITION']?></td>
                <td>
                    <a href="#" data-toggle="modal" data-target="#add_executor" data-id="<?=$el['ID']?>">edit</a>
                    /
                    <a href="#" data-id="<?=$el['ID']?>" class="js_delete_executor">delete</a>
                </td>
            </tr>
        <?php } ?>


        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-8 offset-md-4">
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#add_executor">add executor</button>
    </div>
</div>