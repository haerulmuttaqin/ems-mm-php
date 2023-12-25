<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page3 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Page3_model', 'page');
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
        $data['title'] = 'Page 3';
        $data['unit'] = $unit;
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        //$data['data'] = $this->page->getTableData($unit);
        $this->load->view('_partials/header_app', $data);
        $this->load->view('app_pages/page3', $data);
        $this->load->view('_partials/footer_app');
    }

    public function chart_data($unit)
    {
        $data['chart1'] = $this->page->getChartData($unit);
        $data['chart2'] = $this->page->getPieArus($unit);
        $data['chart3'] = $this->page->getPieTegangan($unit);
        $data['chart4'] = $this->page->getPiePf($unit);
        echo json_encode($data);
    }
}