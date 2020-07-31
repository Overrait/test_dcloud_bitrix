<?php
use Bitrix\Main\Request;
use Bitrix\Main\Loader;
use sup_class;

class executor extends base {
    protected static $IBLOCK = EXECUTOR_IB;
    const POSITION_CODE = EXECUTOR_POSITION_PROP_CODE;

    protected $message_add = 'Исполнитель добавлен!';
    protected $message_update = 'Данные исполнителя изменены';
    protected $message_delete = 'Исполнитель удален';

    protected $message_error_check = 'Указан неизвестный исполнитель.';

    public function add()
    {
        try {
            sup_class::include_module_iblock();
            sup_class::check_sessid();

            $name = sup_class::valueString($this->request->get("name"));
            $position = sup_class::valueString($this->request->get("position"));

            $this->query_data_element(
                sup_class::add_element(
                    array(
                        'IBLOCK_ID' => self::$IBLOCK,
                        'NAME' => $name,
                        'PROPERTY_VALUES' => array(
                            self::POSITION_CODE => $position
                        )
                    )
                )
            );
        } catch (Throwable $e) {
            return json_encode(array('status' => $this->error, 'message' => $e->getMessage()));
        }

        return json_encode(array('status' => $this->success, 'message' => $this->message_add, 'data' => $this->data, 'type' => 'add'));
    }

    public function edit()
    {
        try {
            sup_class::include_module_iblock();
            sup_class::check_sessid();

            $id = sup_class::valueInt($this->request->get("id"));
            $name = sup_class::valueString($this->request->get("name"));
            $position = sup_class::valueString($this->request->get("position"));

            $this->check($id);

            $this->query_data_element(
                sup_class::update_element(
                    $id,
                    array(
                        'IBLOCK_ID' => self::$IBLOCK,
                        'NAME' => $name,
                        'PROPERTY_VALUES' => array(
                            self::POSITION_CODE => $position
                        )
                    )
                )
            );
        } catch (Throwable $e) {
            return json_encode(array('status' => $this->error, 'message' => $e->getMessage()));
        }

        return json_encode(array('status' => $this->success, 'message' => $this->message_update, 'data' => $this->data, 'type' => 'upd'));
    }

    public static function available_list()
    {
        $data = array();

        $ar = sup_class::get_data_elements(
            array(
                'IBLOCK_ID' => self::$IBLOCK
            )
        );

        foreach ($ar as $el) {
            $data[] = array(
                'ID' => $el['ID'],
                'NAME' => $el['NAME'],
                self::POSITION_CODE => $el['PROPERTIES'][self::POSITION_CODE]['VALUE']
            );
        }

        return $data;
    }

    //unique
    protected function query_data_element(int $id)
    {
        $data = sup_class::get_data_element(array(
            'IBLOCK_ID' => self::$IBLOCK,
            'ID' => $id
        ));
        $this->data = array(
            'id' => $data['ID'],
            'name' => $data['NAME'],
            'position' => $data['PROPERTIES'][self::POSITION_CODE]['VALUE']
        );
    }
}