<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page6_model extends CI_Model
{
    public function getPieRasio($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $table_config_name = 'dash_config_' . $unit;
        $dash_config = $this->db->get_where($table_config_name, array('page_num' => 5, 'card_num' => 2))->result_array();
        $data = array();
        for ($i = 0; $i < sizeof($dash_config); $i++) {
            $item_floor = $dash_config[$i];
            $key = $item_floor['key'];
            $caption = $item_floor['caption'];
            $data[] = $this->db->query("
                select '$caption' as caption, cast(date_time as DATE) as date_time, avg(kw_eqv) as value from $table_name 
                where cast(date_time as DATE) = curdate() and device like '$key'
            ")->row_array();
        }

        return $data;
    }


    public function getPieElektronik($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $table_config_name = 'dash_config_' . $unit;
        $dash_config = $this->db->get_where($table_config_name, array('page_num' => 5, 'card_num' => 3))->result_array();
        $data = array();
        for ($i = 0; $i < sizeof($dash_config); $i++) {
            $item_floor = $dash_config[$i];
            $key = $item_floor['key'];
            $caption = $item_floor['caption'];
            $data[] = $this->db->query("
                select '$caption' as caption, cast(date_time as DATE) as date_time, avg(kw_eqv) as value from $table_name 
                where cast(date_time as DATE) = curdate() and device like '$key'
            ")->row_array();
        }

        return $data;
    }

    public function getPieLift($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $table_config_name = 'dash_config_' . $unit;
        $dash_config = $this->db->get_where($table_config_name, array('page_num' => 5, 'card_num' => 4))->result_array();
        $data = array();
        for ($i = 0; $i < sizeof($dash_config); $i++) {
            $item_floor = $dash_config[$i];
            $key = $item_floor['key'];
            $caption = $item_floor['caption'];
            $data[] = $this->db->query("
                select '$caption' as caption, cast(date_time as DATE) as date_time, avg(kw_eqv) as value from $table_name 
                where cast(date_time as DATE) = curdate() and device like '$key'
            ")->row_array();
        }

        return $data;
    }
}
