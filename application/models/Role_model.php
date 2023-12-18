<?php


class Role_model extends CI_Model
{
    public function deleteRole($id)
    {
        $this->db->where('generic_references.ref_sid', $id);
        $this->db->delete('generic_references');
    }

    public function getRoleById($role_id)
    {
        return $this->db->get_where('generic_references', ['ref_sid' => $role_id])->row_array();
    }
}