<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error404 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = '404';
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $this->output->set_status_header('404');
        $this->load->view('_partials/header', $data);
        $this->load->view('auth/error404');
        $this->load->view('_partials/footer', $data);
    }
}