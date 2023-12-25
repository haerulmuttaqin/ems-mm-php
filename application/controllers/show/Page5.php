<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page5 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
         $this->load->model('Page5_model', 'page');
    }

    function _remap($param, $param2) {
        $this->index($param, $param2);
    }

    public function index($unit = null, $unit2 = null)
    {
        if ($unit == 'chart_data') {
            $this->chart_data($unit2[0]);
            return;
        }
        $data['title'] = 'Page 5';
        $data['unit'] = $unit;
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['data'] = $this->page->getTableData($unit);
        $this->load->view('_partials/header_app', $data);
        $this->load->view('app_pages/page5', $data);
        $this->load->view('_partials/footer_app');
    }

    public function chart_data($unit)
    {
        $data['chart1'] = $this->page->getPieRasio($unit);
        $data['chart2'] = $this->page->getPieElektronik($unit);
        $data['chart3'] = $this->page->getPieLift($unit);
        echo json_encode($data);
    }
}