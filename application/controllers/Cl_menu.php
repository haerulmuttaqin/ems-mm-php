<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cl_menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* check_menu_access(); */
        $this->load->model('Menu_model', 'menu');
        $this->load->model('Cropper_model', 'crop');
    }

    public function index()
    {
        $data['title'] = 'Client Menu';
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['menu'] = $this->menu->getMenu();
        $client_menu = $this->master->getGenericByCategoryName('CLIENT MENU');
        if ($client_menu) {
            $data['client_menu'] = $client_menu;
            $data['menu_item'] = null;
        
            $this->form_validation->set_rules('menu', 'Menu', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('_partials/header', $data);
                $this->load->view('cl_menu/index', $data);
                $this->load->view('_partials/footer');
            } else {
                $this->db->insert('user_menu', array(
                    'menu_sid' => $this->uuid->sid(),
                    'menu' => $this->input->post('menu'),
                    'icon' => $this->input->post('icon')
                ));
                $this->toastr->success('New data added!');
                redirect('menu');
            }
        } else {
            $this->load->view('_partials/header', $data);
            $this->load->view('_partials/footer');
        }
    }

    public function upload() {
        $json = array();
        $avatar_src = $this->input->post('avatar_src');
        $avatar_data = $this->input->post('avatar_data');
        $avatar_file = $_FILES['avatar_file'];
        $data_sid = $this->input->post('data_sid');
        $data_desc = $this->input->post('data_desc');
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
            'data_sid' => $data_sid,
            'data_desc' => $data_desc,
            'urlPath' => $urlPath,
        );
        echo json_encode($json);
    }

    public function uploadCropImg() {
        $json = array();
        $data_sid = $this->input->post('data_sid');
        $data_desc = $this->input->post('data_desc');
        $json['data'] = $data_sid;
        $base64 = $this->input->post('base64');
        $path = $this->input->post('path');
        $thumb = $this->input->post('thumb');
        if (!empty($data_sid)) {
            if ($this->_deleteDataByParentIfExist($data_sid)) {
                $this->db->insert('base64_data', array(
                    'data_sid' => $this->uuid->sid(),
                    'parent_sid' => $data_sid,
                    'data' => $base64,
                    'data_path' => $path,
                    'data_type' => 'CL_MENU',
                    'desc' => $data_desc,
                    'post_date' => get_times_now(),
                    'post_by' => $this->session->userdata('user_sid'),
                    'post_status' => 1,
                ));
            }
            unlink(FCPATH . '/assets-'.app_version().'/uploads/img/' . $thumb);
            unlink(FCPATH . '/assets-'.app_version().'/uploads/img/' . str_replace('.png', '', $thumb) . '-original.png');
            $json['success'] = 'success';
        }  else {
            $json['success'] = 'failed';
        }
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    private function _deleteDataByParentIfExist($id) {
        $query = "DELETE FROM base64_data where parent_sid = '$id'";
        $this->db->query($query);
        return true;
    }

}