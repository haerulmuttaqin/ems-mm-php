<?php

class Base64_model extends CI_Model
{
    public function getDataById($id) {
        return $this->db->get_where('base64_data', array('data_sid' => $id))->row_array();
    }

    public function getDataByParentId($id) {
        return $this->db->get_where('base64_data', array('parent_sid' => $id))->row_array();
    }

    public function getDataByParentIdArray($id) {
        return $this->db->get_where('base64_data', array('parent_sid' => $id))->result_array();
    }

    public function getDataByParentIdAndType($id, $type) {
        return $this->db->get_where('base64_data', array('parent_sid' => $id, 'data_type'=>$type))->result_array();
    } 
    
    public function getDataByParentIdAndTypeAndValue($id, $type, $type_value) {
        return $this->db->get_where('base64_data', array('parent_sid' => $id, 'data_type'=>$type, 'data_value'=>$type_value))->result_array();
    }
}