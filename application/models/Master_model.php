<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_model extends CI_Model
{
    public function getMapper($unit)
    {
        $this->db->select('*');
        $this->db->from('meter_mapper_'.$unit);
        return $this->db->get()->result_array();
    }

    public function getCategory()
    {
        $this->db->select('a.*, b.category_name as parent_name, b.category_sid as parent_sid');
        $this->db->from('generic_category a');
        $this->db->join('generic_category b', 'b.category_sid = a.parent_sid', 'left');
        $this->db->group_by('a.category_sid');
        $this->db->group_by('b.category_sid');
        $this->db->group_by('b.category_name');
        $this->db->order_by('sort', 'asc');
        return $this->db->get()->result_array();
    }

    public function getCategoryById($id)
    {
        $this->db->where('category_sid', $id);
        return $this->db->get('generic_category')->result_row();
    }

    public function getGenericByCategory($id)
    {
        $this->db->select('a.*, b.ref_name as parent_name');
        $this->db->from('generic_references a');
        $this->db->join('generic_references b', 'a.parent_sid = b.ref_sid', 'left');
        $this->db->where('a.category_sid', $id);
        $this->db->order_by('a.ref_value', 'asc');
        return $this->db->get()->result_array();
    }

    public function getGenericBySid($id)
    {
        $this->db->where('ref.ref_sid', $id);
        return $this->db->get('generic_references as ref')->row_array();
    }

    public function getGenericByCategoryAndName($category, $name)
    {
        $this->db->select('a.*, c.ref_name as parent_name');
        $this->db->from('generic_references a');
        $this->db->join('generic_category b', 'a.category_sid = b.category_sid', 'left');
        $this->db->join('generic_references c', 'a.parent_sid = c.ref_sid', 'left');
        $this->db->where('b.category_name', $category);
        $this->db->like('a.ref_name', $name);
        return $this->db->get()->row_array();
    }

    public function getGenericByCategoryName($name)
    {
        if ($name == 'ULP') {
            $ulp_user = get_ulp_user();
            $this->db->select('a.*, c.ref_name as parent_name');
            $this->db->from('generic_references a');
            $this->db->join('generic_category b', 'a.category_sid = b.category_sid', 'left');
            $this->db->join('generic_references c', 'a.parent_sid = c.ref_sid', 'left');
            $this->db->join('generic_references d', 'c.parent_sid = d.ref_sid', 'left');
            $this->db->where('b.category_name', $name);
            if (intval($ulp_user['ref_value']) == 1) {
                $this->db->where('c.ref_sid', $ulp_user['parent_sid']);
            } else if (intval($ulp_user['ref_value']) == 0 && intval($this->session->userdata('user_role_value')) == 2) { //jika ulp yg login di level 0 / level ulp && role nya = admin up3
                $this->db->where('c.ref_sid', $ulp_user['parent_sid']); // sesuaikan dengan up3 nya
            } else if (intval($ulp_user['ref_value']) == 0 && intval($this->session->userdata('user_role_value')) == 1) { //jika ulp yg login di level 0 / level ulp && role nya = admin uid
                $this->db->where('d.ref_sid', $this->session->userdata('user_uiw')); // sesuaikan dengan wilayah nya
            } else if (intval($ulp_user['ref_value']) == 0) {
                $this->db->where('a.ref_sid', $ulp_user['ref_sid']);
            }
            $this->db->order_by('a.ref_value', 'asc');
            $this->db->order_by('c.ref_name', 'asc');
            return $this->db->get()->result_array();
        } else if ($name == 'USER ROLE') {
            $this->db->select('a.*, c.ref_name as parent_name');
            $this->db->from('generic_references a');
            $this->db->join('generic_category b', 'a.category_sid = b.category_sid', 'left');
            $this->db->join('generic_references c', 'a.parent_sid = c.ref_sid', 'left');
            $this->db->where('b.category_name', $name);
            if (intval($this->session->userdata('user_role_value')) == 1) {
                $this->db->where('a.ref_value >', 1);
            } else if (intval($this->session->userdata('user_role_value')) == 2) {
                $this->db->where('a.ref_value >=', 2);
            } else if (intval($this->session->userdata('user_role_value')) == 3) {
                $this->db->where('a.ref_value >=', 3);
            }
            $this->db->order_by('a.ref_value', 'asc');
            $this->db->order_by('c.ref_name', 'asc');
            return $this->db->get()->result_array();
        } else {
            $this->db->select('a.*, c.ref_name as parent_name');
            $this->db->from('generic_references a');
            $this->db->join('generic_category b', 'a.category_sid = b.category_sid', 'left');
            $this->db->join('generic_references c', 'a.parent_sid = c.ref_sid', 'left');
            $this->db->where('b.category_name', $name);
            $this->db->order_by('a.ref_value', 'asc');
            $this->db->order_by('c.ref_name', 'asc');
            return $this->db->get()->result_array();
        }
    }

    public function getGenericByCategoryNameAndValue($name, $val)
    {
        $this->db->select('a.*, c.ref_name as parent_name');
        $this->db->from('generic_references a');
        $this->db->join('generic_category b', 'a.category_sid = b.category_sid', 'left');
        $this->db->join('generic_references c', 'a.parent_sid = c.ref_sid', 'left');
        $this->db->where('b.category_name', $name);
        $this->db->where('a.ref_value', $val);
        return $this->db->get()->row_array();
    }

    public function getGenericByParent($parent)
    {
        $this->db->select('a.*, c.ref_name as parent_name');
        $this->db->from('generic_references a');
        $this->db->join('generic_category b', 'a.category_sid = b.category_sid', 'left');
        $this->db->join('generic_references c', 'a.parent_sid = c.ref_sid', 'left');
        $this->db->where('c.ref_sid', $parent);
        $this->db->order_by('a.ref_value', 'asc');
        $this->db->order_by('c.ref_name', 'asc');
        return $this->db->get()->result_array();
    }

    public function getGenericByParentName($parent)
    {
        $this->db->select('a.*, c.ref_name as parent_name');
        $this->db->from('generic_references a');
        $this->db->join('generic_category b', 'a.category_sid = b.category_sid', 'left');
        $this->db->join('generic_references c', 'a.parent_sid = c.ref_sid', 'left');
        $this->db->where('c.ref_name', $parent);
        $this->db->order_by('a.ref_value', 'asc');
        $this->db->order_by('c.ref_name', 'asc');
        return $this->db->get()->result_array();
    }

    public function getRoles()
    {
        $this->db->select('a.*');
        $this->db->from('generic_references a');
        $this->db->join('generic_category b', 'a.category_sid = b.category_sid', 'left');
        $this->db->where('b.category_name', 'USER ROLE');
        $this->db->where('a.ref_value <=', 3);
        $this->db->order_by('a.date_created', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getRolesClient()
    {
        $this->db->select('a.*');
        $this->db->from('generic_references a');
        $this->db->join('generic_category b', 'a.category_sid = b.category_sid', 'left');
        $this->db->where('b.category_name', 'USER ROLE');
        $this->db->where('a.ref_value !=', 0);
        $this->db->order_by('a.ref_value', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getUserRoles($id)
    {
        $this->db->where('ur_user_sid', $id);
        return $this->db->get('users_roles')->result_array();
    }

    public function getUserRolesJoin($id)
    {
        $this->db->select('*');
        $this->db->from('users_roles');
        $this->db->join('generic_references', 'users_roles.ur_role_sid = generic_references.ref_sid', 'left');
        $this->db->where('ur_user_sid', $id);
        return $this->db->get()->result_array();
    }

    public function getBillingConfig()
    {
        $this->db->select('*');
        $this->db->from('billing_config');
        return $this->db->get()->row_array();
    }

    public function updateBillingConfig($data)
    {
        $this->db->update('billing_config', $data);
    }
}
