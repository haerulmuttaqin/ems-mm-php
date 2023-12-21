<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Meter_model', 'meter');
    }

    public function index()
    {
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['title'] = 'Home';
        $this->load->view('_partials/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('_partials/footer');   
    }
    
    public function item($id)
    {
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['title'] = 'Home';
        $this->load->view('_partials/header', $data);
        $this->load->view('home/item', $data);
        $this->load->view('_partials/footer');
    }
    
    public function get_chart_data($id) {
        $data = $this->meter->getMeterDataChartById($id);
        echo json_encode($data);
    }
}