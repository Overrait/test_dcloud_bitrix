<?php
use Bitrix\Main\Request;
use Bitrix\Main\Loader;
use sup_class;
class task extends base{
    protected static $IBLOCK = TASK_IB;
    const STATUS_CODE = TASK_STATUS_PROP_CODE;
    const EXECUTOR_CODE = TASK_EXECUTOR_PROP_CODE;

    protected $message_add = 'Задача Сохранена!';
    protected $message_update = 'Задача Обновлена';
    protected $message_delete = 'Задача Удалена';

    protected $message_error_check = 'Указана неизвестная задача.';

    public function add()
    {
        try {
            sup_class::include_module_iblock();
            sup_class::check_sessid();

            $name = sup_class::valueString($this->request->get("name"));
            $executor = sup_class::valueInt($this->request->get("executor"));
            $status = sup_class::valueString($this->request->get("status"));

            $this->check_executor($executor);
            $this->check_status($status);

            $this->query_data_element(
                sup_class::add_element(
                    array(
                        'IBLOCK_ID' => self::$IBLOCK,
                        'NAME' => $name,
                        'PROPERTY_VALUES' => array(
                            self::EXECUTOR_CODE => $executor,
                            self::STATUS_CODE => sup_class::get_element_value_enum_id(self::$IBLOCK, self::STATUS_CODE, $status)
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

            $name = sup_class::valueString($this->request->get("name"));
            $executor = sup_class::valueInt($this->request->get("executor"));
            $id = sup_class::valueInt($this->request->get("id"));
            $status = sup_class::valueString($this->request->get("status"));

            $this->check($id);
            $this->check_executor($executor);
            $this->check_status($status);

            $this->query_data_element(
                sup_class::update_element(
                    $id,
                    array(
                        'IBLOCK_ID' => self::$IBLOCK,
                        'NAME' => $name,
                        'PROPERTY_VALUES' => array(
                            self::EXECUTOR_CODE => $executor,
                            self::STATUS_CODE => sup_class::get_element_value_enum_id(self::$IBLOCK, self::STATUS_CODE, $status)
                        )
                    )
                )
            );
        } catch (Throwable $e) {
            return json_encode(array('status' => $this->error, 'message' => $e->getMessage()));
        }

        return json_encode(array('status' => $this->success, 'message' => $this->message_update, 'data' => $this->data, 'type' => 'upd'));
    }

    public static function status_list()
    {
        return sup_class::get_element_value_enum_list(self::$IBLOCK, self::STATUS_CODE);
    }

    public static function available_list()
    {
        $data = array();

        $ar = sup_class::get_data_elements(
            array(
                'IBLOCK_ID' => self::$IBLOCK
            ),
            array(
                self::EXECUTOR_CODE
            )
        );

        foreach ($ar as $el) {
            $data[] = array(
                'ID' => $el['ID'],
                'NAME' => $el['NAME'],
                self::STATUS_CODE => $el['PROPERTIES'][self::STATUS_CODE]['VALUE'],
                self::EXECUTOR_CODE => $el['DISPLAY_PROPERTIES'][self::EXECUTOR_CODE]['LINK_ELEMENT_VALUE'][$el['DISPLAY_PROPERTIES'][self::EXECUTOR_CODE]['VALUE']]['NAME']
            );
        }

        return $data;
    }
    //unique

    protected function check_executor(int $id)
    {
        executor::check($id);
    }

    protected function check_status(string $value)
    {
        if (!sup_class::check_element_value_enum(self::$IBLOCK, self::STATUS_CODE, $value)) {
            throw new Exception('Указан неизвестный статус');
        }
    }

    protected function query_data_element(int $id)
    {
        $data = sup_class::get_data_element(array(
            'IBLOCK_ID' => self::$IBLOCK,
            'ID' => $id
        ));
        $this->data = array(
            'id' => $data['ID'],
            'name' => $data['NAME'],
            'status' => $data['PROPERTIES'][self::STATUS_CODE]['VALUE'],
            'status_id' => $data['PROPERTIES'][self::STATUS_CODE]['VALUE_ENUM_ID'],
            'executor' => $data['DISPLAY_PROPERTIES'][self::EXECUTOR_CODE]['LINK_ELEMENT_VALUE'][$data['DISPLAY_PROPERTIES'][self::EXECUTOR_CODE]['VALUE']]['NAME'],
            'executor_id' => $data['DISPLAY_PROPERTIES'][self::EXECUTOR_CODE]['VALUE']
        );
    }
}