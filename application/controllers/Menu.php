<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
//        check_menu_access();
        $this->load->model('Menu_model', 'menu');

    }

    public function index()
    {
        $data['title'] = 'Master Menu';
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['menu'] = $this->menu->getMenuMaster();
        $data['menu_item'] = null;

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header', $data);
            $this->load->view('menu/index', $data);
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
    }

    public function sub($id = null)
    {
        if ($id == null) {
            redirect('menu');
        }

        $data['title'] = 'Master Menu';

        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));

        $data['menu'] = $this->menu->getMenuMaster();
        $data['submenu'] =  $this->menu->getSubmenuByMenuId($id);
        $data['menu_item'] = $this->menu->getMenuById($id);

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header', $data);
            $this->load->view('menu/index', $data);
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
    }


    public function getUpdateMenu()
    {
        echo json_encode($this->menu->getMenuById($this->input->post('id')));
    }

    public function updateMenu()
    {

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('menu');
        } else {
            $this->db->where('user_menu.menu_sid', $this->input->post('id'));
            $this->db->update('user_menu', array(
                'menu' => $this->input->post('menu'),
                'icon' => $this->input->post('icon')
            ));
            $this->toastr->success('Data updated!');
            redirect('menu');
        }
    }

    public function deleteMenu($id)
    {
        $this->menu->delete($id);
        $this->toastr->success('Data deleted!');
        redirect('menu');
    }

    /*SUBMENU*/

    public function insertSubMenu() {
        $this->db->insert('user_sub_menu', array(
            'sub_sid' => $this->uuid->sid(),
            'menu_sid' => $this->input->post('menu_id'),
            'sub' => $this->input->post('title'),
            'url' => $this->input->post('url'),
            'is_active' => $this->input->post('is_active')
        ));
        $this->toastr->success('New data added!');
        redirect('menu/sub/' . $this->input->post('menu_id'));
    }

    public function getUpdateSubmenu()
    {
        echo json_encode($this->menu->getSubmenuById($this->input->post('id')));
    }

    public function updateSubmenu()
    {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');

        if ($this->form_validation->run() == FALSE) {
            redirect('menu/sub/' . $this->input->post('menu_id'));
        } else {
            $this->db->where('user_sub_menu.sub_sid', $this->input->post('id'));
            $this->db->update('user_sub_menu', array(
                'menu_sid' => $this->input->post('menu_id'),
                'sub' => $this->input->post('title'),
                'url' => $this->input->post('url'),
                'is_active' => $this->input->post('is_active')
            ));
            $this->toastr->success('Data updated!');
            redirect('menu/sub/' . $this->input->post('menu_id'));
        }
    }

    public function deleteSubmenu($id, $id_menu)
    {
        $this->menu->deleteSubmenu($id);
        $this->toastr->success('Data deleted!');
        redirect('menu/sub/' . $id_menu);
    }

    public function upMenu($id) {
        $menu_sort = $this->menu->getMenuById($id);
        $menu_sort_ref = $menu_sort['sort'] - 1;
        $menu = $this->db->get_where('user_menu', array('sort' => $menu_sort_ref))->row_array();
        $this->updateDown($menu['menu_sid']);
        $this->updateUp($id);
        $this->toastr->success('Data updated!');
        redirect('menu/sub/' . $id);
    }

    public function downMenu($id) {
        $menu_sort = $this->menu->getMenuById($id);
        $menu_sort_ref = $menu_sort['sort'] + 1;
        $menu = $this->db->get_where('user_menu', array('sort' => $menu_sort_ref))->row_array();
        $this->updateUp2($id);
        $this->updateDown2($menu['menu_sid']);
        $this->toastr->success('Data updated!');
        redirect('menu/sub/' . $id);
    }

    private function updateUp($id) {
        $menu = $this->menu->getMenuById($id);
        $this->db->where('user_menu.menu_sid', $id);
        $this->db->update('user_menu', array(
            'sort' => $menu['sort'] - 1
        ));
    }

    private function updateDown($id) {
        $menu = $this->menu->getMenuById($id);
        $this->db->where('user_menu.menu_sid', $id);
        $this->db->update('user_menu', array(
            'sort' => $menu['sort'] + 1
        ));
    }

    private function updateUp2($id) {
        $menu = $this->menu->getMenuById($id);
        $this->db->where('user_menu.menu_sid', $id);
        $this->db->update('user_menu', array(
            'sort' => $menu['sort'] + 1
        ));
    }

    private function updateDown2($id) {
        $menu = $this->menu->getMenuById($id);
        $this->db->where('user_menu.menu_sid', $id);
        $this->db->update('user_menu', array(
            'sort' => $menu['sort'] - 1
        ));
    }


    //sub
    public function updateSubMenuOrder() {
        $pos = $this->input->post('position');
        $i = 1;
        foreach ($pos as $k=>$v) {
            $this->db->where('user_sub_menu.sub_sid', $v);
            $this->db->update('user_sub_menu', array(
                'sort' => $i
            ));
            $i++;
        }
    }

    public function set_sidebar_state() {
        $state = $this->session->userdata('sidebar_state');
        if ($state == NULL || $state == '' || $state == 'sidebar-open') {
            $array = array(
                'sidebar_state' => 'sidebar-collapse'
            );
        } else {
            $array = array(
                'sidebar_state' => 'sidebar-open'
            );
        }
        $this->session->set_userdata($array);
    }

    public function getAllMenu() {
        return json_encode($this->menu->getMenu());
    }


}