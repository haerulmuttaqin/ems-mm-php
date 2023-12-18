<?php
defined('BASEPATH') or exit('No direct script access allowed');
//load Spout Library
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class Meter extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->helper("file");
        $this->load->model('Meter_model', 'meter');
    }

    public function index()
    {
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['title'] = 'Meter Data';
        $this->load->view('_partials/header', $data);
        $this->load->view('meter/index', $data);
        $this->load->view('_partials/footer');
    }

    public function records()
    {
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['title'] = 'Meter Records';
        $this->load->view('_partials/header', $data);
        $this->load->view('meter/records', $data);
        $this->load->view('_partials/footer');
    }

    public function data()
    {
        $data = $row = array();
        $role = $this->db->get_where(
            'generic_references',
            array('ref_sid' => $this->session->userdata('user_role_sid'))
        )->row_array();
        $memData = $this->meter->getRows($_POST);

        $i = $_POST['start'];

        foreach ($memData as $member) {
            $i++;
            $data[] = array(
                $i,
                $member->meter_group,
                $member->meter_serial,
                $member->meter_name,
                $member->meter_alias,
                $member->update_date,
                $member->meter_sid
            );
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->meter->countAll(),
            "recordsFiltered" => $this->meter->countFiltered($_POST),
            "data" => $data,
        );

        // Output to JSON format
        echo json_encode($output);
    }

    public function item($id = null)
    {
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['title'] = 'Meter Data';
        $data['meter_sid'] = $id;
        $this->load->view('_partials/header', $data);
        $this->load->view('meter/item', $data);
        $this->load->view('_partials/footer');
    }

    public function update($id = null)
    {
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $this->load->model('Base64_model', 'base64');
        if (isset($id)) {
            $data['title'] = 'Meter Data';
            $data['sid'] = $id;
            $data['image'] = $this->base64->getDataByParentId($id);
            $this->load->view('_partials/header', $data);
            $this->load->view('meter/editor', $data);
            $this->load->view('_partials/footer');
        }
    }

    public function get_by_sid($id)
    {
        $result = array();
        $data = $this->meter->getBySid($id);
        if ($data) {
            $result = array('status' => true, 'message' => 'Fetch Successfully', 'data' => $data);
        } else {
            $result = array('status' => false, 'message' => 'No data found!', 'data' => null);
        }
        echo json_encode($result);
    }

    public function base_reader()
    {
        try {
            //Lokasi file excel       
            $file_path = "D:\\xampp\htdocs\YK\safic-FX\TRD010_210304.csv";
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
            echo json_encode($data);
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


    public function upload()
    {
        $this->load->model('Cropper_model', 'crop');

        $json = array();
        $avatar_src = $this->input->post('avatar_src');
        $avatar_data = $this->input->post('avatar_data');
        $avatar_file = $_FILES['avatar_file'];
        $data_sid = $this->input->post('data_sid');
        $upltype = $this->input->post('upltype');

        $originalPath = FCPATH . '/assets-' . app_version() . '/uploads/img/';
        $thumbPath = FCPATH . '/assets-' . app_version() . '/uploads/img/';
        $urlPath = FCPATH . '/assets-' . app_version() . '/uploads/img/';

        $thumb = $this->crop->setDst($thumbPath);
        $this->crop->setSrc($avatar_src);
        $data = $this->crop->setData($avatar_data);
        // set file
        $avatar_path = $this->crop->setFile($avatar_file, $originalPath);
        // crop
        $this->crop->crop($avatar_path, $thumb, $data);
        //base64

        $path = $thumbPath . '/' . $this->crop->getThumbResult();
        $data = file_get_contents($path);
        $base64 = base64_encode($data);

        // response
        $json = array(
            'state'  => 200,
            'message' => $this->crop->getMsg(),
            'result' => $base64,
            'thumb' => $this->crop->getThumbResult(),
            'data_sid' => $data_sid,
            'urlPath' => $urlPath,
        );
        echo json_encode($json);
    }

    public function uploadCropImg()
    {
        $json = array();
        $data_sid = $this->input->post('data_sid');
        $base64 = $this->input->post('base64');
        $path = $this->input->post('path');
        $thumb = $this->input->post('thumb');
        if (!empty($data_sid)) {
            $this->_deleteDataImageIfExist($data_sid);
            $this->db->insert('base64_data', array(
                'data_sid' => $data_sid,
                'parent_sid' => $data_sid,
                'data' => $base64,
                'data_path' => $path,
                'data_type' => 'METER_IMG',
                'post_by' => $this->session->userdata('user_sid'),
                'post_date' => get_times_now(),
                'update_date' => get_times_now(),
                'post_status' => 1,
            ));
            unlink(FCPATH . '/assets-' . app_version() . '/uploads/img/' . $thumb);
            unlink(FCPATH . '/assets-' . app_version() . '/uploads/img/' . str_replace('.png', '', $thumb) . '-original.png');
            $json['success'] = 'success';
        } else {
            $json['success'] = 'failed';
        }
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    private function _deleteDataImageIfExist($id)
    {
        $query = "DELETE FROM base64_data where data_sid = '$id'";
        $this->db->query($query);
        return true;
    }
}
