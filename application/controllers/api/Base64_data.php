<?php
require APPPATH . 'libraries/Rest_lib.php';

class Base64_data extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        /* $this->verify_request(); */ 
    }

    public function index_post()
    {
        $input = $this->request->body;
        $input['post_status'] = 1;
        $this->_deleteDataDocIfExist($input['data_sid']);
        $this->db->insert('base64_data', $input);
        $this->response(true, 'Successfully inserted!', null, Rest_lib::HTTP_OK);
    }

    private function _deleteDataDocIfExist($id)
    {
        $query = "DELETE FROM base64_data where data_sid = '$id'";
        $this->db->query($query);
        return true;
    }

    public function index_get($id)
    {
        $data = $this->db->get_where('base64_data', array('data_sid' => $id))->row_array();
        echo json_encode($data);
    }

    public function parent_get($id, $single = null)
    {
        if ($single == 'single') {
            $data = $this->db->get_where('base64_data', array('parent_sid' => $id))->row_array();
        } else {
            $data = $this->db->get_where('base64_data', array('parent_sid' => $id))->result_array();
        }
        echo json_encode($data);
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
            }
            else if ($data === false) {
                $this->response(false, 'Unauthorized Access!', $data, Rest_lib::HTTP_UNAUTHORIZED);
                exit();
            }
            else {
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