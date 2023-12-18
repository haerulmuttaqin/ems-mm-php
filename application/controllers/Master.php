<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Master_model', 'master');
    }

    public function index()
    {
        $data['title'] = 'Master Data';
        $data['menu'] = $this->menu->getMenu();
        $data['category'] = $this->master->getCategory();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['resume'] = null;

        $this->load->view('_partials/header', $data);
        $this->load->view('master/index', $data);
        $this->load->view('_partials/footer');
    }

    public function master()
    {
        $data['title'] = 'Master Data';
        $data['menu'] = $this->menu->getMenu();
        $data['category'] = $this->master->getCategory();
        $data['resume'] = 'Master';
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));

        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header', $data);
            $this->load->view('master/index', $data);
            $this->load->view('_partials/footer');
        }
        else {
            // Jika ada id berarti update
            if ($this->input->post('id')) {
                $this->db->where('category_sid', $this->input->post('id'));
                $this->db->update('generic_category', array(
                    'category_name' => strtoupper(htmlspecialchars($this->input->post('name'))),
                    'category_desc' => $this->input->post('desc'),
                    'is_config_two_level' => $this->input->post('config'),
                    'parent_sid' => $this->input->post('parentSid'),
                    'date_modified' => get_times_now()
                ));
                $this->toastr->success('Data updated!');
                redirect('Master');
            }
            // sebaliknya
            else {
                $this->db->insert('generic_category', array(
                    'category_sid' => $this->uuid->sid(),
                    'category_name' => strtoupper(htmlspecialchars($this->input->post('name'))),
                    'category_desc' => $this->input->post('desc'),
                    'is_config_two_level' => $this->input->post('config'),
                    'parent_sid' => $this->input->post('parentSid'),
                    'date_created' => get_times_now(),
                    'date_modified' => get_times_now()
                ));
                $this->toastr->success('New data added!');
                redirect('Master');
            }
        }
    }

    public function deleteMaster() {
        $this->db->delete('generic_category', array(
            'category_sid' => $this->input->get('delete_id'),
        ));
        $this->toastr->success('Data deleted!');
        redirect('Master');
    }

    public function masterItem($cat_sid)
    {

        $data['title'] = 'Master Data';
        $data['menu'] = $this->menu->getMenu();
        $data['category'] = $this->master->getCategory();
        $data['resume'] = 'Master';
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));

        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header', $data);
            $this->load->view('master/index', $data);
            $this->load->view('_partials/footer');
        }
        else {
            // Jika ada id berarti update
            if ($this->input->post('id')) {
                $this->db->where('ref_sid', $this->input->post('id'));
                $this->db->update('generic_references', array(
                    'ref_name' => strtoupper(trim(htmlspecialchars($this->input->post('name')))),
                    'ref_description' => strtoupper(trim(htmlspecialchars($this->input->post('desc')))),
                    'ref_value' => intval(trim(htmlspecialchars($this->input->post('value')))),
                    'parent_sid' => trim(htmlspecialchars($this->input->post('parent'))),
                    'date_modified' => get_times_now()
                ));
                $this->toastr->success('Data updated!');
                $data['resume'] = $cat_sid;
                redirect('master#tab' . $cat_sid);
            }
            // sebaliknya
            else {
                $this->db->insert('generic_references', array(
                    'ref_sid' => $this->uuid->sid(),
                    'category_sid' => $cat_sid,
                    'ref_name' => strtoupper(trim(htmlspecialchars($this->input->post('name')))),
                    'ref_description' => strtoupper(trim(htmlspecialchars($this->input->post('desc')))),
                    'ref_value' => intval(trim(htmlspecialchars($this->input->post('value')))),
                    'parent_sid' => trim(htmlspecialchars($this->input->post('parent'))),
                    'date_created' => get_times_now(),
                    'date_modified' => get_times_now(),
                ));
                $this->toastr->success('New menu added!');
                redirect('master#tab' . $cat_sid);
            }
        }
    }

    public function deleteMasterItem($cat_sid) {
        $this->db->delete('generic_references', array(
            'ref_sid' => $this->input->get('delete_id'),
        ));
        $this->toastr->success('Data deleted!');
        $data['resume'] = $cat_sid;
        redirect('master#tab' . $cat_sid);
    }

    public function masterItemGeneric($category_sid = null)
    {
        echo json_encode($this->master->getGenericByCategory($category_sid));
    }

    public function ref_generic($category = null) {
        $this->db->select('a.*');
        $this->db->from('generic_references a');
        $this->db->join('generic_category b', 'a.category_sid = b.category_sid', 'left');
        $this->db->where('b.category_name', urldecode($category));
        echo json_encode($this->db->get()->result_array());
    }

    public function ref_kecamatan() {
        $this->db->select('*');
        $this->db->from('address_id');
        $this->db->where('provinsi', 'SULAWESI UTARA');
        $this->db->group_by('kecamatan');
        echo json_encode($this->db->get()->result_array());
    }
    
    public function ref_generic_by_value($category, $value) {
        echo json_encode($this->master->getGenericByCategoryNameAndValue(urldecode($category), $value));
    }

    public function get_login_ulp() {
        $role = $this->session->userdata('user_role_value');
        $unit = $this->master->getGenericBySid($this->session->userdata('user_unit'));
        $unit_name = $unit['ref_name'];
        if (intval($role) > 1) {
            echo json_encode($unit_name);
        } else {
            echo json_encode(null);
        }
    }

    public function get_meter() {
        $this->db->select('meter_data.meter_sid, meter_data.meter_name');
        $this->db->from('meter_data');
        echo json_encode($this->db->get()->result_array());
    }
    
    public function get_meter_group($value = null) {
        $this->db->select('meter_data.meter_group');
        $this->db->from('meter_data');
        $this->db->group_by('meter_group');
        echo json_encode($this->db->get()->result_array());
    }

    public function get_app_name() {
        echo json_encode(app_name());
    }

    public function get_app_version() {
        echo json_encode(app_version());
    }

    public function set_current_menu() {
        $this->session->set_userdata(array('current_menu'=>$this->input->post('current_menu')));
    }

    public function info()
    {
        $data['title'] = 'Company Info';
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['data'] = $this->db->get('general_info')->row_array();

        $this->load->view('_partials/header', $data);
        $this->load->view('master/info', $data);
        $this->load->view('_partials/footer');
    }

    public function updateCatOrder() {
        $i = 1;
        $pos = $this->input->post('position');
        foreach ($pos as $k=>$v) {
            $this->db->where('generic_category.category_sid', $v);
            $this->db->update('generic_category', array(
                'sort' => $i
            ));
            $i++;
        }
    }

    public function get_asset_id() {
        echo $this->generate_number('asset_uid', 'data_asset');
    }

    public function get_asset_prefix() {
        $prefix_id = $this->master->getGenericByCategoryNameAndValue('PREFIX ID', 0);
        echo $prefix_id['ref_description'];
    }

    public function get_unit_region() {
        echo json_encode($this->master->getGenericByCategoryName('UNIT'));
    }

    public function get_month() {
        $data = array(
            array('val'=>'01', 'name'=>'JANUARY'),
            array('val'=>'02', 'name'=>'FEBRUARY'),
            array('val'=>'03', 'name'=>'MARCH'),
            array('val'=>'04', 'name'=>'APRIL'),
            array('val'=>'05', 'name'=>'MAY'),
            array('val'=>'06', 'name'=>'JUNE'),
            array('val'=>'07', 'name'=>'JULY'),
            array('val'=>'08', 'name'=>'AUGUST'),
            array('val'=>'09', 'name'=>'SEPTEMBER'),
            array('val'=>'10', 'name'=>'OCTOBER'),
            array('val'=>'11', 'name'=>'NOVEMBER'),
            array('val'=>'12', 'name'=>'DECEMBER')
        );
        echo json_encode($data);
    }

    public function get_year() {
        $data = array();
        for ($i=$i=1970;$i<=date('Y');$i++) { 
            array_push($data, array('val'=>$i));
        }
        echo json_encode($data);
    }

    public function generate_number($field, $table)
    {
        $q = $this->db->query("SELECT MAX(RIGHT(".$field.",6)) AS kd_max FROM ".$table."");
        $kd = "";
        $rand = rand(11111,99999);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "000001";
        }
        return $rand.date('ymd', time()).$kd;
    }
}