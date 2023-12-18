<?php
require APPPATH . 'libraries/Rest_lib.php';

class Info extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        //$this->verify_request();
        $user_sid = null;
    }

    public function index_get() {
        $data = $this->db->get('general_info')->row_array();
        $this->response(true, 'Successfully fetched!', $data, Rest_lib::HTTP_OK);
    }
}