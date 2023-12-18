<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Collector extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
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

    public function test()
    {


        $url = "http://localhost/ems.mm/dashboard1.json";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $results = json_decode($this->remove_utf8_bom($output), true);


        $mapper = $this->master->getMapper();

        var_dump($mapper);

        foreach ($results as $item) {
            echo "</br>";
            echo "</br>";
            $mea = $item['MeasureList'];
            foreach ($mapper as $map) {
                var_dump($mea[$map['key']]);
                echo   "</br>";
                echo  $map['key']. "</br>";
            }
//            var_dump();
        }

//        for($idx = 0; $idx < count($dec); $idx++){
//            $obj = (Array)$dec[$idx];
//            echo $obj["IdDataLog"] . '</br>';
//        }

//        $this->db->insert('test', array('date'=> get_times_now()));
//        echo 'Inserted on ' . get_times_now() . ' excecuted.' . PHP_EOL;
    }
}