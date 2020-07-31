<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php $APPLICATION->IncludeFile(
        '/include/modal/task.html',
        Array(),
        Array(
            'MODE' => 'html',
            'NAME' => 'modal task',
            'SHOW_BORDER' => false,
        )
    ); ?>
<?php $APPLICATION->IncludeFile(
    '/include/modal/executor.html',
    Array(),
    Array(
        'MODE' => 'html',
        'NAME' => 'modal executor',
        'SHOW_BORDER' => false,
    )
); ?>
<?php $APPLICATION->IncludeFile(
    '/include/modal/message.html',
    Array(),
    Array(
        'MODE' => 'html',
        'NAME' => 'modal message',
        'SHOW_BORDER' => false,
    )
); ?>
    </body>
</html>