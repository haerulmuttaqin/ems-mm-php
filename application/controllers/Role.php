<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Role_model', 'role');
        $this->load->model('Master_model', 'master');
    }

    public function index()
    {
        check_menu_access();
        $data['title'] = 'Role Access';
        $data['menu'] = $this->menu->getMenu();
        $data['roles'] = $this->master->getRoles();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['resume'] =  $data['roles'][0]['ref_sid'];

        $this->load->view('_partials/header', $data);
        $this->load->view('role/index', $data);
        $this->load->view('_partials/footer');
    }

    public function get() {
        echo json_encode($this->master->getRoles());
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = array(
            'role_sid' => $role_id,
            'menu_sid' => $menu_id
        );

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $data['access_sid'] = $this->uuid->sid();
            $this->db->insert('user_access_menu', $data);
            $this->toastr->success('Access added!');
        } else {
            $this->db->delete('user_access_menu', $data);
            $this->toastr->success('Access removed!');
        }
    }
}