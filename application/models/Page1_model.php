<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page1_model extends CI_Model
{
    public function getPieCartData($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();
        $data['lift'] = $this->db->query("SELECT 
date_time,
mea as measurement, 
'lift' as type, 
device as caption,
avg(kw_eqv) as value 
FROM $table_name
WHERE 
device LIKE '%LIFT%'
AND (YEAR(date_time) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(date_time) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH))
GROUP BY DATE_FORMAT(date_time, '%Y%m');")->row_array();

        $data['penerangan'] = $this->db->query("SELECT 
date_time,
mea as measurement, 
'penerangan' as type, 
device as caption,
avg(kw_eqv) as value 
FROM $table_name
WHERE 
device LIKE '%Penerangan Dan Stop Kontak%'
AND (YEAR(date_time) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(date_time) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH))
GROUP BY DATE_FORMAT(date_time, '%Y%m');")->row_array();

        $data['elektronik'] = $this->db->query("SELECT 
date_time,
mea as measurement, 
'elektronik' as type, 
device as caption,
avg(kw_eqv) as value 
FROM $table_name
WHERE 
device LIKE '%Elektronik%'
AND (YEAR(date_time) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(date_time) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH))
GROUP BY DATE_FORMAT(date_time, '%Y%m');")->row_array();

        $data['tataudara'] = $this->db->query("SELECT 
date_time,
mea as measurement, 
'tataudara' as type, 
device as caption,
avg(kw_eqv) as value 
FROM $table_name
WHERE 
device LIKE '%Tata Udara%'
AND (YEAR(date_time) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(date_time) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH))
GROUP BY DATE_FORMAT(date_time, '%Y%m');")->row_array();

        $data['tataair'] = $this->db->query("SELECT 
date_time,
mea as measurement, 
'tataair' as type, 
device as caption,
avg(kw_eqv) as value 
FROM $table_name
WHERE 
device LIKE '%Tata Air%'
AND (YEAR(date_time) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(date_time) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH))
GROUP BY DATE_FORMAT(date_time, '%Y%m');")->row_array();

        return $data;
    }

    public function getTableData($unit)
    {

        $table_name = 'meter_record_' . $unit;
        // data1 Current Avg (I)
        $query_data1 =
            "
                        SELECT 
                                value1.date_time,
                                value1.caption,
                                value1.value_lift,
                                value2.value_penerangan,
                                value3.value_elektronik,
                                value4.value_udara,
                                value5.value_air
                        FROM
                        (
                                SELECT 
                                date_time,
                                'Current Avg (I)' as caption,
                                SUM(subquery.a_avg) as value_lift
                                FROM (
                                SELECT date_time, a_avg
                                FROM $table_name
                                WHERE device LIKE 'LIFT%'
                                GROUP BY device
                                ) AS subquery
                        ) as value1,
                        
                        (
                                SELECT 
                                SUM(subquery.a_avg) as value_penerangan
                                FROM (
                                SELECT date_time, a_avg
                                FROM $table_name
                                WHERE device LIKE 'Penerangan%'
                                GROUP BY device
                                ) AS subquery
                        ) as value2,
                        
                        (
                                SELECT 
                                SUM(subquery.a_avg) as value_elektronik
                                FROM (
                                SELECT date_time, a_avg
                                FROM $table_name
                                WHERE device LIKE 'Elektronik%'
                                GROUP BY device
                                ) AS subquery
                        ) AS value3,
                        
                        (
                                SELECT 
                                SUM(subquery.a_avg) as value_udara
                                FROM (
                                SELECT date_time, a_avg
                                FROM $table_name
                                WHERE device LIKE 'Tata Udara%'
                                GROUP BY device
                                ) AS subquery
                        ) as value4,
                        
                        (
                                SELECT 
                                SUM(subquery.a_avg) as value_air
                                FROM (
                                SELECT a_avg
                                FROM $table_name
                                WHERE device LIKE 'Tata Air%'
                                GROUP BY device
                                ) AS subquery
                        ) as value5;
                        ";


        // data2 Frequency (Hz)
        $query_data2 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'Frequency (Hz)' as caption,
                                hz_avg as value_lift
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LIFT%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                hz_avg as value_penerangan
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%Penerangan%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                hz_avg as value_elektronik
                                FROM
                                meter_record_mm
                                WHERE
                                device LIKE '%Elektronik%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3,
                        (
                                SELECT
                                hz_avg as value_udara,
                                0 as value_air
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%Tata Udara%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value4;
                        ";


        // data3 Power Factor
        $query_data3 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'Power Factor' as caption,
                                pf_avg as value_lift
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LIFT%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                pf_avg as value_penerangan
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%Penerangan%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                pf_avg as value_elektronik
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%Elektronik%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3,
                        (
                                SELECT
                                pf_avg as value_udara,
                                0 as value_air
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%Tata Udara%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value4;
                        ";


        // data4 Voltage Phase to Phase (V)
        $query_data4 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'Voltage Phase to Phase (V)' as caption,
                                vll_avg as value_lift
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LIFT%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                vll_avg as value_penerangan
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%Penerangan%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                vll_avg as value_elektronik
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%Elektronik%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3,
                        (
                                SELECT
                                vll_avg as value_udara,
                                0 as value_air
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%Tata Udara%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value4;
                        ";


        // data5 THDI (%)
        $query_data5 =
            "
                        select * from
                        (
                                SELECT
                                date_time,
                                'THDI (%)' as caption,
                                thd_avg as value_lift
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%LIFT%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value1,
                        (
                                SELECT
                                thd_avg as value_penerangan
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%Penerangan%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value2,
                        (
                                SELECT
                                thd_avg as value_elektronik
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%Elektronik%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value3,
                        (
                                SELECT
                                thd_avg as value_udara,
                                0 as value_air
                                FROM
                                $table_name
                                WHERE
                                device LIKE '%Tata Udara%'
                                order by
                                date_time desc
                                LIMIT
                                1
                        ) as value4;
                        ";


        // data6 Active Power EQV (kW)
        $query_data6 =
            "
                        SELECT 
                                value1.date_time,
                                value1.caption,
                                value1.value_lift,
                                value2.value_penerangan,
                                value3.value_elektronik,
                                value4.value_udara,
                                value5.value_air
                        FROM
                        (
                                SELECT 
                                date_time,
                                'Active Power EQV (kW)' as caption,
                                SUM(subquery.kw_eqv) as value_lift
                                FROM (
                                SELECT date_time, kw_eqv
                                FROM $table_name
                                WHERE device LIKE 'LIFT%'
                                GROUP BY device
                                ) AS subquery
                        ) as value1,
                        
                        (
                                SELECT 
                                SUM(subquery.kw_eqv) as value_penerangan
                                FROM (
                                SELECT date_time, kw_eqv
                                FROM $table_name
                                WHERE device LIKE 'Penerangan%'
                                GROUP BY device
                                ) AS subquery
                        ) as value2,
                        
                        (
                                SELECT 
                                SUM(subquery.kw_eqv) as value_elektronik
                                FROM (
                                SELECT date_time, kw_eqv
                                FROM $table_name
                                WHERE device LIKE 'Elektronik%'
                                GROUP BY device
                                ) AS subquery
                        ) AS value3,
                        
                        (
                                SELECT 
                                SUM(subquery.kw_eqv) as value_udara
                                FROM (
                                SELECT date_time, kw_eqv
                                FROM $table_name
                                WHERE device LIKE 'Tata Udara%'
                                GROUP BY device
                                ) AS subquery
                        ) as value4,
                        
                        (
                                SELECT 
                                SUM(subquery.kw_eqv) as value_air
                                FROM (
                                SELECT kw_eqv
                                FROM $table_name
                                WHERE device LIKE 'Tata Air%'
                                GROUP BY device
                                ) AS subquery
                        ) as value5;
                        ";


        // data7 Reactive Power EQV (kVAR)
        $query_data7 =
            "
                        SELECT 
                                value1.date_time,
                                value1.caption,
                                value1.value_lift,
                                value2.value_penerangan,
                                value3.value_elektronik,
                                value4.value_udara,
                                value5.value_air
                        FROM
                        (
                                SELECT 
                                date_time,
                                'Reactive Power EQV (kVAR)' as caption,
                                SUM(subquery.kvar_eqv) as value_lift
                                FROM (
                                SELECT date_time, kvar_eqv
                                FROM $table_name
                                WHERE device LIKE 'LIFT%'
                                GROUP BY device
                                ) AS subquery
                        ) as value1,
                        
                        (
                                SELECT 
                                SUM(subquery.kvar_eqv) as value_penerangan
                                FROM (
                                SELECT date_time, kvar_eqv
                                FROM $table_name
                                WHERE device LIKE 'Penerangan%'
                                GROUP BY device
                                ) AS subquery
                        ) as value2,
                        
                        (
                                SELECT 
                                SUM(subquery.kvar_eqv) as value_elektronik
                                FROM (
                                SELECT date_time, kvar_eqv
                                FROM $table_name
                                WHERE device LIKE 'Elektronik%'
                                GROUP BY device
                                ) AS subquery
                        ) AS value3,
                        
                        (
                                SELECT 
                                SUM(subquery.kvar_eqv) as value_udara
                                FROM (
                                SELECT date_time, kvar_eqv
                                FROM $table_name
                                WHERE device LIKE 'Tata Udara%'
                                GROUP BY device
                                ) AS subquery
                        ) as value4,
                        
                        (
                                SELECT 
                                SUM(subquery.kvar_eqv) as value_air
                                FROM (
                                SELECT kvar_eqv
                                FROM $table_name
                                WHERE device LIKE 'Tata Air%'
                                GROUP BY device
                                ) AS subquery
                        ) as value5;
                        ";


        // data6 Active Power EQV (kW)
        // data8 Apparent Power EQV (kVA)
        $query_data8 =
            "
                        SELECT 
                                value1.date_time,
                                value1.caption,
                                value1.value_lift,
                                value2.value_penerangan,
                                value3.value_elektronik,
                                value4.value_udara,
                                value5.value_air
                        FROM
                        (
                                SELECT 
                                date_time,
                                'Apparent Power EQV (kVA)' as caption,
                                SUM(subquery.kva_eqv) as value_lift
                                FROM (
                                SELECT date_time, kva_eqv
                                FROM $table_name
                                WHERE device LIKE 'LIFT%'
                                GROUP BY device
                                ) AS subquery
                        ) as value1,
                        
                        (
                                SELECT 
                                SUM(subquery.kva_eqv) as value_penerangan
                                FROM (
                                SELECT date_time, kva_eqv
                                FROM $table_name
                                WHERE device LIKE 'Penerangan%'
                                GROUP BY device
                                ) AS subquery
                        ) as value2,
                        
                        (
                                SELECT 
                                SUM(subquery.kva_eqv) as value_elektronik
                                FROM (
                                SELECT date_time, kva_eqv
                                FROM $table_name
                                WHERE device LIKE 'Elektronik%'
                                GROUP BY device
                                ) AS subquery
                        ) AS value3,
                        
                        (
                                SELECT 
                                SUM(subquery.kva_eqv) as value_udara
                                FROM (
                                SELECT date_time, kva_eqv
                                FROM $table_name
                                WHERE device LIKE 'Tata Udara%'
                                GROUP BY device
                                ) AS subquery
                        ) as value4,
                        
                        (
                                SELECT 
                                SUM(subquery.kva_eqv) as value_air
                                FROM (
                                SELECT kva_eqv
                                FROM $table_name
                                WHERE device LIKE 'Tata Air%'
                                GROUP BY device
                                ) AS subquery
                        ) as value5;
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
//FROM meter_record
//WHERE
//device LIKE '%Tata Air%'
//order by date_time desc
//LIMIT 1) as value5
