<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page1_model extends CI_Model
{
    public function getPieCartData()
    {
        $data = array();
        $data['lift'] = $this->db->query("SELECT 
date_time,
mea as measurement, 
'lift' as type, 
device as caption,
avg(kw_eqv) as value 
FROM meter_record
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
FROM meter_record
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
FROM meter_record
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
FROM meter_record
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
FROM meter_record
WHERE 
device LIKE '%Tata Air%'
AND (YEAR(date_time) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(date_time) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH))
GROUP BY DATE_FORMAT(date_time, '%Y%m');")->row_array();

        return $data;
    }

    public function getTableData()
    {
        $data = $this->db->query("
select * from (SELECT 
date_time,
'Current Avg' as caption,
kw_eqv as value_lift 
FROM meter_record
WHERE 
device LIKE '%LIFT%'
order by date_time desc
LIMIT 1) as value1,
(SELECT 
kw_eqv as value_penerangan 
FROM meter_record
WHERE 
device LIKE '%Penerangan%'
order by date_time desc
LIMIT 1) as value2,
(SELECT 
kw_eqv as value_elektronik 
FROM meter_record
WHERE 
device LIKE '%Elektronik%'
order by date_time desc
LIMIT 1) as value3,
(SELECT 
kw_eqv as value_udara,
0 as value_air 
FROM meter_record
WHERE 
device LIKE '%Tata Udara%'
order by date_time desc
LIMIT 1) as value4
;
        ")->result_array();

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
