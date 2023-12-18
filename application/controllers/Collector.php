<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Collector extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Master_model', 'master');
    }

    public function index()
    {
        redirect('../');
    }

    function remove_utf8_bom($text)
    {
        $bom = pack('H*','EFBBBF');
        return preg_replace("/^$bom/", '', $text);
    }

    public function dashboard1()
    {

        $url = "http://localhost/ems.mm/dashboard1.json";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($this->remove_utf8_bom($output), true);

        $mapper = $this->master->getMapper();

        foreach ($results as $item) {
            $data = null;
            $data['device'] = $item['DeviceDescription'];
            $data['device_id'] = $item['IdDevice'];
            $data['date_time'] = $item['TimeStamp'];
            $mea = $item['MeasureList'];
            foreach ($mapper as $map) {
                $meaItem = $mea[$map['key']];
                $data['mea'] = $meaItem['Description'];
                $data[$map['field']] = $meaItem['Value'];
            }
            $this->db->insert('meter_record', $data);
            echo 'Inserted ' . $item['DeviceDescription'] . ' at ' . get_times_now() . ' excecuted.' . PHP_EOL;
        }
    }
}