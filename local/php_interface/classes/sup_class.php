<?php
use Bitrix\Main\Request;
use Bitrix\Main\Loader;

class sup_class {
    /**
     * приведение значения к типу строка
     *
     * @param $value
     * @return string
     */
    public static function valueString($value)
    {
        return (string)trim(htmlspecialchars(strip_tags(stripslashes($value))));
    }

    /**
     * приведение значения к типу инт
     *
     * @param $value
     * @return int
     */
    public static function valueInt($value)
    {
        return (int)trim(htmlspecialchars(strip_tags(stripslashes($value))));
    }

    public static function include_module_iblock()
    {
        if (!Loader::includeModule('iblock'))
            throw new Exception('Не подключен файл ядра');
    }

    public static function delete_element($id)
    {
        global $DB;
        $DB->StartTransaction();
        if(!CIBlockElement::Delete($id))
        {
            $DB->Rollback();
            throw new Exception('Ошибка удаления');
        }
        else
            $DB->Commit();
    }

    public static function check_sessid()
    {
        if (!check_bitrix_sessid()) {
            throw new Exception('Произошла неизвестная ошибка');
        }
    }

    public static function check_element($iblock_id, $id)
    {
        $db = CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID' => $iblock_id,
                'ID' => $id
            )
        );

        return $db->SelectedRowsCount() == 1;
    }

    public static function check_element_value_enum(int $iblock_id, string $code, string $value)
    {
        //check status
        $db = CIBlockPropertyEnum::Getlist(
            array(),
            array(
                'IBLOCK_ID' => $iblock_id,
                'CODE' => $code,
                'VALUE' => $value
            )
        );

        return $db->SelectedRowsCount() == 1;
    }

    public static function get_element_value_enum_id(int $iblock_id, string $code, string $value)
    {
        //check status
        $db = CIBlockPropertyEnum::Getlist(
            array(),
            array(
                'IBLOCK_ID' => $iblock_id,
                'CODE' => $code,
                'VALUE' => $value
            )
        );
        $ar = $db->Fetch();

        return $ar['ID'];
    }

    public static function get_element_value_enum_list(int $iblock_id, string $code)
    {
        $data = array();
        $db = CIBlockPropertyEnum::Getlist(
            array(),
            array(
                'IBLOCK_ID' => $iblock_id,
                'CODE' => $code,
            )
        );
        while ($ar = $db->GetNext()) {
            $data[] = array(
                'ID' => $ar['ID'],
                'VALUE' => $ar['VALUE'],
            );
        }

        return $data;
    }

    private function create_ciblockelement_object()
    {
        return new CIBlockElement();
    }

    public static function add_element(array $array)
    {
        $el = self::create_ciblockelement_object();
        $id = $el->Add($array);

        if (!((bool) $id)) {
            throw new Exception($el->LAST_ERROR);
        }

        return $id;
    }

    public static function update_element(int $id, array $array)
    {
        $el = self::create_ciblockelement_object();
        $flag = $el->Update($id, $array);

        if (!$flag) {
            throw new Exception($el->LAST_ERROR);
        }

        return $id;
    }

    public static function get_data_element(array $filter)
    {
        $db = CIBlockElement::GetList(
            array(),
            $filter,
            false,
            array(
                'nTopCount' => 1
            )
        );
        $ob = $db->GetNextElement();
        if (!$ob) {
            throw new Exception('Не найден элемент');
        }

        $ar = $ob->GetFields();
        $ar['PROPERTIES'] = $ob->GetProperties();

        foreach ($ar['PROPERTIES'] as &$prop) {
            $ar["DISPLAY_PROPERTIES"][$prop['CODE']] = CIBlockFormatProperties::GetDisplayValue($ar, $prop, "news_out");
        }

        return $ar;
    }

    public static function get_data_elements(array $filter, array $display = array())
    {
        $db = CIBlockElement::GetList(
            array(),
            $filter
        );

        $data = array();
        while ($ob = $db->GetNextElement()) {
            $ar = $ob->GetFields();
            $ar['PROPERTIES'] = $ob->GetProperties();

            if (count($display) > 0) {
                foreach ($display as $prop_code) {
                    $ar["DISPLAY_PROPERTIES"][$prop_code] = CIBlockFormatProperties::GetDisplayValue($ar, $ar['PROPERTIES'][$prop_code], "news_out");
                }
            }
            $data[] = $ar;
        }

        return $data;
    }
}