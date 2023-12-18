<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        check_menu_access();
        $data['title'] = 'Pengaturan';
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_id'));

        $this->load->view('_partials/header', $data);
        $this->load->view('settings/index', $data);
        $this->load->view('_partials/footer');
    }

    public function menu()
    {
        check_menu_access();
        $data['title'] = 'Pengaturan';
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_id'));

        $this->form_validation->set_rules('title', 'Menu Title', 'required');
        $this->form_validation->set_rules('url', 'Menu URL', 'required');
        $this->form_validation->set_rules('position', 'Menu URL', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header', $data);
            $this->load->view('settings/menu', $data);
            $this->load->view('_partials/footer');
        }
        else {
            // Jika ada id berarti update
            if ($this->input->post('id')) {
                $this->db->where('menu_sid', $this->input->post('id'));
                $this->db->update('menu_master', array(
                    'menu_title' => $this->input->post('title'),
                    'menu_url' => $this->input->post('url'),
                    'menu_icon' => '',
                    'menu_position' => $this->input->post('position'),
                    'is_active' => $this->input->post('is_active'),
                ));
                $this->toastr->success('Menu updated!');
                redirect('settings/menu');
            }
            // sebaliknya
            else {
                $this->db->insert('menu_master', array(
                    'menu_sid' => $this->uuid->sid(),
                    'menu_title' => $this->input->post('title'),
                    'menu_url' => $this->input->post('url'),
                    'menu_icon' => '',
                    'menu_position' => $this->input->post('position'),
                    'is_active' => $this->input->post('is_active'),
                ));
                $this->toastr->success('New menu added!');
                redirect('settings/menu');
            }
        }
    }

    public function deleteMenu() {
        $this->db->delete('menu_master', array(
            'menu_id' => $this->input->get('delete_id'),
        ));
        $this->toastr->success('Menu deleted!');
        redirect('settings/menu');
    }

    public function group_products()
    {
        $data['title'] = 'Pengaturan';
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_id'));
        $data['group'] = $this->db->get('group_products')->result_array();

        $this->form_validation->set_rules('name', 'Group Name', 'required');
        $this->form_validation->set_rules('alias', 'Group Alias', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header', $data);
            $this->load->view('settings/group_products', $data);
            $this->load->view('_partials/footer');
        }
        else {
            // Jika ada id berarti update
            if ($this->input->post('id')) {
                $this->db->where('group_product_id', $this->input->post('id'));
                $this->db->update('group_products', array(
                    'group_product_name' => $this->input->post('name'),
                    'group_product_note' => $this->input->post('note'),
                    'group_product_alias' => $this->input->post('alias')
                ));
                $this->toastr->success('Menu updated!');
                redirect('settings/group_products');
            }
            // sebaliknya
            else {
                $this->db->set('group_product_id', 'UUID()', FALSE);
                $this->db->insert('group_products', array(
                    'group_product_name' => $this->input->post('name'),
                    'group_product_note' => $this->input->post('note'),
                    'group_product_alias' => $this->input->post('alias')
                ));
                $this->toastr->success('New group added!');
                redirect('settings/group_products');
            }
        }
    }

    public function deleteGroup() {
        $this->db->delete('group_products', array(
            'group_product_id' => $this->input->get('delete_id'),
        ));
        $this->toastr->success('Menu deleted!');
        redirect('settings/group_products');
    }

    public function unit_products()
    {
        $data['title'] = 'Pengaturan';
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_id'));
        $data['unit'] = $this->db->get('product_unit')->result_array();

        $this->form_validation->set_rules('name', 'Unit Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header', $data);
            $this->load->view('settings/unit_products', $data);
            $this->load->view('_partials/footer');
        }
        else {
            // Jika ada id berarti update
            if ($this->input->post('id')) {
                $this->db->where('unit_id', $this->input->post('id'));
                $this->db->update('product_unit', array(
                    'unit_name' => $this->input->post('name')
                ));
                $this->toastr->success('Menu updated!');
                redirect('settings/unit_products');
            }
            // sebaliknya
            else {
                $this->db->set('unit_id', 'UUID()', FALSE);
                $this->db->insert('product_unit', array(
                    'unit_name' => $this->input->post('name')
                ));
                $this->toastr->success('New group added!');
                redirect('settings/unit_products');
            }
        }
    }

    public function deleteUnit() {
        $this->db->delete('product_unit', array(
            'unit_id' => $this->input->get('delete_id'),
        ));
        $this->toastr->success('Menu deleted!');
        redirect('settings/unit_products');
    }

}