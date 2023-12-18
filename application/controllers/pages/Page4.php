<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page4 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Page 4';
        $this->load->view('_partials/header_app', $data);
        $this->load->view('app_pages/page4', $data);
        $this->load->view('_partials/footer_app');
    }
}