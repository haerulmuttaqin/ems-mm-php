<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page2_model extends CI_Model
{
    public function getChartData($unit)
    {
        $table_name = 'meter_record_'.$unit;
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
                    select date_time, device, avg(kw_eqv) as value from meter_record_mm
                    where device like 'LVMDP %'
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
                    select date_time, device, avg(kw_eqv) as value from meter_record_mm
                    where device like 'LVMDP %'
                    and cast(date_time as DATE) BETWEEN (SELECT DATE_ADD(DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY), INTERVAL - 1 WEEK)) 
                    and (SELECT DATE_ADD(DATE_ADD(CURDATE(), INTERVAL - WEEKDAY(CURDATE()) DAY), INTERVAL - 1 DAY))
                    group by cast(date_time as DATE), device 
                ) as summary group by cast(date_time as DATE)
        ")->result_array();


        $data['chart2_last_month'] = $this->db->query("
                select date_format(summary.date_time, '%d') as date_time, round(sum(value), 1) as value
                from (
                        select date_time, device, avg(kw_eqv) as value from meter_record_mm
                        where device like 'LVMDP %'
                        and cast(date_time as DATE) BETWEEN (DATE_SUB(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)),INTERVAL DAY(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)))-1 DAY)) 
                        and (LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH))) 
                        group by cast(date_time as DATE), device 
                    ) as summary
                group by cast(summary.date_time as DATE)
        ")->result_array();

        $data['chart2_this_month'] = $this->db->query("
                select date_format(summary.date_time, '%d') as date_time, round(sum(value), 1) as value
                from (
                        select date_time, device, avg(kw_eqv) as value from meter_record_mm
                        where device like 'LVMDP %'
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
                select date_time, device, avg(kw_eqv) as value from meter_record_mm
                where device like 'LVMDP %'
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
                select date_time, device, avg(kw_eqv) as value from meter_record_mm
                where device like 'LVMDP %'
                and cast(date_time as DATE) BETWEEN (DATE_SUB(CURDATE(), INTERVAL 6 DAY)) and NOW()
                group by cast(date_time as DATE), device 
            ) as summary
            group by cast(summary.date_time as DATE)
        ")->result_array();

        return $data;
    }

    public function getTableData($unit)
    {
        $table_name = 'meter_record_'.$unit;

        // data1 Current Avg (I)
        $query_data1 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'Current Avg (I)' as caption,
                                a_avg as value_lvmdp_c1
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C1%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                a_avg as value_lvmdp_c2
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C2%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                a_avg as value_lvmdp_28
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP 28%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3;
                        ";


        // data2 Frequency (Hz)
        $query_data2 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'Frequency (Hz)' as caption,
                                hz_avg as value_lvmdp_c1
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C1%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                hz_avg as value_lvmdp_c2
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C2%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                hz_avg as value_lvmdp_28
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP 28%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3;
                        ";


        // data3 Power Factor
        $query_data3 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'Power Factor' as caption,
                                pf_avg as value_lvmdp_c1
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C1%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                pf_avg as value_lvmdp_c2
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C2%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                pf_avg as value_lvmdp_28
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP 28%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3;
                        ";


        // data4 Voltage Phase to Phase (V)
        $query_data4 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'Voltage Phase to Phase (V)' as caption,
                                vll_avg as value_lvmdp_c1
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C1%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                vll_avg as value_lvmdp_c2
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C2%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                vll_avg as value_lvmdp_28
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP 28%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3;
                        ";


        // data5 THDI (%)
        $query_data5 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'THDI (%)' as caption,
                                thd_avg as value_lvmdp_c1
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C1%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                thd_avg as value_lvmdp_c2
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C2%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                thd_avg as value_lvmdp_28
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP 28%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3;
                        ";


        // data6 Active Power EQV (kW)
        $query_data6 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'Active Power EQV (kW)' as caption,
                                kw_eqv as value_lvmdp_c1
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C1%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                kw_eqv as value_lvmdp_c2
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C2%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                kw_eqv as value_lvmdp_28
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP 28%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3;
                        ";


        // data7 Reactive Power EQV (kVAR)
        $query_data7 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'Reactive Power EQV (kVAR)' as caption,
                                kvar_eqv as value_lvmdp_c1
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C1%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                kvar_eqv as value_lvmdp_c2
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C2%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                kvar_eqv as value_lvmdp_28
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP 28%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3;
                        ";


        // data6 Active Power EQV (kW)
        // data8 Apparent Power EQV (kVA)
        $query_data8 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'Apparent Power EQV (kVA)' as caption,
                                kva_eqv as value_lvmdp_c1
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C1%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                kva_eqv as value_lvmdp_c2
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP C2%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                kva_eqv as value_lvmdp_28
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LVMDP 28%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3;
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

        $data = array_merge($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8);
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
