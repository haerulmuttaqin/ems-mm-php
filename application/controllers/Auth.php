<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("jwt");
        $this->load->library('user_agent');
    }

    public function index()
    {
        if ($this->agent->browser() == 'Internet Explorer') {
            $this->load->view('auth/not_support_browser');
        } else {
            if ($this->session->userdata('user_sid')) {
                redirect('dashboard');
            }
            $this->load->view('_partials/auth_header');
            $this->load->view('auth/login');
            $this->load->view('_partials/auth_footer');
        }
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $lon = "" . $this->input->post('lon');
        $lat = "" . $this->input->post('lat');
        $device = "" . $this->input->post('device');

        $user = $this->user->getUserByUsername($username);

        if ($user != null) {
            $roles = $this->master->getUserRolesJoin($user['user_sid']);
            $role = $roles[0];
            $user['user_role_sid'] = $role['ref_sid'];
            $user['user_role_name'] = $role['ref_name'];
            $user['user_role_value'] = $role['ref_value'];
            if (($role['ref_description'] == 'SUPER' || $role['ref_description'] == 'IS_ADMIN') && $user['is_active'] == 1) {
                if (password_verify($password, $user['user_password'])) {
                    $data = $user;
                    /*$result_data = $this->db->get_where('base64_data', array('parent_sid' => $user['user_sid']))->row_array();
                    if ($result_data['data'] != null) {
                        $data['profile_img'] = $result_data['data'];
                    }*/
                    /*$ulp = $this->master->getGenericBySid($user['user_unit']);
                    if ($ulp) {
                        $up3 = $this->master->getGenericBySid($ulp['parent_sid']);
                        $data['user_uiw'] = $up3['parent_sid'];
                        $data['user_up3'] = $up3['ref_sid'];
                    }*/
                    $data['user_token'] = $this->getUserToken($data['user_sid'])['auth_token'] || array();
                    if ($data['user_token'] == null) {
                        $token = $this->generateToken($data['user_sid']);
                        $data['user_token'] = $token;
                        $this->db->insert('user_token', array(
                            'token_sid' => $this->uuid->sid(),
                            'user_sid' => $data['user_sid'],
                            'auth_token' => $token,
                            'date_created' => get_times_now(),
                            'ip_address' => $this->input->ip_address(),
                            'device_platform' => $this->agent->platform(),
                        ));
                    }
                    $this->updateUserLoginInfo($user['user_sid'], $lon, $lat, $device);
                    $this->session->set_userdata($data);
                    echo json_encode(array(
                        'status' => true,
                        'message' => 'Login succesfully!',
                        'user_data' => array($data),
                        'app_data' => array(
                            'app_version' => app_version(),
                            'app_name' => app_name()
                        )
                    ));
                } else {
                    echo json_encode(array('status' => false, 'message' => ' - Username or password is wrong! Error Trace ID #2072'));
                }
            } else {
                echo json_encode(array('status' => false, 'message' => ' - You is not registered! (You are not an Admin) Error Trace ID #2071'));
            }
        } else {
            echo json_encode(array('status' => false, 'message' => ' - Username or password is wrong! Error Trace ID #2072'));
        }
    }

    public function get_token()
    {
        $user = $this->session->userdata();
        $roles = $this->master->getUserRolesJoin($user['user_sid']);
        $role = $roles[0];
        $user['user_role_sid'] = $role['ref_sid'];
        $user['user_role_name'] = $role['ref_name'];
        $user['user_role_value'] = $role['ref_value'];
        if ($role['ref_description'] == 'IS_ADMIN' && $user['is_active'] == 1) {
            $ulp = $this->master->getGenericBySid($user['user_unit']);
            $up3 = $this->master->getGenericBySid($ulp['parent_sid']);
            $data = $user;
            $data['user_uiw'] = $up3['parent_sid'];
            $data['user_up3'] = $up3['ref_sid'];
            $data['user_token'] = $this->getUserToken($data['user_sid'])['auth_token'];
            if ($data['user_token'] == null) {
                $token = $this->generateToken($data['user_sid']);
                $data['user_token'] = $token;
            }
            echo json_encode(array(
                'status' => true,
                'message' => 'Login succesfully!',
                'user_data' => array($data),
                'app_data' => array(
                    'app_version' => app_version(),
                    'app_name' => app_name()
                )
            ));
        } else {
            echo json_encode(array('status' => false, 'message' => ' - You is not registered! (You are not an Admin) Error Trace ID #2071'));
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('user_sid');

        $this->toastr->success('You have been logged out!');

        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function updateUserLoginInfo($user_sid, $lon = null, $lat = null, $device = null)
    {
        $this->db->where('user_sid', $user_sid);
        $this->db->update(
            'users',
            array(
                'last_login' => get_times_now(),
                'lat_login' => $lat,
                'lon_login' => $lon,
                'lat_connect' => $lat,
                'lon_connect' => $lon,
                'device_info' => $device
            )
        );
    }

    public function getUserToken($user_sid)
    {
        return $this->db->get_where('user_token', array('user_sid' => $user_sid))->row_array();
    }

    public function generateToken($data)
    {
        return JWT::encode($data, $this->config->item('jwt_key'));
    }
}
