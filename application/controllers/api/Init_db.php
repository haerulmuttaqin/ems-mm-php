<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . 'libraries/Json2Sql.php';

class Init_db extends Rest_lib
{

    public function __construct()
    {
        parent::__construct();
        $this->verify_request();
        $this->load->library('zip');
        $this->load->helper('file');
        $this->load->model('Master_model', 'master');
    }

    public function index_post()
    {
        $input = $this->request->body;

        $user_sid = $input['user_sid'];

        $assets_path = 'assets-' . app_version() . '/db/';
        $db_name = $user_sid . '_pju_sqlite.db';
        $db_name_zip = $user_sid . '_pju_sqlite.zip';
        $db_name_zip_temp = $user_sid . '_pju_temp.zip';
        $db_path = FCPATH . $assets_path . $db_name;
        $db_zip_path_temp  = FCPATH . $assets_path . $db_name_zip_temp;
        $db_zip_path = FCPATH . $assets_path . $db_name_zip;

        $user = $this->user->getUserById($user_sid);
        $roles = $this->master->getUserRolesJoin($user['user_sid']);
        $role = $roles[0]['ref_value'];
        $ulp = $this->master->getGenericBySid($user['user_unit']);
        $up3 = $this->master->getGenericBySid($ulp['parent_sid']);

        if ($user_sid) {

            $db = new JSON2SQL($db_path, 'users');
            $db->debugMode(false);
            // Unit 1
            $db->dropTable()->createTable(
                '[
                  {"user_sid" : "TEXT NOT NULL PRIMARY KEY"},
                  {"user_uid" : "TEXT"},
                  {"user_no_induk" : "TEXT"},
                  {"user_name" : "TEXT"},
                  {"user_phone" : "TEXT"},
                  {"user_email" : "TEXT"},
                  {"user_jabatan" : "TEXT"},
                  {"user_bagian" : "TEXT"},
                  {"user_unit" : "TEXT"},
                  {"user_login_name" : "TEXT"},
                  {"user_password" : "TEXT"},
                  {"user_role_sid" : "TEXT"},
                  {"last_login" : "TEXT"},
                  {"lat_login" : "TEXT"},
                  {"lon_login" : "TEXT"},
                  {"last_connect" : "TEXT"},
                  {"lat_connect" : "TEXT"},
                  {"lon_connect" : "TEXT"},
                  {"device_id" : "TEXT"},
                  {"device_info" : "TEXT"},
                  {"is_active" : "INTEGER NOT NULL"},
                  {"user_address" : "TEXT"},
                  {"date_created" : "TEXT"},
                  {"date_modified" : "TEXT"}
                ]'
            );
            $db->add(json_encode($this->db->get_where('users', array('user_sid' => $user_sid))->result_array()));

            $db = new JSON2SQL($db_path, 'users_roles');
            $db->debugMode(false);
            $db->dropTable()->createTable(
                '[
                  {"ur_sid" : "TEXT NOT NULL PRIMARY KEY"},
                  {"ur_user_sid" : "TEXT"},
                  {"ur_role_sid" : "TEXT"}
                ]'
            );
            $db->add(json_encode($this->db->get_where('users_roles', array('ur_user_sid' => $user_sid))->result_array()));

            /*CLIENT ACCESS MENU*/
            $db = new JSON2SQL($db_path, 'client_access_menu');
            $db->debugMode(false);
            $db->dropTable()->createTable(
                '[
                  {"access_sid" : "TEXT NOT NULL PRIMARY KEY"},
                  {"role_sid" : "TEXT"},
                  {"menu_sid" : "TEXT"},
                  {"`create`" : "INTEGER NOT NULL"},
                  {"`read`" : "INTEGER NOT NULL"},
                  {"`update`" : "INTEGER NOT NULL"},
                  {"`delete`" : "INTEGER NOT NULL"}
                ]'
            );
            $db->add(json_encode($this->db->get('client_access_menu')->result_array()));

            /*TABLE GENERIC CATEGORY*/
            $db = new JSON2SQL($db_path, 'generic_category');
            $db->debugMode(false);
            // Unit 1
            $db->dropTable()->createTable(
                '[
                  {"category_sid" : "TEXT NOT NULL PRIMARY KEY"},
                  {"category_name" : "TEXT"},
                  {"category_desc" : "TEXT"},
                  {"is_config_two_level" : "INTEGER NOT NULL"},
                  {"parent_sid" : "TEXT"},
                  {"date_created" : "TEXT"},
                  {"date_modified" : "TEXT"},
                  {"sort" : "INTEGER NOT NULL"}
                ]'
            );
            $db->add(json_encode($this->db->get('generic_category')->result_array()));

            /*TABLE GENERIC REFF*/
            $db = new JSON2SQL($db_path, 'generic_references');
            $db->debugMode(false);
            // Unit 1
            $db->dropTable()->createTable(
                '[
                  {"ref_sid" : "TEXT NOT NULL PRIMARY KEY"},
                  {"category_sid" : "TEXT"},
                  {"parent_sid" : "TEXT"},
                  {"ref_name" : "TEXT"},
                  {"ref_value" : "INTEGER NOT NULL"},
                  {"ref_description" : "TEXT"},
                  {"date_created" : "TEXT"},
                  {"date_modified" : "TEXT"}
                ]'
            );
            $db->add(json_encode($this->db->get('generic_references')->result_array()));

            /*ADDRESS ID*/
            $db = new JSON2SQL($db_path, 'address_id');
            $db->debugMode(false);
            $db->dropTable()->createTable('[
                    {"id" : "INTEGER NOT NULL PRIMARY KEY"},
                    {"kelurahan" : "TEXT"},
                    {"kecamatan" : "TEXT"},
                    {"kabupaten" : "TEXT"},
                    {"provinsi" : "TEXT"},
                    {"kodepos" : "TEXT"}
                ]'
            );
            $db->add(json_encode($this->db->get_where('address_id', array('provinsi'=>'SULAWESI UTARA'))->result_array()));
            // $db->add(json_encode($this->db->get('address_id')->result_array()));
            

            /*Application Info*/
            $db = new JSON2SQL($db_path, 'general_info');
            $db->debugMode(false);
            // Unit 1
            $db->dropTable()->createTable(
                '[
                  {"app_sid" : "TEXT NOT NULL PRIMARY KEY"},
                  {"app_name" : "TEXT"},
                  {"app_name_alt" : "TEXT"},
                  {"app_first_name" : "TEXT"},
                  {"app_last_name" : "TEXT"},
                  {"app_desc" : "TEXT"},
                  {"app_version" : "TEXT"},
                  {"phone" : "TEXT"},
                  {"email" : "TEXT"},
                  {"address" : "TEXT"},
                  {"icon" : "TEXT"},
                  {"active_status" : "INTEGER NOT NULL"},
                  {"update_date" : "TEXT"},
                  {"update_by" : "TEXT"}
                ]'
            );
            $db->add(json_encode($this->db->get('general_info')->result_array()));

            /*BASE64DATA*/
            $db = new JSON2SQL($db_path, 'base64_data');
            $db->debugMode(false);
            $db->dropTable()->createTable(
                '[
                  {"data_sid" : "TEXT NOT NULL PRIMARY KEY"},
                  {"parent_sid" : "TEXT"},
                  {"data" : "TEXT"},
                  {"data_path" : "TEXT"},
                  {"data_type" : "TEXT"},
                  {"data_value" : "TEXT"},
                  {"desc" : "TEXT"},
                  {"post_date" : "TEXT"},
                  {"post_by" : "TEXT"},
                  {"update_date" : "TEXT"},
                  {"update_by" : "TEXT"},
                  {"post_status" : "INTEGER NOT NULL"}
                ]'
            );

            $this->db->select('data_sid, parent_sid, data_path, data_type, data_value, desc, post_status');
            $this->db->from('base64_data');
            /*$this->db->join('data_to', 'data_to.data_to_sid = base64_data.parent_sid', 'left');
            $this->db->where('base64_data.post_by', $user_sid);
            $this->db->where('base64_data.parent_sid !=', null);
            $this->db->where('data_to.update_by', $user_sid);
            $this->db->where('data_to.status !=', $status_done['ref_sid']);*/
            $this->db->where('data_type', 'PROFILE_IMG');
            $this->db->or_where('data_type', 'CL_MENU');
            $db->add(json_encode($this->db->get()->result_array()));

            /*data_req*/
            $db = new JSON2SQL($db_path, 'data_req');
            $db->debugMode(false);
            $db->dropTable()->createTable(
                '[
                  {"req_sid" : "TEXT NOT NULL PRIMARY KEY"},
                  {"req_uid" : "TEXT"},
                  {"req_total" : "INTEGER NOT NULL"},
                  {"req_pemda" : "TEXT"},
                  {"req_lon" : "REAL NOT NULL"},
                  {"req_lat" : "REAL NOT NULL"},
                  {"req_address" : "TEXT"},
                  {"req_remark" : "TEXT"},
                  {"address_id" : "INTEGER NOT NULL"},
                  {"post_by" : "TEXT"},
                  {"post_date" : "TEXT"},
                  {"update_by" : "TEXT"},
                  {"update_date" : "TEXT"},
                  {"post_status" : "INTEGER NOT NULL"}
                ]'
            );
            /* if (intval($role) <= 3) { //pemda uid up3
                $query = "select * from data_req";
            }
            else { 
                $query = "select * from data_req where post_by = '$user_sid'";
            }
            $result = $this->db->query($query)->result_array();
            $db->add(json_encode($result)); */

            /*REQ STATUS*/
            $db = new JSON2SQL($db_path, 'data_req_status');
            $db->debugMode(false);
            $db->dropTable()->createTable('[
                  {"status_sid" : "TEXT NOT NULL PRIMARY KEY"},
                  {"req_sid" : "TEXT"},
                  {"status" : "TEXT"},
                  {"post_by" : "TEXT"},
                  {"post_date" : "TEXT"},
                  {"post_status" : "INTEGER NOT NULL"}
                ]'
            );
            /* $query = "select * from data_req_status";
            $result = $this->db->query($query)->result_array();
            $db->add(json_encode($result)); */

            /*data_srv*/
            $db = new JSON2SQL($db_path, 'data_srv');
            $db->debugMode(false);
            $db->dropTable()->createTable(
                '[
                  {"srv_sid" : "TEXT NOT NULL PRIMARY KEY"},
                  {"pju_sid" : "TEXT"},
                  {"srv_uid" : "TEXT"},
                  {"srv_ulp" : "TEXT"},
                  {"srv_pemda" : "TEXT"},
                  {"srv_meter_id" : "TEXT"},
                  {"srv_lamp_type" : "TEXT"},
                  {"srv_lamp_power" : "INTEGER NOT NULL"},
                  {"srv_lamp_cond" : "TEXT"},
                  {"srv_conn_type" : "TEXT"},
                  {"srv_conn_power" : "INTEGER NOT NULL"},
                  {"srv_power_house" : "TEXT"},
                  {"srv_power_line" : "TEXT"},
                  {"srv_lat" : "REAL NOT NULL"},
                  {"srv_lon" : "REAL NOT NULL"},
                  {"srv_address" : "TEXT"},
                  {"srv_remark" : "TEXT"},
                  {"address_id" : "INTEGER NOT NULL"},
                  {"post_by" : "TEXT"},
                  {"post_date" : "TEXT"},
                  {"update_by" : "TEXT"},
                  {"update_date" : "TEXT"},
                  {"post_status" : "INTEGER NOT NULL"}
                ]'
            );
            /* if (intval($role) <= 3) { //pemda uid up3
                $query = "select * from data_srv";
            }
            else { 
                $query = "select * from data_srv where post_by = '$user_sid'";
            }
            $result = $this->db->query($query)->result_array();
            $db->add(json_encode($result)); */

            /*srv STATUS*/
            $db = new JSON2SQL($db_path, 'data_srv_status');
            $db->debugMode(false);
            $db->dropTable()->createTable('[
                  {"status_sid" : "TEXT NOT NULL PRIMARY KEY"},
                  {"srv_sid" : "TEXT"},
                  {"status" : "TEXT"},
                  {"post_by" : "TEXT"},
                  {"post_date" : "TEXT"},
                  {"post_status" : "INTEGER NOT NULL"}
                ]'
            );
            /* $query = "select * from data_srv_status";
            $result = $this->db->query($query)->result_array();
            $db->add(json_encode($result)); */



            $this->zip->add_data($db_name, file_get_contents($db_path));
            $this->zip->archive($db_zip_path);

            $response['db_name'] = $db_name;
            $response['db_version'] = sqlite_db_version();
            $response['db_url'] = base_url('assets-' . app_version() . '/db/') . $db_name_zip;
            if (file_exists($db_path) && file_exists($db_zip_path)) {
                $this->response(true, 'Successfully fetched!', $response, Rest_lib::HTTP_OK);
                unset($db);
            }
        } else {
            $this->response(false, 'No data found!', null, Rest_lib::HTTP_OK);
        }
    }


    public function isUP3($sid)
    {
        $up3 = $this->master->getGenericBySid($sid);
        if (intval($up3['ref_value']) == 1) {
            return "1";
        }
        return "0";
    }

    public function getUP3($sid)
    {
        $up3 = $this->master->getGenericBySid($sid);
        return $up3['parent_sid'];
    }

    public function verify_request()
    {
        // Get all the headers
        $headers = $this->input->request_headers();
        // Extract the token
        $token = $headers['authorization'];

        // Use try-catch
        // JWT library throws exception if the token is not valid
        try {
            // Validate the token
            $data = auth::validateToken($token);
            if ($data == null) {
                $this->response(false, 'Unauthorized Access!', $data, Rest_lib::HTTP_UNAUTHORIZED);
                exit();
            } else if ($data === false) {
                $this->response(false, 'Unauthorized Access!', $data, Rest_lib::HTTP_UNAUTHORIZED);
                exit();
            } else {
                $this->db->where('user_sid', $data);
                $this->db->where('auth_token', $token);
                $user_token = $this->db->get('user_token')->row_array();
                if ($user_token['auth_token'] == $token) {
                    return null;
                } else {
                    header("Content-type:application/json");
                    header(http_response_code(401));
                    echo '{"status":false, "message":"Unauthorized Access!"}';
                    exit();
                }
            }
        } catch (Exception $e) {
            // Token is invalid
            header("Content-type:application/json");
            header(http_response_code(401));
            echo '{"status":false, "message":"Unauthorized Access!"}';
            exit();
        }
    }
}
