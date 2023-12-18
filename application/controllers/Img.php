<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Img extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Base64_model', 'base64');
    }

    public function view($id = null)
    {
        $base64_data = $this->base64->getDataById($id);
        if ($base64_data['data'] == null || $base64_data['data'] == '') {
            $base64_data['data'] = get_no_image_profile();
        }
        $data['image_data'] = $base64_data;
        $this->load->view('_partials/image', $data, FALSE);
    }

    public function get_base64_by_parent($id = null, $type)
    {
        echo json_encode($this->base64->getDataByParentIdAndType($id, $type));
    }

    public function get_base64_by_parent_value($id = null, $type, $type_value)
    {
        echo json_encode($this->base64->getDataByParentIdAndTypeAndValue($id, $type, $type_value));
    }
}