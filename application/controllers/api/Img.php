<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Img extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Base64_model', 'base64');
    }

    public function index($id = null)
    {
        $base64_data = $this->base64->getDataById($id);
        if ($base64_data['data'] == null || $base64_data['data'] == '') {
            header(http_response_code(404));
        }
        echo base64_decode($base64_data['data']);
    }

    public function parent($id = null)
    {
        $base64_data = $this->base64->getDataByParentId($id);
        if ($base64_data['data'] == null || $base64_data['data'] == '') {
            header(http_response_code(404));
        }
        echo base64_decode($base64_data['data']);
    }

    public function view($id = null)
    {
        $dataimage = $this->base64->getDataByParentIdArray($id);
        echo '
        <!doctype html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>'.app_name().' — Dokumentasi</title>
            </head>
            <body style="background-color: black;">';

            foreach ($dataimage as $d) {
                $base64 = $d['data'];
                echo '<img id="wrap" style="display: block; width: auto; height: 100% !important; margin: auto; vertical-align: middle;"
                        src="data:image/jpeg;base64,'.$base64.'">';
                echo '<center><p style="color:white;">'.$d['desc'].'</p></center><br>';
            }
            echo '</body> </html>';
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