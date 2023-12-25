<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page3_model extends CI_Model
{

    public function getFloor()
    {
        $floor = array(
            array("caption" => "Lantai SB (SB)", "key" => "SB"),
            array("caption" => "Lantai B1 (B1)", "key" => "B1"),
            array("caption" => "Lantai B2 (B2)", "key" => "B2"),
            array("caption" => "Lantai GALLERY (LT1 GALLERY)", "key" => "LT1 GALLERY"),
            array("caption" => "Lantai 1 (LT1)", "key" => "LT1"),
            array("caption" => "Lantai 2 (LT2)", "key" => "LT2"),
            array("caption" => "Lantai 3 (LT3)", "key" => "LT3"),
            array("caption" => "Lantai 4 (LT4)", "key" => "LT4"),
            array("caption" => "Lantai 5 (LT5)", "key" => "LT5"),
            array("caption" => "Lantai 6 (LT6)", "key" => "LT6"),
            array("caption" => "Lantai 7 (LT7)", "key" => "LT7"),
            array("caption" => "Lantai 8 (LT8)", "key" => "LT8"),
            array("caption" => "Lantai 9 (LT9)", "key" => "LT9"),
            array("caption" => "Lantai 10 (LT10)", "key" => "LT10"),
            array("caption" => "Lantai 11 (LT11)", "key" => "LT11"),
            array("caption" => "Lantai 12 (LT12)", "key" => "LT12"),
            array("caption" => "Lantai 13 (LT13)", "key" => "LT13"),
            array("caption" => "Lantai 14 (LT14)", "key" => "LT14"),
            array("caption" => "Lantai 15 (LT15)", "key" => "LT15"),
            array("caption" => "Lantai 16 (LT16)", "key" => "LT16"),
            array("caption" => "Lantai 17 (LT17)", "key" => "LT17"),
            array("caption" => "Lantai 18 (LT18)", "key" => "LT18"),
            array("caption" => "Lantai 19 (LT19)", "key" => "LT19"),
            array("caption" => "Lantai 20 (LT20)", "key" => "LT20"),
            array("caption" => "Lantai 21 (LT21)", "key" => "LT21"),
            array("caption" => "Lantai 22 (LT22)", "key" => "LT22"),
            array("caption" => "Lantai 23 (LT23)", "key" => "LT23"),
            array("caption" => "Lantai 24 (LT24)", "key" => "LT24"),
            array("caption" => "Lantai 25 (LT25)", "key" => "LT25"),
            array("caption" => "Lantai 26 (LT26)", "key" => "LT26"),
            array("caption" => "Lantai 27 (LT27)", "key" => "LT27"),
            array("caption" => "Lantai ROOF (LT Roof)", "key" => "LT Roof"),
        );
        return $floor;
    }

    public function getChartData($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();

        $floor = $this->getFloor();
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

        $floor = $this->getFloor();
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

        $floor = $this->getFloor();
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

        $floor = $this->getFloor();
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
