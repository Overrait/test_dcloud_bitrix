<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);

use \Bitrix\Main\Page\Asset;

$instance = Asset::getInstance();

CJSCore::Init(array("fx"));
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <?$APPLICATION->ShowHead();?>
        <title><?$APPLICATION->ShowTitle()?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSS only -->
        <?php
        $instance->addCss('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css');
        ?>

        <!-- JS, Popper.js, and jQuery -->
        <?php
        $instance->addJs('https://code.jquery.com/jquery-3.5.1.min.js');
        $instance->addJs('https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js');
        $instance->addJs('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js');

        $instance->addJs(SITE_TEMPLATE_PATH . '/js/script.js');
        ?>
    </head>

    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF">
        <?$APPLICATION->ShowPanel()?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"><?$APPLICATION->ShowTitle()?></div>
                            <div class="card-body">