<?php

class User_model extends CI_Model
{
    public function __construct()
    {
        $query = "SELECT a.*,
            b.ref_name as unit,
            c.ref_name as hak,
            c.ref_value as role_value,
            d.ref_description as parent_name,
            d.ref_sid as parent_sid,
            e.ref_value as role_val
            FROM users as a
            INNER JOIN users_roles as role ON a.user_sid = role.ur_user_sid
            LEFT JOIN generic_references as b ON a.user_unit = b.ref_sid
            LEFT JOIN generic_references as c ON a.user_role_sid = c.ref_sid
            LEFT JOIN generic_references as d ON b.parent_sid = d.ref_sid
            LEFT JOIN generic_references as e ON role.ur_role_sid = e.ref_sid
            ";
        // Set table name
        $this->table =
            "(".$query.") users";
        // Set orderable column fields
        $this->column_order = array(null,
            'user_uid',
            'user_no_induk',
            'user_name',
            'unit',
            'hak',
            'is_active',
            'last_login',
            'last_connect',
            'user_sid',
            'user_role_sid');
        // Set searchable column fields
        $this->column_search = array(
            'user_uid',
            'user_no_induk',
            'user_name',
            'unit',
            'hak',
            'is_active',
            'last_login',
            'last_connect',
            'user_sid',
            'user_role_sid');
        // Set default order
        $this->order = array('last_connect' => 'desc');
    }

    public function getUsers()
    {
        $this->db->select('a.*');
        $this->db->from('users a');
        $this->db->join('generic_references b', 'a.user_role_sid = b.ref_sid', 'left');
        return $this->db->get()->result_array();
    }

    public function getUserRegion()
    {
        $this->db->select('*');
        $this->db->from('generic_references');
        $this->db->join('generic_category', 'generic_category.category_sid = generic_references.category_sid', 'left');
        $this->db->where('generic_category.category_name', 'ULP');
        return $this->db->get()->result_array();
    }

    public function getRows($postData, $role = NULL, $region = NULL)
    {
        $this->_get_datatables_query($postData, $role, $region);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countAll()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function countFiltered($postData, $role = NULL, $region = NULL)
    {
        $this->_get_datatables_query($postData, $role, $region);
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _get_datatables_query($postData)
    {

        $this->db->from($this->table);

        if (intval($this->session->userdata('user_role_value')) > 0) { // level uid
            // $this->db->where('parent_sid', $this->session->userdata('user_up3'));
            $this->db->where('role_val >', 1);
        }

        if (intval($this->session->userdata('user_role_value')) > 1) { // level up3
            $this->db->where('parent_sid', $this->session->userdata('user_up3'));
            $this->db->where('role_val >', 2);
        }
        
        if (intval($this->session->userdata('user_role_value')) > 2) { // level ulp
            $this->db->where('user_unit', $this->session->userdata('user_unit'));
            $this->db->where('role_val >', 3);
        }

        $i = 0;
        // loop searchable columns
        foreach ($this->column_search as $item) {
            // if datatable send POST for search
            if ($postData['search']['value']) {
                // first loop
                if ($i === 0) {
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }

                // last loop
                if (count($this->column_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getUser()
    {
        return $this->db->get_where('users', array(
            'user_email' => $this->session->userdata('user_email')
        ))->row_array();
    }

    public function getUserByEmail($email)
{
    return $this->db->get_where('users', array(
        'user_email' => $email
    ))->row_array();
}

    public function getUserByUsername($uname)
    {
        return $this->db->get_where('users', array(
            'user_login_name' => $uname
        ))->row_array();
    }

    public function getUserById($id)
    {
        $this->db->select('*, users.date_created, users.date_modified, 
                                role.ref_sid role_sid,
                                role.ref_name role_name,
                                role.ref_value role_value');
        $this->db->from('users');
        $this->db->join('generic_references role', 'users.user_role_sid = role.ref_sid', 'left');
        $this->db->where('user_sid', $id);
        return $this->db->get()->row_array();
    }

    public function getUserSidByAuth($id)
    {
        $this->db->select('*');
        $this->db->from('user_token');
        $this->db->where('auth_token', $id);
        return $this->db->get()->row_array();
    }

    public function get_no_user(){
        $q = $this->db->query("SELECT MAX(RIGHT(user_uid,4)) AS kd_max FROM users");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        return date('ymd', time()).'-'.$kd;
    }

    public function get_user_admin_allregion() {
        $query = "select user_email, user_name, ref.ref_name from users
                    inner join users_roles on users.user_sid = users_roles.ur_user_sid
                    inner join generic_references ref on users_roles.ur_role_sid = ref.ref_sid
                where ref.ref_value <= 1";
        return $this->db->query($query)->result_array();
    }

}
