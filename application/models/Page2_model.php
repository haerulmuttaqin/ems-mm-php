<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page2_model extends CI_Model
{
    public function getChartData($unit)
    {
        /**
         * mm - (LVMDP C1, LVMDP C2, LVMDP 28)
         * a1 - (PHBUTR)
         * a2 - (Panel Utama - LVMDB)
         **/

        $table_config_name = 'dash_config_' . $unit;
        $dash_config = $this->db->get_where($table_config_name, array('page_num' => 2, 'card_num' => 1))->row_array();
        $table_name = 'meter_record_' . $unit;
        $key = $dash_config['key'];

        $data = array();
        $data['chart1_this_week'] = $this->db->query("
                select (case
                        when date_format(summary.date_time,'%w') = 0 THEN 'Minggu'
                        when date_format(summary.date_time,'%w') = 1 THEN 'Senin'
                        when date_format(summary.date_time,'%w') = 2 THEN 'Selasa'
                        when date_format(summary.date_time,'%w') = 3 THEN 'Rabu'
                        when date_format(summary.date_time,'%w') = 4 THEN 'Kamis'
                        when date_format(summary.date_time,'%w') = 5 THEN 'Jum`at'
                        when date_format(summary.date_time,'%w') = 6 THEN 'Sabtu'
                        end) as date_time, 
                       round(sum(value), 1) as value
                from (
                    select date_time, device, avg(kw_eqv) as value from $table_name
                    where device like '%$key%'
                    and cast(date_time as DATE) BETWEEN (SELECT DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY)) and NOW() - INTERVAL 1 day
                    group by cast(date_time as DATE), device 
                ) as summary group by cast(date_time as DATE)
        ")->result_array();

        $data['chart1_last_week'] = $this->db->query("
                select (case
                        when date_format(summary.date_time,'%w') = 0 THEN 'Minggu'
                        when date_format(summary.date_time,'%w') = 1 THEN 'Senin'
                        when date_format(summary.date_time,'%w') = 2 THEN 'Selasa'
                        when date_format(summary.date_time,'%w') = 3 THEN 'Rabu'
                        when date_format(summary.date_time,'%w') = 4 THEN 'Kamis'
                        when date_format(summary.date_time,'%w') = 5 THEN 'Jum`at'
                        when date_format(summary.date_time,'%w') = 6 THEN 'Sabtu'
                        end) as date_time, 
                       round(sum(value), 1) as value
                from (
                    select date_time, device, avg(kw_eqv) as value from $table_name
                    where device like '%$key%'
                    and cast(date_time as DATE) BETWEEN (SELECT DATE_ADD(DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY), INTERVAL - 1 WEEK)) 
                    and (SELECT DATE_ADD(DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY), INTERVAL - 1 DAY))
                    group by cast(date_time as DATE), device 
                ) as summary group by cast(date_time as DATE)
        ")->result_array();


        $data['chart2_last_month'] = $this->db->query("
                select date_format(summary.date_time, '%d') as date_time, round(sum(value), 1) as value
                from (
                        select date_time, device, avg(kw_eqv) as value from $table_name
                        where device like '%$key%'
                        and cast(date_time as DATE) BETWEEN (DATE_SUB(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)),INTERVAL DAY(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)))-1 DAY)) 
                        and (LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH))) 
                        group by cast(date_time as DATE), device 
                    ) as summary
                group by cast(summary.date_time as DATE)
        ")->result_array();

        $data['chart2_this_month'] = $this->db->query("
                select date_format(summary.date_time, '%d') as date_time, round(sum(value), 1) as value
                from (
                        select date_time, device, avg(kw_eqv) as value from $table_name
                        where device like '%$key%'
                        and cast(date_time as DATE) BETWEEN (DATE_ADD(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)), INTERVAL 1 DAY)) and NOW() - INTERVAL 1 DAY
                        group by cast(date_time as DATE), device 
                    ) as summary
                group by cast(summary.date_time as DATE)
        ")->result_array();

        $data['chart3_last_7days'] = $this->db->query("
            select 
                (case
                    when date_format(summary.date_time,'%w') = 0 THEN 'Minggu'
                    when date_format(summary.date_time,'%w') = 1 THEN 'Senin'
                    when date_format(summary.date_time,'%w') = 2 THEN 'Selasa'
                    when date_format(summary.date_time,'%w') = 3 THEN 'Rabu'
                    when date_format(summary.date_time,'%w') = 4 THEN 'Kamis'
                    when date_format(summary.date_time,'%w') = 5 THEN 'Jum`at'
                    when date_format(summary.date_time,'%w') = 6 THEN 'Sabtu'
                    end) as date_time,
                date_time as date,
                round(sum(summary.value), 1) as value 
            from (
                select date_time, device, avg(kw_eqv) as value from $table_name
                where device like '%$key%'
                and cast(date_time as DATE) BETWEEN (DATE_SUB(CURDATE(), INTERVAL 13 DAY)) and (DATE_SUB(CURDATE(), INTERVAL 7 DAY))
                group by cast(date_time as DATE), device 
            ) as summary
            group by cast(summary.date_time as DATE)
        ")->result_array();

        $data['chart3_this_7days'] = $this->db->query("
            select 
                (case
                    when date_format(summary.date_time,'%w') = 0 THEN 'Minggu'
                    when date_format(summary.date_time,'%w') = 1 THEN 'Senin'
                    when date_format(summary.date_time,'%w') = 2 THEN 'Selasa'
                    when date_format(summary.date_time,'%w') = 3 THEN 'Rabu'
                    when date_format(summary.date_time,'%w') = 4 THEN 'Kamis'
                    when date_format(summary.date_time,'%w') = 5 THEN 'Jum`at'
                    when date_format(summary.date_time,'%w') = 6 THEN 'Sabtu'
                    end) as date_time,
                date_time as date,
                round(sum(summary.value), 1) as value 
            from (
                select date_time, device, avg(kw_eqv) as value from $table_name
                where device like '%$key%'
                and cast(date_time as DATE) BETWEEN (DATE_SUB(CURDATE(), INTERVAL 6 DAY)) and NOW()
                group by cast(date_time as DATE), device 
            ) as summary
            group by cast(summary.date_time as DATE)
        ")->result_array();

        return $data;
    }

    public function getTableData($unit)
    {
        $table_config_name = 'dash_config_' . $unit;
        $dash_config = $this->db->get_where($table_config_name, array('page_num' => 2, 'card_num' => 2))->result_array();
        $table_name = 'meter_record_' . $unit;

        // data1 Current Avg (I)
        $first_field_data1 = "";
        $query_field_data1 = "";
        $query_body_data1 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data1 .= "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "." . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num == 0) {
                $first_field_data1 = "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            }
            $query_body_data1 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'Current Avg (I)') as caption,
                  ifnull(t." . str_replace(" ", "_", str_replace("-", "_", $key)) . ", null) as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                from (select '' as date_time, 'Current Avg (I)' caption, 0 as " . str_replace(" ", "_", str_replace("-", "_", $key)) . ") a
                       left join (SELECT date_time, 'Current Avg (I)' as caption, a_avg as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data1 .= ",";
                $query_body_data1 .= ",";
            }
            $num++;
        }
        $query_data1 =
            "
            select 
                $first_field_data1.date_time,
                $first_field_data1.caption,
                $query_field_data1 
            from
                $query_body_data1;
            ";


        // data2 Frequency (Hz)
        $first_field_data2 = "";
        $query_field_data2 = "";
        $query_body_data2 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data2 .= "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "." . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num == 0) {
                $first_field_data2 = "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            }
            $query_body_data2 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'Frequency (Hz)') as caption,
                  ifnull(t." . str_replace(" ", "_", str_replace("-", "_", $key)) . ", null) as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                from (select '' as date_time, 'Frequency (Hz)' caption, 0 as " . str_replace(" ", "_", str_replace("-", "_", $key)) . ") a
                       left join (SELECT date_time, 'Frequency (Hz)' as caption, hz_avg as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
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
            $query_field_data3 .= "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "." . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num == 0) {
                $first_field_data3 = "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            }
            $query_body_data3 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'Power Factor') as caption,
                  ifnull(t." . str_replace(" ", "_", str_replace("-", "_", $key)) . ", null) as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                from (select '' as date_time, 'Power Factor' caption, 0 as " . str_replace(" ", "_", str_replace("-", "_", $key)) . ") a
                       left join (SELECT date_time, 'Power Factor' as caption, pf_avg as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
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
            $query_field_data4 .= "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "." . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num == 0) {
                $first_field_data4 = "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            }
            $query_body_data4 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'Voltage Phase to Phase (V)') as caption,
                  ifnull(t." . str_replace(" ", "_", str_replace("-", "_", $key)) . ", null) as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                from (select '' as date_time, 'Voltage Phase to Phase (V)' caption, 0 as " . str_replace(" ", "_", str_replace("-", "_", $key)) . ") a
                       left join (SELECT date_time, 'Voltage Phase to Phase (V)' as caption, vll_avg as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
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
            $query_field_data5 .= "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "." . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num == 0) {
                $first_field_data5 = "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            }
            $query_body_data5 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'THDI (%)') as caption,
                  ifnull(t." . str_replace(" ", "_", str_replace("-", "_", $key)) . ", null) as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                from (select '' as date_time, 'THDI (%)' caption, 0 as " . str_replace(" ", "_", str_replace("-", "_", $key)) . ") a
                       left join (SELECT date_time, 'THDI (%)' as caption, thd_avg as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
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
            $query_field_data6 .= "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "." . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num == 0) {
                $first_field_data6 = "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            }
            $query_body_data6 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'Active Power EQV (kW)') as caption,
                  ifnull(t." . str_replace(" ", "_", str_replace("-", "_", $key)) . ", null) as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                from (select '' as date_time, 'Active Power EQV (kW)' caption, 0 as " . str_replace(" ", "_", str_replace("-", "_", $key)) . ") a
                       left join (SELECT date_time, 'Active Power EQV (kW)' as caption, kw_eqv as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data6 .= ",";
                $query_body_data6 .= ",";
            }
            $num++;
        }
        $query_data6 =
            "
            select 
                $first_field_data6.date_time,
                $first_field_data6.caption,
                $query_field_data6 
            from
                $query_body_data6;
            ";


        // data7 Reactive Power EQV (kVAR)
        $first_field_data7 = "";
        $query_field_data7 = "";
        $query_body_data7 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data7 .= "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "." . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num == 0) {
                $first_field_data7 = "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            }
            $query_body_data7 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'Reactive Power EQV (kVAR)') as caption,
                  ifnull(t." . str_replace(" ", "_", str_replace("-", "_", $key)) . ", null) as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                from (select '' as date_time, 'Reactive Power EQV (kVAR)' caption, 0 as " . str_replace(" ", "_", str_replace("-", "_", $key)) . ") a
                       left join (SELECT date_time, 'Reactive Power EQV (kVAR)' as caption, kvar_eqv as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data7 .= ",";
                $query_body_data7 .= ",";
            }
            $num++;
        }
        $query_data7 =
            "
            select 
                $first_field_data7.date_time,
                $first_field_data7.caption,
                $query_field_data7 
            from
                $query_body_data7;
            ";


        // data8 Apparent Power EQV (kVA)
        $first_field_data8 = "";
        $query_field_data8 = "";
        $query_body_data8 = "";
        $num = 0;
        foreach ($dash_config as $cfg) {
            $key = $cfg['key'];
            $query_field_data8 .= "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "." . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num == 0) {
                $first_field_data8 = "sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            }
            $query_body_data8 .= "
                (select
                  ifnull(t.date_time, '') as date_time,
                  ifnull(t.caption, 'Apparent Power EQV (kVA)') as caption,
                  ifnull(t." . str_replace(" ", "_", str_replace("-", "_", $key)) . ", null) as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                from (select '' as date_time, 'Apparent Power EQV (kVA)' caption, 0 as " . str_replace(" ", "_", str_replace("-", "_", $key)) . ") a
                       left join (SELECT date_time, 'Apparent Power EQV (kVA)' as caption, kva_eqv as " . str_replace(" ", "_", str_replace("-", "_", $key)) . "
                                  FROM $table_name
                                  WHERE device LIKE '%$key%'
                                  order by date_time desc
                                  limit 1) as t on a.caption=t.caption) as sub_" . str_replace(" ", "_", str_replace("-", "_", $key)) . "";
            if ($num < (sizeof($dash_config) - 1)) {
                $query_field_data8 .= ",";
                $query_body_data8 .= ",";
            }
            $num++;
        }
        $query_data8 =
            "
            select 
                $first_field_data8.date_time,
                $first_field_data8.caption,
                $query_field_data8 
            from
                $query_body_data8;
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
//FROM $table_name
//WHERE
//device LIKE '%Tata Air%'
//order by date_time desc
//LIMIT 1) as value5
