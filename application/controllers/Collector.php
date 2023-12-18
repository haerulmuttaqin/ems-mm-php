<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Collector extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
        $this->load->model('Master_model', 'master');
    }

    public function index()
    {
        redirect('../');
    }

    public function test()
    {

        $obj = json_decode($result);
        $data = file_get_contents("http://localhost/ems.mm/dashboard1.json");
        $data = mb_substr($data, strpos($data, '{'));
        $data = mb_substr($data, 0, -1);
        $result = json_decode($data, true);
        echo $result;
//        $this->db->insert('test', array('date'=> get_times_now()));
//        echo 'Inserted on ' . get_times_now() . ' excecuted.' . PHP_EOL;
    }
}