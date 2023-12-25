<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page5_model extends CI_Model
{
    public function getPieRasio($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();

        $type = array(
            array("caption" => "Lantai (SB)", "key" => "Penerangan Dan Stop Kontak - PLT - SB"),
            array("caption" => "Lantai (B1)", "key" => "Penerangan Dan Stop Kontak - PLT B1",),
            array("caption" => "Lantai (B2)", "key" => "Penerangan Dan Stop Kontak - PLT - B2"),
            array("caption" => "Lantai GALLERY (LT1 GALLERY)", "key" => "Penerangan Dan Stop Kontak - PLT - LT1 GALLERY"),
            array("caption" => "Lantai (LT1)", "key" => "Penerangan Dan Stop Kontak - PLT - LT1"),
            array("caption" => "Lantai (LT2)", "key" => "Penerangan Dan Stop Kontak - PLT - LT2"),
            array("caption" => "Lantai (LT3)", "key" => "Penerangan Dan Stop Kontak - PLT - LT3"),
            array("caption" => "Lantai (LT4)", "key" => "Penerangan Dan Stop Kontak - PLT - LT4"),
            array("caption" => "Lantai (LT5)", "key" => "Penerangan Dan Stop Kontak - PLT - LT5"),
            array("caption" => "Lantai (LT4)", "key" => "Penerangan Dan Stop Kontak - PL POD - LT4"),
            array("caption" => "Lantai (LT3)", "key" => "Penerangan Dan Stop Kontak - PL POD -LT3"),
            array("caption" => "Lantai (LT2)", "key" => "Penerangan Dan Stop Kontak - PL POD  - LT2"),
            array("caption" => "Lantai (LT1)", "key" => "Penerangan Dan Stop Kontak - PL POD - LT1"),
            array("caption" => "Lantai (LT6)", "key" => "Penerangan Dan Stop Kontak - PLT - LT6"),
            array("caption" => "Lantai (LT7)", "key" => "Penerangan Dan Stop Kontak - PLT - LT7"),
            array("caption" => "Lantai (LT8)", "key" => "Penerangan Dan Stop Kontak - PLT - LT8"),
            array("caption" => "Lantai (LT9)", "key" => "Penerangan Dan Stop Kontak - PLT - LT9"),
            array("caption" => "Lantai (LT10)", "key" => "Penerangan Dan Stop Kontak - PLT - LT10"),
            array("caption" => "Lantai (LT11)", "key" => "Penerangan Dan Stop Kontak - PLT - LT11"),
            array("caption" => "Lantai (LT12)", "key" => "Penerangan Dan Stop Kontak - PLT - LT12"),
            array("caption" => "Lantai (LT13)", "key" => "Penerangan Dan Stop Kontak - PLT - LT13"),
            array("caption" => "Lantai (LT15)", "key" => "Penerangan Dan Stop Kontak - PLT - LT15"),
            array("caption" => "Lantai (LT16)", "key" => "Penerangan Dan Stop Kontak - PLT - LT16"),
            array("caption" => "Lantai (LT17)", "key" => "Penerangan Dan Stop Kontak - PLT - LT17"),
            array("caption" => "Lantai (LT18)", "key" => "Penerangan Dan Stop Kontak - PLT - LT18"),
            array("caption" => "Lantai (LT19)", "key" => "Penerangan Dan Stop Kontak - PLT - LT19"),
            array("caption" => "Lantai (LT20)", "key" => "Penerangan Dan Stop Kontak - PLT - LT20"),
            array("caption" => "Lantai (LT21)", "key" => "Penerangan Dan Stop Kontak - PLT - LT21"),
            array("caption" => "Lantai (LT22)", "key" => "Penerangan Dan Stop Kontak - PLT - LT22"),
            array("caption" => "Lantai (LT23)", "key" => "Penerangan Dan Stop Kontak - PLT - LT23"),
            array("caption" => "Lantai (LT24)", "key" => "Penerangan Dan Stop Kontak - PLT - LT24"),
            array("caption" => "Lantai (LT25)", "key" => "Penerangan Dan Stop Kontak - PLT - LT25"),
            array("caption" => "Lantai (LT26)", "key" => "Penerangan Dan Stop Kontak - PLT - LT26"),
            array("caption" => "Lantai (LT27)", "key" => "Penerangan Dan Stop Kontak - PLT - LT27"),
            array("caption" => "Lantai ROOF (LT Roof)", "key" => "Penerangan Dan Stop Kontak - PLT - LT Roof"),
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


    public function getPieElektronik($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();
        $type = array(
            array("caption" => "Elektronik - BASS", "key" => "Elektronik - BASS"),
            array("caption" => "Elektronik - AC HUB - LT5", "key" => "Elektronik - AC HUB - LT5",),
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

    public function getPieLift($unit)
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
    public function getTableData($unit)
    {
        $table_name = 'meter_record_' . $unit;
        $data = array();

        $type = array(
            array("caption" => "LVMDP C1", "key" => "LVMDP C1"),
            array("caption" => "LVMDP C2", "key" => "LVMDP C2"),
            array("caption" => "LVMDP 28", "key" => "LVMDP 28"),
            array("caption" => "SDP - SB", "key" => "SDP - SB"),
            array("caption" => "SDP - B1", "key" => "SDP - B1"),
            array("caption" => "SDP - B2", "key" => "SDP - B2"),
            array("caption" => "SDP - LT1", "key" => "SDP - LT1"),
            array("caption" => "SDP - LT8", "key" => "SDP - LT8"),
            array("caption" => "SDP - LT15", "key" => "SDP - LT15"),
            array("caption" => "SDP - LT22", "key" => "SDP - LT22"),
            array("caption" => "SDP - CBB NEW", "key" => "SDP - CBB NEW"),
            array("caption" => "SDP - GALLERY", "key" => "SDP - GALLERY"),
            array("caption" => "SDP FIRE FIGHTING", "key" => "SDP FIRE FIGHTING"),
        );
        for ($i = 0; $i < sizeof($type) ; $i++) {
            $item_floor = $type[$i];
            $key = $item_floor['key'];
            $caption = $item_floor['caption'];
            $data[] = $this->db->query("
               select 
                   '$caption' as caption, 
               (
                    (
                    select 
                    kwh_imp
                    from $table_name
                    where cast(date_time as DATE) = last_day(curdate() - interval 1 month) + interval 1 day and device like '$key'
                    ) - (
                    select 
                    kwh_imp
                    from $table_name
                    where cast(date_time as DATE) = last_day(curdate() - interval 2 month) + interval 1 day and device like '$key'
                    )
                ) as value_active_e,
                (
                    (
                    select 
                    kvarh_imp
                    from $table_name
                    where cast(date_time as DATE) = last_day(curdate() - interval 1 month) + interval 1 day and device like '$key'
                    ) - (
                    select 
                    kvarh_imp
                    from $table_name
                    where cast(date_time as DATE) = last_day(curdate() - interval 2 month) + interval 1 day and device like '$key'
                    )
                ) as value_reactive_e
            ")->row_array();
        }

        return $data;
    }
}
