<?php
require APPPATH . 'libraries/Rest_lib.php';

class Address extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        //$this->verify_request();
        $user_sid = null;
    }

    /*public function index_post()
    {
        $uid = $this->generate_number();
        $input = $this->request->body;
        $input['asset_uid'] = $uid;
        $this->db->insert('data_asset', $input);
        $data = array('uid' => $uid);
        $this->response(true, 'Successfully inserted!', $data, Rest_lib::HTTP_OK);
    }*/

    public function index_get($id = null) {
        if ($id != null) {
            $data = $this->db->get_where('address', array('id'=>$id))->row_array();
        } else {
            $this->response(true, 'Address id cannot be null', null, Rest_lib::HTTP_OK);
        }
        $this->response(true, 'Fetch successfully!', $data, Rest_lib::HTTP_OK);
    }

    public function generate_number()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(asset_uid,6)) AS kd_max FROM data_asset");
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
                    $this->user_sid = $data;
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