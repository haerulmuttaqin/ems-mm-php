<?php
require APPPATH . 'libraries/Rest_lib.php';

class User extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        $this->verify_request();
    }

    public function index_get($id = NULL)
    {
        if (!empty($id)) {
            $data = $this->db->get_where("users", array('user_sid' => $id))->row_array();
        } else {
            $data = $this->db->get("users")->result();
        }
        if ($data) {
            $this->response(true, 'Successfully fetched!', $data, Rest_lib::HTTP_OK);
        } else {
            $data = null;
            $this->response(true, 'No data found!', $data, Rest_lib::HTTP_OK);
        }
    }

    public function index_post()
    {
        /* $input = $this->request->body;
        $input['user_sid'] = $this->uuid->sid();
        $input['user_uid'] = uid_generator('MNJ');
        $input['date_created'] = get_times_now();
        $password = $input['user_password'];
        $input['user_password'] = password_hash($password, PASSWORD_DEFAULT);
        $this->db->insert('users', $input);
        $this->response(true, 'Successfully inserted!', null, Rest_lib::HTTP_OK); */
    }

    public function index_put($id)
    {
        $input = $this->put();
        $user_login_name = $input['user_login_name'];
        $user_name = $input['user_name'];
        $phone = $input['user_phone'];
        $email = $input['user_email'];
        $unit = $input['user_unit'];
        $user_address = $input['user_address'];
        $time = get_times_now();
        $query = "UPDATE users SET user_phone='$phone', user_email = '$email', user_unit = '$unit', user_name = '$user_name', user_login_name = '$user_login_name', user_address = '$user_address', date_modified = '$time' WHERE user_sid = '$id'";
        $this->db->query($query);
        if ($this->db->affected_rows() > 0) {
            $this->response(true, 'Successfully updated!', null, Rest_lib::HTTP_OK);
        } else {
            $this->response(false, 'Update Failure!', null, Rest_lib::HTTP_OK);
        }
    }

    public function user_sync_post($id)
    {
        /*$input = $this->put();
        $this->db->update('users', $input, array('user_sid' => $id));
        $this->response(true, 'Successfully updated!', null, Rest_lib::HTTP_OK);*/

        $input = $this->request->body;
        $last_connect = $input['user_email'];
        $query = "UPDATE users SET last_connect='$last_connect' WHERE user_sid = '$id'";
        $this->db->query($query);
        if ($this->db->affected_rows() > 0) {
            $this->response(true, 'Successfully updated!', null, Rest_lib::HTTP_OK);
        } else {
            $this->response(true, 'Update Failure!', null, Rest_lib::HTTP_OK);
        }
    }

    public function index_delete($id)
    {
        if ($id !== 'delete_all') {
            $this->db->delete('users', array('user_sid' => $id));
            $this->response(true, 'Successfully deleted!', null, Rest_lib::HTTP_OK);
        } else {
            $this->db->query('DELETE FROM users');
            $this->response(true, 'Successfully deleted all data!', null, Rest_lib::HTTP_OK);
        }
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