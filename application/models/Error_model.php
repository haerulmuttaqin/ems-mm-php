<?php

class Error_model extends CI_Model
{
    public function __construct()
    {
        $query = "SELECT a.*,  b.user_name as user_name
            FROM error_log as a
            LEFT JOIN users as b ON a.post_by = b.user_sid
            ";
        // Set table name
        $this->table =
            "(".$query.") error_log";
        // Set orderable column fields
        $this->column_order = array(null,
            'error_id',
            'message',
            'url',
            'header',
            'user_name',
            'post_date');
        // Set searchable column fields
        $this->column_search = array(
            'error_id',
            'message',
            'url',
            'header',
            'user_name',
            'post_date');
        // Set default order
        $this->order = array('post_date' => 'desc');
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

        if (intval($this->session->userdata('user_role_value')) > 1) {
            $this->db->where('user_unit', $this->session->userdata('user_unit'));
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

}
