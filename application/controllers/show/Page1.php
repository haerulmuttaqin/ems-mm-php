<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page1 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Page1_model', 'page');
    }

    function _remap($param, $param2) {
        $this->index($param, $param2);
    }

    public function index($unit = null, $unit2 = null)
    {
        if ($unit == 'pie_data') {
            $this->pie_data($unit2[0]);
            return;
        }
        $data['title'] = 'Page 1';
        $data['unit'] = $unit;
        $data['dash'] = $this->master->getGenericByCategoryName('DASHBOARD CONFIG');
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['data'] = $this->page->getTableData($unit);
        $this->load->view('_partials/header_app', $data);
        $this->load->view('app_pages/page1', $data);
        $this->load->view('_partials/footer_app');
    }

    public function pie_data($unit)
    {
        $data = $this->page->getPieCartData($unit);
        echo json_encode($data);
    }
}