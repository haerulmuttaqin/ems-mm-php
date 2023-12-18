<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page6 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Page 6';
        $this->load->view('_partials/header_app', $data);
        $this->load->view('app_pages/page6', $data);
        $this->load->view('_partials/footer_app');
    }
}