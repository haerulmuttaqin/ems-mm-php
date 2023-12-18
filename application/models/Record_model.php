<?php

class Record_model extends CI_Model
{
    public function __construct()
    {
        // $this->table = "tube";
        // Set orderable column fields
        $this->column_order = array(
            null,
            'meter_name',
            'date_formated',
            'record_value',
        );
        // Set searchable column fields
        $this->column_search = array(
            'date_formated',
            'meter_name',
        );
        // Set default order
        $this->order = array('date_formated' => 'desc');
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
        $filter_mode = $postData['filter_mode'];
        $filter_date = $postData['filter_date'];

        if ($filter_date == '') {
            $filter_date = get_times_now();
        }

        $date = date_format(date_create($filter_date), 'd');
        $month = date_format(date_create($filter_date), 'm');
        $year = date_format(date_create($filter_date), 'Y');

        if ($filter_mode == 0) { //hourly
            $query = "
                select 
                m.*,
                r.record_value,
                r.record_date,
                to_char(r.record_date, 'DD Mon YYYY  HH24:MI:SS') date_formated
                from meter_data m
                inner join meter_record r on m.meter_sid = r.meter_sid
                where date_part('day', r.record_date) = $date and date_part('month', r.record_date) = $month and date_part('year', r.record_date) = $year";
        } else if ($filter_mode == 1) { //daily
            $query = "
                SELECT 
                    meter_sid,
                    meter_name,
                    DATE(record_date) record_date, 
                    to_char(record_date, 'DD Mon YYYY') date_formated,
                    SUM(record_value) record_value
                FROM 
                    meter_record
                INNER JOIN meter_data USING (meter_sid)
                WHERE date_part('month', record_date) = $month AND date_part('year', record_date) = $year
                GROUP BY
                    DATE(record_date), meter_name, meter_sid, to_char(record_date, 'DD Mon YYYY')
                ORDER BY meter_name ";
        } else if ($filter_mode == 2) { //monthly
            $query = "
                SELECT 
                    meter_sid,
                    meter_name,
                    to_char(record_date, 'Mon YYYY') date_formated,
                    SUM(record_value) record_value
                FROM 
                    meter_record
                INNER JOIN meter_data USING (meter_sid)
                WHERE date_part('year', record_date) = $year
                GROUP BY
                    meter_name, meter_sid, to_char(record_date, 'Mon YYYY')
                ORDER BY meter_name ";
        } else { //monthly
            $query = "
                    SELECT 
                    meter_sid,
                    meter_name,
                    to_char(record_date, 'YYYY') date_formated,
                    SUM(record_value) record_value
                FROM 
                    meter_record
                INNER JOIN meter_data USING (meter_sid)
                GROUP BY
                    meter_name, meter_sid, to_char(record_date, 'YYYY')
                ORDER BY meter_name ";
        }


        // Set table name
        $this->table = "(" . $query . ") data";
        $this->db->from($this->table);
        $this->db->where('meter_sid', $postData['meter_sid']);

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

    public function getBySid($id)
    {
        $query = "
        select 
            data.*
            from meter_data data
            where data.meter_sid = '$id'
        ";
        return $this->db->query($query)->row_array();
    }
}
