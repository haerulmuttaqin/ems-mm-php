<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page7_model extends CI_Model
{

    public function getPieCartData($unit)
    {
        $table_config_name = 'dash_config_' . $unit;
        $dash_config = $this->db->get_where($table_config_name, array('page_num' => 1, 'card_num' => 1))->result_array();
        $table_name = 'meter_record_' . $unit;
        $data = array();

        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $caption = $cfg['caption'];
            $data[] = $this->db->query("
                        SELECT 
                            date_time,
                            mea as measurement, 
                            '$key' as type, 
                            ' $caption ' as caption,
                            COALESCE(AVG(kw_eqv), 0) as value 
                        FROM $table_name
                        WHERE 
                        device LIKE '%$key%'
                        ORDER by date_time desc LIMIT 1;
            ")->row_array() ?: array("caption" => " $caption ");;
        }
        return $data;
    }

    public function getCartData($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();
        $table_config_name = 'dash_config_' . $unit;
        $dash_config = $this->db->get_where($table_config_name, array('page_num' => 2, 'card_num' => 1))->row_array();
        $key = $dash_config['key'];
        $data['today'] = $this->db->query("
                SELECT date_time, concat(date_format(date_time, '%H'), ':00')  as hour, kw_eqv as value from $table_name
                where device like '%$key%' and cast(date_time as DATE) = curdate()  
                group by date_format(date_time, '%H');
                ")->result_array();

        $data['lastday'] = $this->db->query("
                SELECT date_time, concat(date_format(date_time, '%H'), ':00')  as hour, kw_eqv as value from $table_name
                where device like '%$key%' and cast(date_time as DATE) = (curdate() - interval 1 day)
                group by date_format(date_time, '%H');
                ")->result_array();
        return $data;
    }

    public function getTableData($unit)
    {
        $table_name = 'meter_record_' . $unit;

        // data1 Current Avg (I)
        $table_config_name = 'dash_config_' . $unit;
        $dash_config = $this->db->get_where($table_config_name, array('page_num' => 1, 'card_num' => 2))->result_array();
        $table_name = 'meter_record_' . $unit;

        $first_field_data1 = "";
        $query_field_data1 = "";
        $query_body_data1 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data1 .= "sub_".str_replace(" ", "_", $key).".".str_replace(" ", "_", $key)."";
            if ($num == 0) {
                $first_field_data1 = "sub_".str_replace(" ", "_", $key)."";
            }
            $query_body_data1 .= "(
                    SELECT
                    date_time,
                    'Current Avg (I)' as caption,
                    COALESCE(SUM(subquery.a_avg), 0) as ".str_replace(" ", "_", $key)."
                    FROM (
                    SELECT date_time, a_avg
                    FROM $table_name
                    WHERE device LIKE '$key%'
                    GROUP BY device
                    ) AS subquery
            ) as sub_".str_replace(" ", "_", $key)."";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data1 .= ",";
                $query_body_data1 .= ",";
            }
            $num++;
        }
        // data1 Current Avg (I)
        $query_data1 =
            "
            SELECT 
                    $first_field_data1.date_time,
                    $first_field_data1.caption,
                    $query_field_data1
            FROM $query_body_data1
            ";

        $first_field_data2 = "";
        $query_field_data2 = "";
        $query_body_data2 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data2 .= "sub_".str_replace(" ", "_", $key).".".str_replace(" ", "_", $key)."";
            if ($num == 0) {
                $first_field_data2 = "sub_".str_replace(" ", "_", $key)."";
            }
            $query_body_data2 .= "(
                    SELECT
                    date_time,
                    'Active Power EQV (kW)' as caption,
                    COALESCE(SUM(subquery.kw_eqv), 0) as ".str_replace(" ", "_", $key)."
                    FROM (
                    SELECT date_time, kw_eqv
                    FROM $table_name
                    WHERE device LIKE '$key%'
                    GROUP BY device
                    ) AS subquery
            ) as sub_".str_replace(" ", "_", $key)."";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data2 .= ",";
                $query_body_data2 .= ",";
            }
            $num++;
        }
        $query_data2 =
            "
            SELECT 
                    $first_field_data2.date_time,
                    $first_field_data2.caption,
                    $query_field_data2
            FROM $query_body_data2
            ";


        // data3 Power Factor
        $first_field_data3 = "";
        $query_field_data3 = "";
        $query_body_data3 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data3 .= "sub_".str_replace(" ", "_", $key).".".str_replace(" ", "_", $key)."";
            if ($num == 0) {
                $first_field_data3 = "sub_".str_replace(" ", "_", $key)."";
            }
            $query_body_data3 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'Power Factor') as caption,
                  ifnull(t.".str_replace(" ", "_", $key).", 0) as ".str_replace(" ", "_", $key)."
                from (select '' as date_time, 'Power Factor' caption, 0 as ".str_replace(" ", "_", $key).") a
                       left join (SELECT date_time, 'Power Factor' as caption, pf_avg as ".str_replace(" ", "_", $key)."
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_".str_replace(" ", "_", $key)."";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data3 .= ",";
                $query_body_data3 .= ",";
            }
            $num++;
        }
        $query_data3 =
            "
            select 
                $first_field_data3.date_time,
                $first_field_data3.caption,
                $query_field_data3 
            from
                $query_body_data3;
            ";



        //Query result
        $data1 = $this->db->query($query_data1)->result_array();
        $data2 = $this->db->query($query_data2)->result_array();
        $data3 = $this->db->query($query_data3)->result_array();

        $data['header'] = $dash_config;
        $data['body'] = array_merge($data1, $data2, $data3);
        return $data;
    }
}