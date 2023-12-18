<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billconfig extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Cropper_model', 'crop');
        $this->load->model('Role_model', 'role');
        $this->load->model('Master_model', 'master');
    }

    public function index()
    {
        check_menu_access();
        $data['title'] = 'Billing Config';
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['data'] = $this->master->getBillingConfig();
        $this->load->view('_partials/header', $data);
        $this->load->view('master/bill', $data);
        $this->load->view('_partials/footer');
    }

    public function update() {
        $data = array(
            'bill_config_vat' => $this->input->post('bill_config_vat'),
            'bill_config_pju' => $this->input->post('bill_config_pju'),
            'bill_config_wbp' => $this->input->post('bill_config_wbp'),
            'bill_config_lwbp' => $this->input->post('bill_config_lwbp'),
            'bill_config_wbp_start_time' => $this->input->post('bill_config_wbp_start_time'),
            'bill_config_wbp_end_time' => $this->input->post('bill_config_wbp_end_time'),
            'bill_config_pic' => $this->input->post('bill_config_pic'),
            'bill_config_invoice_title' => $this->input->post('bill_config_invoice_title'),
            'bill_config_address' => $this->input->post('bill_config_address'),
        );
        $this->master->updateBillingConfig($data);
        $this->toastr->success('Data updated!');
        redirect('billconfig');
    }


    public function upload() {
        $json = array();
        $avatar_src = $this->input->post('avatar_src');
        $avatar_data = $this->input->post('avatar_data');
        $avatar_file = $_FILES['avatar_file'];
        $user_sid = $this->input->post('user_sid');
        $upltype = $this->input->post('upltype');

        $originalPath = FCPATH . '/assets-'.app_version().'/uploads/img/';
        $thumbPath = FCPATH . '/assets-'.app_version().'/uploads/img/';
        $urlPath = FCPATH . '/assets-'.app_version().'/uploads/img/';

        $thumb = $this->crop->setDst($thumbPath);
        $this->crop->setSrc($avatar_src);
        $data = $this->crop->setData($avatar_data);
        // set file
        $avatar_path = $this->crop->setFile($avatar_file, $originalPath);
        // crop
        $this->crop->crop($avatar_path, $thumb, $data);
        //base64

        $path = $thumbPath . '/' . $this->crop->getThumbResult();
        $data = file_get_contents($path);
        $base64 = base64_encode($data);

        // response
        $json = array(
            'state'  => 200,
            'message' => $this->crop->getMsg(),
            'result' => $base64,
            'thumb' => $this->crop->getThumbResult(),
            'user_sid' => $user_sid,
            'urlPath' => $urlPath,
        );
        echo json_encode($json);
    }

    public function uploadCropImg() {
        $json = array();
        $user_sid = $this->input->post('user_sid');
        $base64 = $this->input->post('base64');
        $path = $this->input->post('path');
        $thumb = $this->input->post('thumb');
        if (!empty($user_sid)) {
            $this->db->update('billing_config', array(
                'bill_config_logo' => $base64
            ));
            unlink(FCPATH . '/assets-'.app_version().'/uploads/img/' . $thumb);
            unlink(FCPATH . '/assets-'.app_version().'/uploads/img/' . str_replace('.png', '', $thumb) . '-original.png');
            $json['success'] = 'success';
        }  else {
            $json['success'] = 'failed';
        }
        header('Content-Type: application/json');
        echo json_encode($json);
    }
}