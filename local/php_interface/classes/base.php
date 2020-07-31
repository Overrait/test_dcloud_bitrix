<?php
use Bitrix\Main\Request;
use Bitrix\Main\Loader;
use sup_class;

abstract class base {
    protected static $IBLOCK;

    protected $error = false;
    protected $success = true;

    protected $request;
    protected $data;

    protected $message_error_check;
    protected $message_delete;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public static function check(int $id)
    {
        if (!sup_class::check_element(self::$IBLOCK, $id)) {
            throw new Exception(self::message_error_check);
        }
    }

    public function delete()
    {
        try {
            sup_class::include_module_iblock();
            sup_class::check_sessid();

            $id = sup_class::valueInt($this->request->get("id"));

            $this->check($id);

            sup_class::delete_element($id);
        } catch (Throwable $e) {
            return json_encode(array('status' => $this->error, 'message' => $e->getMessage()));
        }

        return json_encode(array('status' => $this->success, 'message' => $this->message_delete, 'type' => 'del'));
    }

    public function get_current()
    {
        try {
            sup_class::include_module_iblock();
            $id = $this->request->get("id");
            if (is_null($id)) {
                return false;
            }
            $id = sup_class::valueInt($this->request->get("id"));
            $this->check($id);

            $this->query_data_element($id);
        } catch (Throwable $e) {
            return null;
        }

        return $this->data;
    }
}