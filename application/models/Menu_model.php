<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function getMenuMaster()
    {
        $queryMenu = "SELECT user_menu.menu_sid, menu, user_menu.icon
                        FROM user_menu
                   left join user_sub_menu 
                          on user_menu.menu_sid = user_sub_menu.menu_sid
                   left join user_access_menu 
                          on user_sub_menu.sub_sid = user_access_menu.menu_sid
                    group by user_menu.menu_sid
                    order by user_menu.sort asc";
        return $this->db->query($queryMenu)->result_array();
    }

    public function getMenu()
    {
        $role_id = $this->session->userdata('user_role_sid');
        $queryMenu = "SELECT user_menu.menu_sid, menu, user_menu.icon
                        FROM user_menu
                   left join user_sub_menu 
                          on user_menu.menu_sid = user_sub_menu.menu_sid
                   left join user_access_menu 
                          on user_sub_menu.sub_sid = user_access_menu.menu_sid
                       where user_access_menu.role_sid = '$role_id'
                    group by user_menu.menu_sid
                    order by user_menu.sort asc";
        return $this->db->query($queryMenu)->result_array();
    }

    public function getSubMenu()
    {
        $query = "SELECT user_sub_menu.*, user_menu.menu
                    FROM user_sub_menu JOIN user_menu
                      ON user_sub_menu.menu_sid = user_menu.menu_sid";
        return $this->db->query($query)->result_array();
    }

    public function getMenuById($id)
    {
        return $this->db->get_where('user_menu', ['menu_sid' => $id])->row_array();
    }

    public function delete($id)
    {
        $this->db->where('user_menu.menu_sid', $id);
        $this->db->delete('user_menu', ['menu_sid' => $id]);
    }

    public function getSubmenuById($id)
    {
        $query = "SELECT user_sub_menu.*, user_menu.menu
                    FROM user_sub_menu JOIN user_menu
                      ON user_sub_menu.menu_sid = user_menu.menu_sid
                   WHERE user_sub_menu.sub_sid = '$id'";
        return $this->db->query($query)->row_array();
    }

    public function getSubmenuByIdAndMenuId($id, $menu)
    {
        $query = "SELECT user_sub_menu.*, user_menu.menu
                    FROM user_sub_menu JOIN user_menu
                      ON user_sub_menu.menu_sid = user_menu.menu_sid
                   WHERE user_sub_menu.sub_sid = '$id' AND user_menu.menu_sid = '$menu'";
        return $this->db->query($query)->row_array();
    }

    public function getSubmenuByMenuId($id)
    {
        $query = "SELECT user_sub_menu.*, user_menu.menu
                    FROM user_sub_menu JOIN user_menu
                      ON user_sub_menu.menu_sid = user_menu.menu_sid
                   WHERE user_sub_menu.menu_sid = '$id' ORDER BY user_sub_menu.sort ASC ";
        return $this->db->query($query)->result_array();
    }

    public function deleteSubmenu($id)
    {
        $this->db->where('user_sub_menu.sub_sid', $id);
        $this->db->delete('user_sub_menu');
        return;
    }

}