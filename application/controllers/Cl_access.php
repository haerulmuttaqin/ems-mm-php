<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cl_access extends CI_Controller
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
        $data['title'] = 'Client Access';
        $data['menu'] = $this->menu->getMenu();
        $data['roles'] = $this->master->getRolesClient();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['resume'] = $data['roles'][0]['ref_sid'];

        $this->load->view('_partials/header', $data);
        $this->load->view('cl_menu/access', $data);
        $this->load->view('_partials/footer');
    }

    public function get() {
        echo json_encode($this->master->getRolesClient());
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menu');
        $role_id = $this->input->post('role');

        $data = array(
            'role_sid' => $role_id,
            'menu_sid' => $menu_id
        );

        $result = $this->db->get_where('client_access_menu', $data);

        if ($result->num_rows() < 1) {
            $data['access_sid'] = $this->uuid->sid();
            $this->db->insert('client_access_menu', $data);
            $this->toastr->success('Access added!');
        } else {
            $this->db->delete('client_access_menu', $data);
            $this->toastr->success('Access removed!');
        }
    }

    public function changeAccessCreate()
    {
        $access_id = $this->input->post('access_id');

        $this->db->where('access_sid', $access_id);
        $this->db->update('client_access_menu', array(
            'create' => 1,
        ));
        if ($this->db->affected_rows() > 0) {
            $this->toastr->success('Create Access added!');
        } else {
            $this->db->where('access_sid', $access_id);
            $this->db->update('client_access_menu', array(
                'create' => 0,
            ));
            if ($this->db->affected_rows() > 0) {
                $this->toastr->success('Create Access removed!');
            } else {
                $this->toastr->error('Failed manage create access!');
            }
        }
    }

    public function changeAccessRead()
    {
        $access_id = $this->input->post('access_id');

        $this->db->where('access_sid', $access_id);
        $this->db->update('client_access_menu', array(
            'read' => 1,
        ));
        if ($this->db->affected_rows() > 0) {
            $this->toastr->success('Read Access added!');
        } else {
            $this->db->where('access_sid', $access_id);
            $this->db->update('client_access_menu', array(
                'read' => 0,
            ));
            if ($this->db->affected_rows() > 0) {
                $this->toastr->success('Read Access removed!');
            } else {
                $this->toastr->error('Failed manage read access!');
            }
        }
    }

    public function changeAccessUpdate()
    {
        $access_id = $this->input->post('access_id');

        $this->db->where('access_sid', $access_id);
        $this->db->update('client_access_menu', array(
            'update' => 1,
        ));
        if ($this->db->affected_rows() > 0) {
            $this->toastr->success('Update Access added!');
        } else {
            $this->db->where('access_sid', $access_id);
            $this->db->update('client_access_menu', array(
                'update' => 0,
            ));
            if ($this->db->affected_rows() > 0) {
                $this->toastr->success('Update Access removed!');
            } else {
                $this->toastr->error('Failed manage update access!');
            }
        }
    }

    public function changeAccessDelete()
    {
        $access_id = $this->input->post('access_id');

        $this->db->where('access_sid', $access_id);
        $this->db->update('client_access_menu', array(
            'delete' => 1,
        ));
        if ($this->db->affected_rows() > 0) {
            $this->toastr->success('Delete Access added!');
        } else {
            $this->db->where('access_sid', $access_id);
            $this->db->update('client_access_menu', array(
                'delete' => 0,
            ));
            if ($this->db->affected_rows() > 0) {
                $this->toastr->success('Delete Access removed!');
            } else {
                $this->toastr->error('Failed manage delete access!');
            }
        }
    }

}