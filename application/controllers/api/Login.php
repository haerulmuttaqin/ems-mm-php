<?php
require APPPATH . 'libraries/Rest_lib.php';

class Login extends Rest_lib
{
    public function index_post()
    {
        $input = $this->request->body;

        if (!isset($input['lat_login']) || !isset($input['lon_login'])) {
            $status = false;
            $user = array(null);
            $message = "Login failed, Your location is not detected, please enable GPS!";
        }
        else if (!isset($input['device_info'])) {
            $status = false;
            $user = array(null);
            $message = "Login failed, Your device is not supported, please contact the Administrator!";
        }

        $lat = isset($input['lat_login']) ? $input['lat_login'] : '';
        $lon = isset($input['lon_login']) ? $input['lon_login'] : '';

        $username = $input['user_login_name'];
        $password = $input['user_password'];
        $device = $input['device_info'];

        $user = $this->user->getUserByUsername($username);
        if ($user == null) {
            $status = false;
            $user = array(null);
            $message = "Login failed, your account is not registered!";
        }
        else if ($user['is_active'] == 1) {
            if (password_verify($password, $user['user_password'])) {

                $this->db->where('user_sid', $user['user_sid']);
                $delete = $this->db->delete('user_token');
                if ($delete) {
                    $token = $this->createToken($user['user_sid']);
                    $createToken = $this->db->insert('user_token', array(
                        'token_sid' => $this->uuid->sid(),
                        'user_sid' => $user['user_sid'],
                        'auth_token' => $token,
                        'date_created' => get_times_now(),
                        'ip_address' => $this->input->ip_address(),
                        'device_platform' => $this->agent->platform(),
                    ));
                    if ($createToken) {
                        $this->updateUserLoginInfo($user['user_sid'], $lat, $lon, $device);
                        $status = true;
                        $user['token_auth'] = $token;
                        if ($user['last_connect'] == null) {
                            $user['last_connect'] = get_times_now();
                        }
                        $message = "Login successfully!";
                    } else {
                        $status = false;
                        $user = array(null);
                        $message = "Login failed, please try again!";
                    }
                } else {
                    $status = false;
                    $user = array(null);
                    $message = "Login failed, please try again!";
                }
            } else {
                $status = false;
                $user = array(null);
                $message = "Login failed, Incorrect username or password!";
            }
        } else {
            $status = false;
            $user = array(null);
            $message = "Login failed, your account has not activated!";
        }

        $this->response($status, $message, $user, Rest_lib::HTTP_OK);
    }

    public function updateUserLoginInfo($user_sid, $lon = null, $lat = null, $device = null) {
        $this->db->where('user_sid', $user_sid);
        $this->db->update('users',
            array(
                'last_login'  => get_times_now(),
                'lat_login'   => $lat,
                'lon_login'   => $lon,
                'last_connect'=> get_times_now(),
                'lat_connect' => $lat,
                'lon_connect' => $lon,
                'device_info' => $device
            ));
    }

    public function createToken($param)
    {
        return auth::generateToken($param);
    }

    public function get_me_data_post()
    {
        // Call the verification method and store the return value in the variable
        $this->verify_request();
        $response = array('user' => '');
        $this->response(true, 'Successfully verification all data!', $response, Rest_lib::HTTP_OK);

        // Send the return data as reponse

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
            // Successfull validation will return the decoded user data else returns false
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
                return $data;
            }
        } catch (Exception $e) {
            // Token is invalid
            // Send the unathorized access message
            header("Content-type:application/json");
            header(http_response_code(401));
            echo '{"status":false, "message":"Unauthorized Access!"}';
            exit();
        }
    }
}

