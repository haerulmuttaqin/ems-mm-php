<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'EMS';
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['data'] = $this->master->getBillingConfig();
        $this->load->view('_partials/header_app', $data);
        $this->load->view('app/index', $data);
        $this->load->view('_partials/footer_app');
    }
}