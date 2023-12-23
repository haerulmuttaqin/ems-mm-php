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

    public function collect_mm()
    {

        $url = "http://localhost/ems.mm/api/meter/demo_data_with_auth";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $username='admin'; $password='admin';;
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $output = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $results = json_decode($this->remove_utf8_bom($output), true);
        echo json_encode($results);

        $mapper = $this->master->getMapper();

//        foreach ($results as $item) {
//            $data = null;
//            $data['_unique_key'] = base64_encode($item['TimeStamp'].$item['IdDevice']);
//            $data['device'] = $item['DeviceDescription'];
//            $data['device_id'] = $item['IdDevice'];
//            $data['date_time'] = $item['TimeStamp'];
//            $mea = $item['MeasureList'];
//            foreach ($mapper as $map) {
//                $meaItem = $mea[$map['key']];
//                $data['mea'] = $meaItem['Description'];
//                $data[$map['field']] = $meaItem['Value'];
//            }
//            $insert_query = $this->db->insert_string('meter_record_mm', $data);
//            $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
//            $this->db->query($insert_query);
//            echo 'Inserted ' . $item['DeviceDescription'] . ' at ' . get_times_now() . ' excecuted.' . PHP_EOL;
//        }
    }

    public function collect_a1()
    {

        $url = "http://localhost/ems.mm/dashboard1.json";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $username='admin'; $password='admin';
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $output = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($this->remove_utf8_bom($output), true);

        $mapper = $this->master->getMapper();

        foreach ($results as $item) {
            $data = null;
            $data['_unique_key'] = base64_encode($item['TimeStamp'].$item['IdDevice']);
            $data['device'] = $item['DeviceDescription'];
            $data['device_id'] = $item['IdDevice'];
            $data['date_time'] = $item['TimeStamp'];
            $mea = $item['MeasureList'];
            foreach ($mapper as $map) {
                $meaItem = $mea[$map['key']];
                $data['mea'] = $meaItem['Description'];
                $data[$map['field']] = $meaItem['Value'];
            }
            $insert_query = $this->db->insert_string('meter_record_a1', $data);
            $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
            $this->db->query($insert_query);
            echo 'Inserted ' . $item['DeviceDescription'] . ' at ' . get_times_now() . ' excecuted.' . PHP_EOL;
        }
    }

    public function collect_a2()
    {

        $url = "http://localhost/ems.mm/dashboard1.json";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $username='admin'; $password='admin';
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $output = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($this->remove_utf8_bom($output), true);

        $mapper = $this->master->getMapper();

        foreach ($results as $item) {
            $data = null;
            $data['_unique_key'] = base64_encode($item['TimeStamp'].$item['IdDevice']);
            $data['device'] = $item['DeviceDescription'];
            $data['device_id'] = $item['IdDevice'];
            $data['date_time'] = $item['TimeStamp'];
            $mea = $item['MeasureList'];
            foreach ($mapper as $map) {
                $meaItem = $mea[$map['key']];
                $data['mea'] = $meaItem['Description'];
                $data[$map['field']] = $meaItem['Value'];
            }
            $insert_query = $this->db->insert_string('meter_record_a2', $data);
            $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
            $this->db->query($insert_query);
            echo 'Inserted ' . $item['DeviceDescription'] . ' at ' . get_times_now() . ' excecuted.' . PHP_EOL;
        }
    }

    public function collect_b()
    {

        $url = "http://localhost/ems.mm/dashboard1.json";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $username='admin'; $password='admin';
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $output = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($this->remove_utf8_bom($output), true);

        $mapper = $this->master->getMapper();

        foreach ($results as $item) {
            $data = null;
            $data['_unique_key'] = base64_encode($item['TimeStamp'].$item['IdDevice']);
            $data['device'] = $item['DeviceDescription'];
            $data['device_id'] = $item['IdDevice'];
            $data['date_time'] = $item['TimeStamp'];
            $mea = $item['MeasureList'];
            foreach ($mapper as $map) {
                $meaItem = $mea[$map['key']];
                $data['mea'] = $meaItem['Description'];
                $data[$map['field']] = $meaItem['Value'];
            }
            $insert_query = $this->db->insert_string('meter_record_b', $data);
            $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
            $this->db->query($insert_query);
            echo 'Inserted ' . $item['DeviceDescription'] . ' at ' . get_times_now() . ' excecuted.' . PHP_EOL;
        }
    }
}