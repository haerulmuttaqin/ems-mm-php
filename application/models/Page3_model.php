<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page3_model extends CI_Model
{

    public function getFloor($unit)
    {
        $table_config_name = 'dash_config_' . $unit;
        return $this->db->query("select * from $table_config_name where page_num = 3 and card_num = 1 order by cast(remark as unsigned) asc")->result_array();
    }

    public function getChartData($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();

        $floor = $this->getFloor($unit);
        for ($i = 0; $i < sizeof($floor) ; $i++) {
            $item_floor = $floor[$i];
            $key = $item_floor['key'];
            $caption = $item_floor['caption'];
            $data[] = $this->db->query("
                select '$caption' as caption, cast(date_time as DATE) as date_time, avg(kw_eqv) as value from $table_name 
                where cast(date_time as DATE) = curdate() and device like '%$key'
            ")->row_array();
        }

        return $data;
    }

    public function getPieTegangan($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();

        $floor = $this->getFloor($unit);
        for ($i = 0; $i < sizeof($floor) ; $i++) {
            $item_floor = $floor[$i];
            $key = $item_floor['key'];
            $caption = $item_floor['caption'];
            $data[] = $this->db->query("
                select '$caption' as caption, cast(date_time as DATE) as date_time, avg(vll_avg) as value from $table_name 
                where cast(date_time as DATE) = curdate() and device like '%$key'
            ")->row_array();
        }

        return $data;
    }

    public function getPieArus($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();

        $floor = $this->getFloor($unit);
        for ($i = 0; $i < sizeof($floor) ; $i++) {
            $item_floor = $floor[$i];
            $key = $item_floor['key'];
            $caption = $item_floor['caption'];
            $data[] = $this->db->query("
                select '$caption' as caption, cast(date_time as DATE) as date_time, avg(a_avg) as value from $table_name 
                where cast(date_time as DATE) = curdate() and device like '%$key'
            ")->row_array();
        }

        return $data;
    }

    public function getPiePf($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();

        $floor = $this->getFloor($unit);
        for ($i = 0; $i < sizeof($floor) ; $i++) {
            $item_floor = $floor[$i];
            $key = $item_floor['key'];
            $caption = $item_floor['caption'];
            $data[] = $this->db->query("
                select '$caption' as caption, cast(date_time as DATE) as date_time, avg(pf_avg) as value from $table_name 
                where cast(date_time as DATE) = curdate() and device like '%$key'
            ")->row_array();
        }

        return $data;
    }
}

//(SELECT
//kw_eqv as value_air
//FROM $table_name
//WHERE
//device LIKE '%Tata Air%'
//order by date_time desc
//LIMIT 1) as value5
