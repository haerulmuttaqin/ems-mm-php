<?php
fopen("php://stdin", "r");
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class Cron extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
        $this->load->model('Master_model', 'master');
    }

    public function index()
    {
        redirect('dashboard');
    }

    public function test()
    {
        $this->db->insert('test', array('date'=> get_times_now()));
        echo 'Inserted on ' . get_times_now() . ' excecuted.' . PHP_EOL;
    }

    public function base_reader()
    {
        $dir_path = "D:\\xampp\htdocs\YK\safic-FX\\";
        $date = '2021-01-01'/* get_date_now() */;
        $iterator = new FilesystemIterator($dir_path);
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile()) {
                $cTime = new DateTime();
                $cTime->setTimestamp($fileInfo->getCTime());
                if ($cTime->format('Y-m-d') == $date) {
                }
                $this->read_file($fileInfo->getFileName());
                echo 'Time ' . $cTime->format('Y-m-d') . ' excecuted.' . PHP_EOL;
            }
        }
    }

    private function read_file($filename)
    {
        try {
            //Lokasi file excel       
            $file_path = "D:\\xampp\htdocs\YK\safic-FX\\$filename";

            $reader = ReaderFactory::create(Type::CSV);
            $reader->open($file_path); //open the file          

            $i = 0;
            $i_group = 0;
            $i_serial = 3;
            $i_name = 4;
            $base_data = array();
            foreach ($reader->getSheetIterator() as $sheet) {
                //Rows iterator                
                foreach ($sheet->getRowIterator() as $row) {
                    array_push($base_data, $row);
                    ++$i;
                }
            }
            $data = array();
            $meter_value = array();
            $meter_group = null;
            $meter_serial = array();
            $meter_name = array();
            foreach ($base_data as $row_num => $row) {
                if ($row_num == $i_group) {
                    $meter_group = $row[1];
                }
                if ($row_num == $i_name) {
                    foreach ($row as $item) {
                        array_push($meter_name, $item);
                    }
                }
                if ($row_num == $i_serial) {
                    foreach ($row as $item) {
                        array_push($meter_serial, $item);
                    }
                }
            }
            foreach ($base_data as $row_num => $row) {
                if ($row_num > $i_name) {
                    array_push($meter_value, $row);
                }
            }
            for ($i = 0; $i < 32; $i++) {
                $val_temp = array();
                for ($j = 0; $j < 24; $j++) {
                    $val_obj = array(
                        'date' => date('Y-m-d H:i:s', strtotime($meter_value[$j][0] . ' ' . $meter_value[$j][1])),
                        'value' => $meter_value[$j][$i]
                    );
                    array_push($val_temp, $val_obj);
                }
                if ($i > 1) {
                    array_push($data, array(
                        'id' => $i - 2,
                        'group' => $meter_group,
                        'serial' => $meter_serial[$i],
                        'name' => $meter_name[$i],
                        'value' => $val_temp
                    ));
                }
            }
            foreach ($data as $num => $meter) {
                if ($meter['serial'] != '') {
                    $meter_sid = $this->uuid->sid();
                    $meter_data = array(
                        'meter_sid' => $meter_sid,
                        'meter_group' => $meter['group'],
                        'meter_serial' => $meter['serial'],
                        'meter_name' => $meter['name'],
                        'post_date' => get_times_now(),
                    );
                    $meter_sid_updated = $this->updateOnDuplicate('meter_data', $meter_data);
                    foreach ($meter['value'] as $value) {
                        if ($this->isNotRecorded($meter_sid_updated, $value['date'])) {
                            $meter_record = array(
                                'record_sid' => $this->uuid->sid(),
                                'meter_sid' => $meter_sid_updated,
                                'record_value' => $value['value'],
                                'record_date' => $value['date'],
                            );
                            $this->db->insert('meter_record', $meter_record);
                        }
                    }
                }
            }
            echo 'File ' . $filename . ' excecuted.' . PHP_EOL;
            $reader->close();
        } catch (Exception $e) {
            // echo $e->getMessage();
            return null;
        }
    }

    public function updateOnDuplicate($table, $data)
    {
        $existing = $this->db->get_where($table, array('meter_serial' => $data['meter_serial'], 'meter_name' => $data['meter_name']))->row_array();
        if (empty($table) || empty($data)) return false;
        if (!$existing) {
            $this->db->insert($table, $data);
            return $data['meter_sid'];
        } else {
            $this->db->where('meter_serial', $data['meter_serial']);
            $this->db->where('meter_name', $data['meter_name']);
            $this->db->update($table, array('meter_name' => $data['meter_name']));
            return $existing['meter_sid'];
        }
    }

    private function isNotRecorded($meter_sid, $record_date)
    {
        $data = $this->db->get_where('meter_record', array('meter_sid' => $meter_sid, 'record_date' => $record_date))->row_array();
        if ($data) {
            return false;
        }
        return true;
    }
}
