<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page4_model extends CI_Model
{
    public function getChartData($unit)
    {
        $table_name = 'meter_record_' . $unit;
        return $this->db->query("
        select date_format(summary.date_time, '%d') date_time, avg(summary.value) as value from (
            SELECT device_id, device, date_time, sum(kw_eqv) as value from $table_name
                where device in ('LVMDP C1', 'LVMDP C2', 'LVMDP 28')
                group by CAST(date_time AS DATE), device
            ) as summary
            where cast(date_time as DATE) BETWEEN (DATE_ADD(LAST_DAY(DATE_ADD(NOW(), INTERVAL -1 MONTH)), INTERVAL 1 DAY)) and NOW() - INTERVAL 1 DAY
            group by cast(summary.date_time as DATE)
        ")->result_array();
    }


    public function getPieDayaKerja($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();
        $type = array(
            "SDP - SB",
            "SDP - B1",
            "SDP - B2",
            "SDP - LT1",
            "SDP - LT8",
            "SDP - LT15",
            "SDP - LT22",
            "SDP - CBB NEW",
            "SDP - GALLERY",
            "SDP FIRE FIGHTING"
        );
        for ($i = 0; $i < sizeof($type) ; $i++) {
            $item_floor = $type[$i];
            $data[] = $this->db->query("
                select '$item_floor' as caption, cast(date_time as DATE) as date_time, avg(kw_eqv) as value from $table_name 
                where cast(date_time as DATE) = curdate() and device like '$item_floor'
            ")->row_array();
        }

        return $data;
    }


    public function getPieDayaLift($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();
        $type = array(
            array("caption" => "LIFT A (LIFT - LT15)", "key" => "LIFT - LT15"),
            array("caption" => "LIFT B (LIFT - LT28)", "key" => "LIFT - LT28"),
            array("caption" => "LIFT C (LIFT - LT4)", "key" => "LIFT - LT4"),
        );
        for ($i = 0; $i < sizeof($type) ; $i++) {
            $item_floor = $type[$i];
            $key = $item_floor['key'];
            $caption = $item_floor['caption'];
            $data[] = $this->db->query("
                select '$caption' as caption, cast(date_time as DATE) as date_time, avg(kw_eqv) as value from $table_name 
                where cast(date_time as DATE) = curdate() and device like '$key'
            ")->row_array();
        }

        return $data;
    }

    public function getPieDayaLighting($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();

        $type = array(
            array("caption" => "Penerangan & Stop Kontak - PLT - B2", "key" => "Penerangan Dan Stop Kontak - PLT - B2"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT1", "key" => "Penerangan Dan Stop Kontak - PLT - LT1"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT10", "key" => "Penerangan Dan Stop Kontak - PLT - LT10"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT11", "key" => "Penerangan Dan Stop Kontak - PLT - LT11"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT12", "key" => "Penerangan Dan Stop Kontak - PLT - LT12"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT13", "key" => "Penerangan Dan Stop Kontak - PLT - LT13"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT15", "key" => "Penerangan Dan Stop Kontak - PLT - LT15"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT16", "key" => "Penerangan Dan Stop Kontak - PLT - LT16"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT17", "key" => "Penerangan Dan Stop Kontak - PLT - LT17"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT18", "key" => "Penerangan Dan Stop Kontak - PLT - LT18"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT19", "key" => "Penerangan Dan Stop Kontak - PLT - LT19"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT2", "key" => "Penerangan Dan Stop Kontak - PLT - LT2"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT20", "key" => "Penerangan Dan Stop Kontak - PLT - LT20"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT21", "key" => "Penerangan Dan Stop Kontak - PLT - LT21"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT22", "key" => "Penerangan Dan Stop Kontak - PLT - LT22"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT23", "key" => "Penerangan Dan Stop Kontak - PLT - LT23"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT24", "key" => "Penerangan Dan Stop Kontak - PLT - LT24"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT25", "key" => "Penerangan Dan Stop Kontak - PLT - LT25"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT26", "key" => "Penerangan Dan Stop Kontak - PLT - LT26"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT27", "key" => "Penerangan Dan Stop Kontak - PLT - LT27"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT3", "key" => "Penerangan Dan Stop Kontak - PLT - LT3"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT4", "key" => "Penerangan Dan Stop Kontak - PLT - LT4"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT5", "key" => "Penerangan Dan Stop Kontak - PLT - LT5"),
            array("caption" => "Penerangan & Stop Kontak - PL POD - LT4", "key" => "Penerangan Dan Stop Kontak - PL POD - LT4"),
            array("caption" => "Penerangan & Stop Kontak - PL POD -LT3", "key" => "Penerangan Dan Stop Kontak - PL POD -LT3"),
            array("caption" => "Penerangan & Stop Kontak - PL POD  - LT2", "key" => "Penerangan Dan Stop Kontak - PL POD  - LT2"),
            array("caption" => "Penerangan & Stop Kontak - PL POD - LT1", "key" => "Penerangan Dan Stop Kontak - PL POD - LT1"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT6", "key" => "Penerangan Dan Stop Kontak - PLT - LT6"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT7", "key" => "Penerangan Dan Stop Kontak - PLT - LT7"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT8", "key" => "Penerangan Dan Stop Kontak - PLT - LT8"),
            array("caption" => "Penerangan & Stop Kontak - PLT - LT9", "key" => "Penerangan Dan Stop Kontak - PLT - LT9"),
            array("caption" => "Penerangan & Stop Kontak - PLT - SB", "key" => "Penerangan Dan Stop Kontak - PLT - SB"),
            array("caption" => "Penerangan & Stop Kontak - PLT B1", "key" => "Penerangan Dan Stop Kontak - PLT B1",),
        );
        for ($i = 0; $i < sizeof($type) ; $i++) {
            $item_floor = $type[$i];
            $key = $item_floor['key'];
            $caption = $item_floor['caption'];
            $data[] = $this->db->query("
                select '$caption' as caption, cast(date_time as DATE) as date_time, avg(kw_eqv) as value from $table_name 
                where cast(date_time as DATE) = curdate() and device like '$key'
            ")->row_array();
        }

        return $data;
    }


    public function getTableData($unit)
    {
        $table_name = 'meter_record_' . $unit;

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
