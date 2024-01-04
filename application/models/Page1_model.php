<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page1_model extends CI_Model
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
                            avg(kw_eqv) as value 
                        FROM $table_name
                        WHERE 
                        device LIKE '%$key%'
                        AND (YEAR(date_time) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
                        AND MONTH(date_time) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH))
                        GROUP BY DATE_FORMAT(date_time, '%Y%m');
            ")->row_array() ?: array("caption" => " $caption ");;
        }
        return $data;
    }

    public function getTableData($unit)
    {

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
                    SUM(subquery.a_avg) as ".str_replace(" ", "_", $key)."
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

        // data2 Frequency (Hz)
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
            $query_body_data2 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'Frequency (Hz)') as caption,
                  ifnull(t.".str_replace(" ", "_", $key).", null) as ".str_replace(" ", "_", $key)."
                from (select '' as date_time, 'Frequency (Hz)' caption, 0 as ".str_replace(" ", "_", $key).") a
                       left join (SELECT date_time, 'Frequency (Hz)' as caption, hz_avg as ".str_replace(" ", "_", $key)."
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_".str_replace(" ", "_", $key)."";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data2 .= ",";
                $query_body_data2 .= ",";
            }
            $num++;
        }
        $query_data2 =
            "
            select 
                $first_field_data2.date_time,
                $first_field_data2.caption,
                $query_field_data2 
            from
                $query_body_data2;
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
                  ifnull(t.".str_replace(" ", "_", $key).", null) as ".str_replace(" ", "_", $key)."
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


        // data4 Voltage Phase to Phase (V)
        $first_field_data4 = "";
        $query_field_data4 = "";
        $query_body_data4 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data4 .= "sub_".str_replace(" ", "_", $key).".".str_replace(" ", "_", $key)."";
            if ($num == 0) {
                $first_field_data4 = "sub_".str_replace(" ", "_", $key)."";
            }
            $query_body_data4 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'Voltage Phase to Phase (V)') as caption,
                  ifnull(t.".str_replace(" ", "_", $key).", null) as ".str_replace(" ", "_", $key)."
                from (select '' as date_time, 'Voltage Phase to Phase (V)' caption, 0 as ".str_replace(" ", "_", $key).") a
                       left join (SELECT date_time, 'Voltage Phase to Phase (V)' as caption, vll_avg as ".str_replace(" ", "_", $key)."
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_".str_replace(" ", "_", $key)."";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data4 .= ",";
                $query_body_data4 .= ",";
            }
            $num++;
        }
        $query_data4 =
            "
            select 
                $first_field_data4.date_time,
                $first_field_data4.caption,
                $query_field_data4 
            from
                $query_body_data4;
            ";


        // data5 THDI (%)
        $first_field_data5 = "";
        $query_field_data5 = "";
        $query_body_data5 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data5 .= "sub_".str_replace(" ", "_", $key).".".str_replace(" ", "_", $key)."";
            if ($num == 0) {
                $first_field_data5 = "sub_".str_replace(" ", "_", $key)."";
            }
            $query_body_data5 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'THDI (%)') as caption,
                  ifnull(t.".str_replace(" ", "_", $key).", null) as ".str_replace(" ", "_", $key)."
                from (select '' as date_time, 'THDI (%)' caption, 0 as ".str_replace(" ", "_", $key).") a
                       left join (SELECT date_time, 'THDI (%)' as caption, thd_avg as ".str_replace(" ", "_", $key)."
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_".str_replace(" ", "_", $key)."";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data5 .= ",";
                $query_body_data5 .= ",";
            }
            $num++;
        }
        $query_data5 =
            "
            select 
                $first_field_data5.date_time,
                $first_field_data5.caption,
                $query_field_data5 
            from
                $query_body_data5;
            ";


        // data6 Active Power EQV (kW)
        $first_field_data6 = "";
        $query_field_data6 = "";
        $query_body_data6 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data6 .= "sub_".str_replace(" ", "_", $key).".".str_replace(" ", "_", $key)."";
            if ($num == 0) {
                $first_field_data6 = "sub_".str_replace(" ", "_", $key)."";
            }
            $query_body_data6 .= "(
                    SELECT
                    date_time,
                    'Active Power EQV (kW)' as caption,
                    SUM(subquery.kw_eqv) as ".str_replace(" ", "_", $key)."
                    FROM (
                    SELECT date_time, kw_eqv
                    FROM $table_name
                    WHERE device LIKE '$key%'
                    GROUP BY device
                    ) AS subquery
            ) as sub_".str_replace(" ", "_", $key)."";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data6 .= ",";
                $query_body_data6 .= ",";
            }
            $num++;
        }
        $query_data6 =
            "
            SELECT 
                    $first_field_data6.date_time,
                    $first_field_data6.caption,
                    $query_field_data6
            FROM $query_body_data6
            ";


        // data7 Reactive Power EQV (kVAR)
        $first_field_data7 = "";
        $query_field_data7 = "";
        $query_body_data7 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data7 .= "sub_".str_replace(" ", "_", $key).".".str_replace(" ", "_", $key)."";
            if ($num == 0) {
                $first_field_data7 = "sub_".str_replace(" ", "_", $key)."";
            }
            $query_body_data7 .= "(
                    SELECT
                    date_time,
                    'Reactive Power EQV (kVAR)' as caption,
                    SUM(subquery.kvar_eqv) as ".str_replace(" ", "_", $key)."
                    FROM (
                    SELECT date_time, kvar_eqv
                    FROM $table_name
                    WHERE device LIKE '$key%'
                    GROUP BY device
                    ) AS subquery
            ) as sub_".str_replace(" ", "_", $key)."";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data7 .= ",";
                $query_body_data7 .= ",";
            }
            $num++;
        }
        $query_data7 =
            "
            SELECT 
                    $first_field_data7.date_time,
                    $first_field_data7.caption,
                    $query_field_data7
            FROM $query_body_data7
            ";


        // data8 Apparent Power EQV (kVA)
        $first_field_data8 = "";
        $query_field_data8 = "";
        $query_body_data8 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data8 .= "sub_".str_replace(" ", "_", $key).".".str_replace(" ", "_", $key)."";
            if ($num == 0) {
                $first_field_data8 = "sub_".str_replace(" ", "_", $key)."";
            }
            $query_body_data8 .= "(
                    SELECT
                    date_time,
                    'Apparent Power EQV (kVA)' as caption,
                    SUM(subquery.kva_eqv) as ".str_replace(" ", "_", $key)."
                    FROM (
                    SELECT date_time, kva_eqv
                    FROM $table_name
                    WHERE device LIKE '$key%'
                    GROUP BY device
                    ) AS subquery
            ) as sub_".str_replace(" ", "_", $key)."";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data8 .= ",";
                $query_body_data8 .= ",";
            }
            $num++;
        }
        $query_data8 =
            "
            SELECT 
                    $first_field_data8.date_time,
                    $first_field_data8.caption,
                    $query_field_data8
            FROM $query_body_data8
            ";


        //Query result
        $data1 = $this->db->query($query_data1)->result_array();
        $data2 = $this->db->query($query_data2)->result_array();
        $data3 = $this->db->query($query_data3)->result_array();
        $data4 = $this->db->query($query_data4)->result_array();
        $data5 = $this->db->query($query_data5)->result_array();
        $data6 = $this->db->query($query_data6)->result_array();
        $data7 = $this->db->query($query_data7)->result_array();
        $data8 = $this->db->query($query_data8)->result_array();

        $data['header'] = $dash_config;
        $data['body'] = array_merge($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8);
        return $data;
    }
}

//(SELECT
//kw_eqv as value_air
//FROM meter_record
//WHERE
//device LIKE '%Tata Air%'
//order by date_time desc
//LIMIT 1) as value5
