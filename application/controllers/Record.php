<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Record extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->helper("file");
        $this->load->model('Record_model', 'record');
    }

    public function index()
    {
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['title'] = 'Meter Records';
        $this->load->view('_partials/header', $data);
        $this->load->view('meter/record', $data);
        $this->load->view('_partials/footer');
    }

    public function data()
    {
        $data = $row = array();
        $role = $this->db->get_where('generic_references',
            array('ref_sid' => $this->session->userdata('user_role_sid'))
        )->row_array();
        $memData = $this->record->getRows($_POST);

        $i = $_POST['start'];

        foreach ($memData as $member) {
            $i++;
            $data[] = array(
                $i,
                $member->meter_name,
                $member->date_formated,
                formatRp($member->record_value),
                $member->meter_sid
            );
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->record->countAll(),
            "recordsFiltered" => $this->record->countFiltered($_POST),
            "data" => $data,
        );

        // Output to JSON format
        echo json_encode($output);
    }

    public function get_by_sid($id) {
        $result = array();
        $data = $this->record->getBySid($id);
        if ($data) {
           $result = array('status' => true, 'message' => 'Fetch Successfully', 'data'=> $data);
        } else {
            $result = array('status' => false, 'message' => 'No data found!', 'data'=> null);
        }
        echo json_encode($result);
    }
}