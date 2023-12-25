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
        echo 'MM Run at ' . get_times_now() . ' executed.' . PHP_EOL;

        $url = "http://192.168.10.10:9876/api/DataLog/DL_57/D_all/M_all/Now100";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $username='admin'; $password='admin';
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $output = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($this->remove_utf8_bom($output), true);

        $mapper = $this->master->getMapper("mm");

        $executed = 0;
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
            $insert_query = $this->db->insert_string('meter_record_mm', $data);
            $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
            $this->db->query($insert_query);
            $executed++;
        }
        echo 'MM Inserted ' . $executed . ' Items at ' . get_times_now() . ' executed.' . PHP_EOL;
    }

    public function collect_a1()
    {
        echo 'A1.1 Run at ' . get_times_now() . ' executed.' . PHP_EOL;
        echo 'A1.2 Run at ' . get_times_now() . ' executed.' . PHP_EOL;

        $url = "http://192.168.10.10:9876/api/DataLog/DL_59/D_all/M_all/Now100";
        $url2 = "http://192.168.10.10:9876/api/DataLog/DL_61/D_all/M_all/Now100";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $username='admin'; $password='admin';
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $output = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($this->remove_utf8_bom($output), true);

        $mapper = $this->master->getMapper("a1_1");

        $executed = 0;
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
            $executed++;
        }
        echo 'A1.1 Inserted ' . $executed . ' Items at ' . get_times_now() . ' executed.' . PHP_EOL;

        // ====================

        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, $url2);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $username='admin'; $password='admin';
        curl_setopt($ch2, CURLOPT_USERPWD, "$username:$password");
        $output2 = curl_exec($ch2);
        curl_close($ch2);
        $results2 = json_decode($this->remove_utf8_bom($output2), true);

        $mapper2 = $this->master->getMapper("a1_2");

        $executed2 = 0;
        foreach ($results2 as $item) {
            $data = null;
            $data['_unique_key'] = base64_encode($item['TimeStamp'].$item['IdDevice']);
            $data['device'] = $item['DeviceDescription'];
            $data['device_id'] = $item['IdDevice'];
            $data['date_time'] = $item['TimeStamp'];
            $mea = $item['MeasureList'];
            foreach ($mapper2 as $map) {
                $meaItem = $mea[$map['key']];
                $data['mea'] = $meaItem['Description'];
                $data[$map['field']] = $meaItem['Value'];
            }
            $insert_query = $this->db->insert_string('meter_record_a1', $data);
            $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
            $this->db->query($insert_query);
            $executed2++;
        }
        echo 'A1.2 Inserted ' . $executed . ' Items at ' . get_times_now() . ' executed.' . PHP_EOL;
    }

    public function collect_a2()
    {

        echo 'A2 Run at ' . get_times_now() . ' executed.' . PHP_EOL;
        $url = "http://192.168.10.10:9876/api/DataLog/DL_60/D_all/M_all/Now100";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        $username='admin'; $password='admin';
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        $output = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($this->remove_utf8_bom($output), true);

        $mapper = $this->master->getMapper('a2');

        $executed = 0;
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
            $executed++;
        }
        echo 'A2 Inserted ' . $executed . ' Items at ' . get_times_now() . ' executed.' . PHP_EOL;
    }


}