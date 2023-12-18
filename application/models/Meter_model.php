<?php

class Meter_model extends CI_Model
{
    public function __construct()
    {
        $query = "
            select 
            *
            from meter_data";
        // Set table name
        $this->table = "(" . $query . ") data";
        // $this->table = "tube";
        // Set orderable column fields
        $this->column_order = array(
            null,
            'meter_group',
            'meter_serial',
            'meter_name',
            'update_date',
        );
        // Set searchable column fields
        $this->column_search = array(
            'meter_group',
            'meter_serial',
            'meter_name',
        );
        // Set default order
        $this->order = array('post_date' => 'desc');
    }

    public function getRows($postData)
    {
        $this->_get_datatables_query($postData);
        if ($postData['length'] != -1) {
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countAll()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function countFiltered($postData)
    {
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function _get_datatables_query($postData)
    {
        $this->db->from($this->table);

        if ($postData['group']) {
            $this->db->where('meter_group', $postData['group']);
        }
        

        $i = 0;
        // loop searchable columns
        foreach ($this->column_search as $item) {
            // if datatable send POST for search
            if ($postData['search']['value']) {
                // first loop
                if ($i === 0) {
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                } else {
                    $this->db->or_like($item, $postData['search']['value']);
                }

                // last loop
                if (count($this->column_search) - 1 == $i) {
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($postData['order'])) {
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getBySid($id) {
        $query = "
        select 
            data.*
            from meter_data data
            where data.meter_sid = '$id'
        ";
        return $this->db->query($query)->row_array();
    }

    public function getMeterData() {
        $last_record = meter_last_record_date_time();
        $query = "
        select 
            d.meter_sid, d.meter_name, max(r.record_date) record_date, max(r2.record_date) record_date_before, r.record_value, r2.record_value record_value_before, img.data image,
            case 
                when r.record_value > r2.record_value then 
                    case when r2.record_value = r.record_value then 'cil-arrow-bottom text-success' else 'cil-arrow-top text-orange' end
                else 'cil-arrow-right text-success'
            end meter_indicator,
            case 
                when r.record_value > r2.record_value then 
                    case when r2.record_value = r.record_value then 'Menurun' else 'Meningkat' end
                else 'Sama'
            end meter_text
            from meter_data d
            left join meter_record r on d.meter_sid = r.meter_sid
            left join meter_record r2 on r.meter_sid = r2.meter_sid and r.record_date = (r2.record_date + INTERVAL '1' MONTH)
            left join base64_data img on d.meter_sid = img.parent_sid
            where r.record_date = '$last_record'
            group by d.meter_name, d.meter_sid, r.record_value,r2.record_value, img.data
        ";
        return $this->db->query($query)->result_array();
    }

    public function getMeterDataById($id) {
        $last_record = meter_last_record_date_time();
        $query = "
        select 
            d.meter_sid, d.meter_name, max(r.record_date) record_date, max(r2.record_date) record_date_before, r.record_value, r2.record_value record_value_before, img.data image,
            case 
                when r.record_value > r2.record_value then 
                    case when r2.record_value = r.record_value then 'cil-arrow-bottom text-success' else 'cil-arrow-top text-orange' end
                else 'cil-arrow-right text-success'
            end meter_indicator,
            case 
                when r.record_value > r2.record_value then 
                    case when r2.record_value = r.record_value then 'Menurun' else 'Meningkat' end
                else 'Sama'
            end meter_text
            from meter_data d
            left join meter_record r on d.meter_sid = r.meter_sid
            left join meter_record r2 on r.meter_sid = r2.meter_sid and r.record_date = (r2.record_date + INTERVAL '1' MONTH)
            left join base64_data img on d.meter_sid = img.parent_sid
            where r.record_date = '$last_record' and d.meter_sid = '$id'
            group by d.meter_name, d.meter_sid, r.record_value,r2.record_value, img.data
        ";
        return $this->db->query($query)->row_array();
    } 
    
    public function getMeterDataChartById($id) {
        $last_record = meter_last_record_date_time();
        $query = "select * from (
            SELECT MAX(record_date) date, max(record_value) val
            FROM     meter_record
            WHERE (record_date BETWEEN (to_date('$last_record', 'YYYY-MM-DD') - INTERVAL '2 MONTH 1 DAY') and '$last_record' )
            AND meter_sid = '$id'
            GROUP BY EXTRACT (DAY FROM record_date) ) as result
            order by date";
        return $this->db->query($query)->result_array();
    }
}