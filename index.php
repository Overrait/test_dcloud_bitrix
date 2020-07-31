<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Демонстрационная версия продукта «1С-Битрикс: Управление сайтом»");
$APPLICATION->SetTitle("Главная страница");
?>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#task" >task</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#executor" >Executor</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="task">
            <?php $APPLICATION->IncludeFile(
                '/include/tab/task.php',
                Array(),
                Array(
                    'MODE' => 'php',
                    'NAME' => 'tab task',
                    'SHOW_BORDER' => false,
                )
            ); ?>
        </div>
        <div class="tab-pane fade" id="executor">
            <?php $APPLICATION->IncludeFile(
                '/include/tab/executor.php',
                Array(),
                Array(
                    'MODE' => 'php',
                    'NAME' => 'tab executor',
                    'SHOW_BORDER' => false,
                )
            ); ?>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>