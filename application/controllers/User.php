<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Cropper_model', 'crop');
        $this->load->model('Base64_model', 'image');
        $this->load->model('Error_model', 'error');
    }

    public function index()
    {
        check_menu_access();
        $data['title'] = 'Users Data';
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $this->load->view('_partials/header', $data);
        $this->load->view('user/index', $data);
    }

    public function error()
    {
        check_menu_access();
        $data['title'] = 'Users Error Log';
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $this->load->view('_partials/header', $data);
        $this->load->view('user/error', $data);
    }

    public function add()
    {
        $data['title'] = 'Users Data';
        $data['menu'] = $this->menu->getMenu();
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));
        $data['user'] = null;
        $data['unit_region'] = $this->master->getGenericByCategoryName('UNIT');
        $data['user_roles'] = $this->master->getGenericByCategoryName('USER ROLE');

        $this->form_validation->set_rules('no_induk', 'No Induk', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('role', 'Hak User', 'required');
        $this->form_validation->set_rules('unit', 'Unit', 'required');
        $this->form_validation->set_rules('user_login_name', 'Username Login', 'required|is_unique[users.user_login_name]');
        $this->form_validation->set_rules('password1', 'Password Login', 'min_length[4]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'min_length[4]|matches[password1]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header', $data);
            $this->load->view('user/add', $data);
            $this->load->view('_partials/footer', $data);
        } else {
            $user_sid_new = $this->uuid->sid();
            $this->db->insert('users', array(
                'user_sid' => $user_sid_new,
                'user_uid' => $this->user->get_no_user(),
                'user_no_induk' => strtoupper(trim(htmlspecialchars($this->input->post('no_induk')))),
                'user_name' => strtoupper(trim(htmlspecialchars($this->input->post('nama')))),
                'user_phone' => trim(htmlspecialchars($this->input->post('hp'))),
                'user_email' => trim(htmlspecialchars($this->input->post('email'))),
                'user_jabatan' => trim(htmlspecialchars($this->input->post('jabatan'))),
                'user_bagian' => trim(htmlspecialchars($this->input->post('bagian'))),
                'user_unit' => trim(htmlspecialchars($this->input->post('unit'))),
                'user_login_name' => trim(htmlspecialchars($this->input->post('user_login_name'))),
                'user_password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'user_role_sid' => $this->input->post('role'),
                'is_active' => trim(htmlspecialchars($this->input->post('active'))),
                'date_created' => get_times_now()
            ));
            $this->db->insert('users_roles', array(
                'ur_sid' => $this->uuid->sid(),
                'ur_user_sid' => $user_sid_new,
                'ur_role_sid' => $this->input->post('role')
            ));
//            foreach ($this->input->post('roles') as $selectedOption) {
//                $this->db->insert('users_roles', array(
//                    'ur_sid' => $this->uuid->sid(),
//                    'ur_user_sid' => $user_sid_new,
//                    'ur_role_sid' => $selectedOption
//                ));
//            }
            $this->toastr->success('New data added!');
            redirect('user');

        }
    }

    public function update($id = NULL)
    {
        $data['title'] = 'Users Data';
        $data['menu'] = $this->menu->getMenu();
        $data['user'] = $this->user->getUserById($id);
        $data['unit_region'] = $this->master->getGenericByCategoryName('UNIT');
        $data['user_roles'] = $this->master->getGenericByCategoryName('USER ROLE');
        $data['user_role'] = $this->master->getUserRoles($id);
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));

        $this->form_validation->set_rules('no_induk', 'No Induk', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('role', 'Hak User', 'required');
        $this->form_validation->set_rules('unit', 'Unit', 'required');
        $this->form_validation->set_rules('password1', 'Password Login', 'min_length[4]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'min_length[4]|matches[password1]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header', $data);
            $this->load->view('user/update', $data);
            $this->load->view('_partials/footer', $data);
        } else {
            $this->db->where('user_sid', $this->input->post('id'));
            if ($this->input->post('password1')) {
                $this->db->update('users', array(
                    'user_no_induk' => strtoupper(trim(htmlspecialchars($this->input->post('no_induk')))),
                    'user_name' => strtoupper(trim(htmlspecialchars($this->input->post('nama')))),
                    'user_phone' => trim(htmlspecialchars($this->input->post('hp'))),
                    'user_email' => trim(htmlspecialchars($this->input->post('email'))),
                    'user_jabatan' => trim(htmlspecialchars($this->input->post('jabatan'))),
                    'user_bagian' => trim(htmlspecialchars($this->input->post('bagian'))),
                    'user_unit' => trim(htmlspecialchars($this->input->post('unit'))),
                    'user_login_name' => trim(htmlspecialchars($this->input->post('user_login_name'))),
                    'user_role_sid' => $this->input->post('role'),
                    'user_password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                    'is_active' => trim(htmlspecialchars($this->input->post('active'))),
                    'date_modified' => get_times_now()
                ));
            } else {
                $this->db->update('users', array(
                    'user_no_induk' => strtoupper(trim(htmlspecialchars($this->input->post('no_induk')))),
                    'user_name' => strtoupper(trim(htmlspecialchars($this->input->post('nama')))),
                    'user_phone' => trim(htmlspecialchars($this->input->post('hp'))),
                    'user_email' => trim(htmlspecialchars($this->input->post('email'))),
                    'user_jabatan' => trim(htmlspecialchars($this->input->post('jabatan'))),
                    'user_bagian' => trim(htmlspecialchars($this->input->post('bagian'))),
                    'user_unit' => trim(htmlspecialchars($this->input->post('unit'))),
                    'user_login_name' => trim(htmlspecialchars($this->input->post('user_login_name'))),
                    'user_role_sid' => $this->input->post('role'),
                    'is_active' => trim(htmlspecialchars($this->input->post('active'))),
                    'date_modified' => get_times_now()
                ));
            }
            if ($this->_deleteRoleByUserSid($this->input->post('id'))) {
//                foreach ($this->input->post('hak') as $selectedOption) {
//                    $this->db->insert('users_roles', array(
//                        'ur_sid' => $this->uuid->sid(),
//                        'ur_user_sid' => $this->input->post('id'),
//                        'ur_role_sid' => $this->input->post('role')
//                    ));
//                }
                $this->db->insert('users_roles', array(
                    'ur_sid' => $this->uuid->sid(),
                    'ur_user_sid' => $this->input->post('id'),
                    'ur_role_sid' => $this->input->post('role')
                ));
            }
            $this->toastr->success('Data updated!');
            redirect('user');
        }
    }

    public function profile()
    {
        check_menu_access();
        $data['title'] = 'Profile';
        $data['menu'] = $this->menu->getMenu();
        $data['user'] = $this->user->getUserById($this->session->userdata('user_sid'));
//        $data['ulp'] = $this->master->getGenericByCategoryName('ULP');
//        $data['jabatan'] = $this->master->getGenericByCategoryName('JABATAN');
//        $data['bagian'] = $this->master->getGenericByCategoryName('BAGIAN');
        $data['hak_user'] = $this->master->getGenericByCategoryName('USER ROLE');
        $data['user_roles'] = $this->master->getUserRolesJoin($this->session->userdata('user_sid'));
        $data['user_data'] = $this->user->getUserById($this->session->userdata('user_sid'));

        $this->form_validation->set_rules('no_induk', 'No Induk', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('user_login_name', 'Username', 'required');
//        $this->form_validation->set_rules('hp', 'No Hanphone', 'required');
//        $this->form_validation->set_rules('email', 'Email', 'required');
        // $this->form_validation->set_rules('hak[]', 'Hak User', 'required');
        // $this->form_validation->set_rules('unit', 'Unit', 'required');
        $this->form_validation->set_rules('password1', 'Password Login', 'min_length[4]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'min_length[4]|matches[password1]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('_partials/header', $data);
            $this->load->view('user/profile', $data);
            $this->load->view('_partials/footer');
        } else {
            $this->db->where('user_sid', $this->input->post('id'));
            if ($this->input->post('password1')) {
                $this->db->update('users', array(
                    'user_name' => strtoupper(trim(htmlspecialchars($this->input->post('nama')))),
                    'user_phone' => trim(htmlspecialchars($this->input->post('hp'))),
                    'user_email' => trim(htmlspecialchars($this->input->post('email'))),
                    'user_jabatan' => trim(htmlspecialchars($this->input->post('jabatan'))),
                    'user_bagian' => trim(htmlspecialchars($this->input->post('bagian'))),
                    'user_login_name' => trim(htmlspecialchars($this->input->post('user_login_name'))),
                    'user_password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                    'is_active' => trim(htmlspecialchars($this->input->post('active'))),
                    'date_modified' => get_times_now()
                ));
            } else {
                $this->db->update('users', array(
                    'user_no_induk' => strtoupper(trim(htmlspecialchars($this->input->post('no_induk')))),
                    'user_name' => strtoupper(trim(htmlspecialchars($this->input->post('nama')))),
                    'user_phone' => trim(htmlspecialchars($this->input->post('hp'))),
                    'user_email' => trim(htmlspecialchars($this->input->post('email'))),
                    'user_jabatan' => trim(htmlspecialchars($this->input->post('jabatan'))),
                    'user_bagian' => trim(htmlspecialchars($this->input->post('bagian'))),
                    'is_active' => trim(htmlspecialchars($this->input->post('active'))),
                    'user_login_name' => trim(htmlspecialchars($this->input->post('user_login_name'))),
                    'date_modified' => get_times_now()
                ));
            }
            if($this->db->affected_rows() > 0) {
                $this->toastr->success('Data updated!');
                redirect('user/profile');
            } else {
                $this->toastr->error('Error updated!');
                redirect('user/profile');
            }
        }
    }

    public function upload() {
        $json = array();
        $avatar_src = $this->input->post('avatar_src');
        $avatar_data = $this->input->post('avatar_data');
        $avatar_file = $_FILES['avatar_file'];
        $user_sid = $this->input->post('user_sid');
        $upltype = $this->input->post('upltype');

        $originalPath = FCPATH . '/assets-'.app_version().'/uploads/img/';
        $thumbPath = FCPATH . '/assets-'.app_version().'/uploads/img/';
        $urlPath = FCPATH . '/assets-'.app_version().'/uploads/img/';

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
            'user_sid' => $user_sid,
            'urlPath' => $urlPath,
        );
        echo json_encode($json);
    }

    public function uploadCropImg() {
        $json = array();
        $user_sid = $this->input->post('user_sid');
        $base64 = $this->input->post('base64');
        $path = $this->input->post('path');
        $thumb = $this->input->post('thumb');
        if (!empty($user_sid)) {
            if ($this->_deleteDataByParentIfExist($user_sid)) {
                $this->db->insert('base64_data', array(
                    'data_sid' => $this->uuid->sid(),
                    'parent_sid' => $user_sid,
                    'data' => $base64,
                    'data_path' => $path,
                    'date_created' => get_times_now(),
                    'post_by' => $this->session->userdata('user_sid'),
                    'post_status' => 1,
                ));
            }
            $array = array(
                'profile_img' => $base64
            );
            $this->session->set_userdata($array);
            unlink(FCPATH . '/assets-'.app_version().'/uploads/img/' . $thumb);
            unlink(FCPATH . '/assets-'.app_version().'/uploads/img/' . str_replace('.png', '', $thumb) . '-original.png');
            $json['success'] = 'success';
        }  else {
            $json['success'] = 'failed';
        }
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    private function _deleteDataByParentIfExist($id) {
        $query = "DELETE FROM base64_data where parent_sid = '$id'";
        $this->db->query($query);
        return true;
    }

    private function _deleteRoleByUserSid($id) {
        $query = "DELETE FROM users_roles where ur_user_sid = '$id'";
        $this->db->query($query);
        return true;
    }

    public function delete() {
        $this->db->delete('users', array(
            'user_sid' => $this->input->get('delete_id'),
        ));
        $this->toastr->success('User deleted!');
        redirect('user');
    }

    public function data(){
        $data = $row = array();
        $role = $this->db->get_where('generic_references',
            array('ref_sid' => $this->session->userdata('user_role_sid'))
        )->row_array();
        $_POST['role'] = $role['ref_value'];
        $_POST['unit'] = $this->master->getGenericBySid($this->session->userdata('user_unit'));
        $i = $_POST['start'];
        $memData = $this->user->getRows($_POST);
        foreach($memData as $member){
            $i++;
            $userRole = "";
            foreach ($this->master->getUserRolesJoin($member->user_sid) as $itemRole) {
                $userRole .= '<span><small class="badge badge-light badge-sm" style="border: 0.5px #1f2d3d solid;">'. $itemRole['ref_name'] .'</small></span> ';
            }
            $data[] = array(
                $i,
                $member->user_uid,
                $member->user_no_induk,
                $member->user_name,
                '<span class="badge badge-secondary">' . $member->parent_name . '</span>'.' '. $member->unit,
                '<span>'.$userRole.'</span>',
                $member->is_active,
                $member->user_sid,
                $member->user_role_sid,
                $member->last_login,
                $member->last_connect
            );
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->countAll(),
            "recordsFiltered" => $this->user->countFiltered($_POST),
            "data" => $data,
        );
        // Output to JSON format
        echo json_encode($output);
    }

    public function error_data(){
        $data = $row = array();
        $role = $this->db->get_where('generic_references',
            array('ref_sid' => $this->session->userdata('user_role_sid'))
        )->row_array();
        $_POST['role'] = $role['ref_value'];
        $_POST['unit'] = $this->master->getGenericBySid($this->session->userdata('user_unit'));
        $i = $_POST['start'];
        $memData = $this->error->getRows($_POST);
        foreach($memData as $member){
            $i++;
            $data[] = array(
                $i,
                $member->message,
                '<span class="text-sm">Error ID</span> : ' .$member->error_id. '<br><span class="text-sm">Error URL</span> : ' . $member->url,
                '<span class="text-sm">Post Date</span> : ' .$member->post_date. '<br><span class="text-sm">Post By</span> : ' . $member->user_name,
                $member->error_id
            );
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->error->countAll(),
            "recordsFiltered" => $this->error->countFiltered($_POST),
            "data" => $data,
        );
        // Output to JSON format
        echo json_encode($output);
    }

    public function delete_error($id)
    {
        $query = "DELETE FROM error_log where error_id = '$id'";
        $this->db->query($query);
        echo json_encode(true);
    }

    function updateLastConnect($last_date) {
        $user_sid = $this->session->userdata('user_sid');
        $this->db->where('user_sid', $user_sid);
        $this->db->update('users', array(
            'last_connect' => get_times_now()
        ));
        if ($this->db->affected_rows() > 0) {
            echo 'success';
        }
    }

    function getUserLastConnect() {
        $user_sid = $this->session->userdata('user_sid');
        $user = $this->db->get_where('users', array('user_sid' => $user_sid))->row_array();
        return $user['last_connect'];
    }

    public function image($id) {
        $data = $this->image->getDataByParentId($id);
        if ($data == null) {
            echo json_encode(array('data'=>'/9j/4Qn5RXhpZgAATU0AKgAAAAgADAEAAAMAAAABAOEAAAEBAAMAAAABAOEAAAECAAMAAAADAAAAngEGAAMAAAABAAIAAAESAAMAAAABAAEAAAEVAAMAAAABAAMAAAEaAAUAAAABAAAApAEbAAUAAAABAAAArAEoAAMAAAABAAIAAAExAAIAAAAeAAAAtAEyAAIAAAAUAAAA0odpAAQAAAABAAAA6AAAASAACAAIAAgACvyAAAAnEAAK/IAAACcQQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykAMjAyMDowMToyNiAwMjozNzo0NwAAAAAEkAAABwAAAAQwMjIxoAEAAwAAAAH//wAAoAIABAAAAAEAAAC8oAMABAAAAAEAAAC7AAAAAAAAAAYBAwADAAAAAQAGAAABGgAFAAAAAQAAAW4BGwAFAAAAAQAAAXYBKAADAAAAAQACAAACAQAEAAAAAQAAAX4CAgAEAAAAAQAACHMAAAAAAAAASAAAAAEAAABIAAAAAf/Y/+0ADEFkb2JlX0NNAAL/7gAOQWRvYmUAZIAAAAAB/9sAhAAMCAgICQgMCQkMEQsKCxEVDwwMDxUYExMVExMYEQwMDAwMDBEMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMAQ0LCw0ODRAODhAUDg4OFBQODg4OFBEMDAwMDBERDAwMDAwMEQwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCACfAKADASIAAhEBAxEB/90ABAAK/8QBPwAAAQUBAQEBAQEAAAAAAAAAAwABAgQFBgcICQoLAQABBQEBAQEBAQAAAAAAAAABAAIDBAUGBwgJCgsQAAEEAQMCBAIFBwYIBQMMMwEAAhEDBCESMQVBUWETInGBMgYUkaGxQiMkFVLBYjM0coLRQwclklPw4fFjczUWorKDJkSTVGRFwqN0NhfSVeJl8rOEw9N14/NGJ5SkhbSVxNTk9KW1xdXl9VZmdoaWprbG1ub2N0dXZ3eHl6e3x9fn9xEAAgIBAgQEAwQFBgcHBgU1AQACEQMhMRIEQVFhcSITBTKBkRShsUIjwVLR8DMkYuFygpJDUxVjczTxJQYWorKDByY1wtJEk1SjF2RFVTZ0ZeLys4TD03Xj80aUpIW0lcTU5PSltcXV5fVWZnaGlqa2xtbm9ic3R1dnd4eXp7fH/9oADAMBAAIRAxEAPwD1VJJJJSkkkklKTKL7WsGvPggPtc74eCSk7rWN0J18AhnIP5o+9C+CSSmXrW+MfJN6j/3imSSUy9R/7x+9L1bPFRSSUlbkH84fMIjbq3cH79FWSSU3ElVba5ug+Uo7LGvEj7klM0kkklKSSSSU/wD/0PVUkkklKQbLoO1v0vFK62Pa3nufBBSUqTJPc8lJJJJSkkkznNY0vc4Na3lx0ASUukqNvWMVsirdeRyW+1v+c76SrP63f+bTW34lx/Ikp10lkt63aNX0sd/VcWn8S5Waer4lhDX7qHH9/Vv+e1JTdSSGoBGoPBGs/NJJSkgSIjQjhJJJSeu3d7XaFEVRHqs3DafpBJSVJMnSU//R9VULH7Gz37KSrWP3u8klMTPcye5SSSSUpJJITOnPZJSLJyK8ap1lh/kho5c79wLCycu7KfvtPt5ZX+a3+r/5kidRyfXynAfzdRLK/kfc/wDzlWSUskkkkpSXwSSSU2MTMuxHyz31n6VROh/q/uvW7TdXfU22s7munyII+k138pq5pXuk5JryfRcf0d+keDm+5p/76kp2kkkklKSBIII0ISSSU2mPD2yPmFJVqXw8N7FWUlP/0vUrXbWE/JVkXIOgb46lCSUpJJJJSlC6w1U2WDljXEfGNFNV8/8AoN/9T+ISU8+NGgf668/9JJOmSUpJJJJSkkkklKThxY5rx9JhDm/IpkzuD8ElPUyCA4cET96ShV/M1/1G/kU0lKSSSSUr8FZY7cwHv3VZGxzoR80lP//T9MuP6Q/BQUrf5xyikpSSSSSlIWUw2Yt7QJljv70VZ3W5FVLvB7m/eB/ckpyPPxSTpklKSSSSUpJJJJSkiJG0cu0Hz0/iknGhnSex7hJT0wbsaGcbQBHwCdUukl5wpe5zy57vc4yREBXUlKSSSSUpEoPvjyQ1On+cHz/Ikp//1PS7P5x3xlRU7h758QoJKUkkkkpSo9YY5+IHAT6bwXeTSNrnf5yvJdjpI7jxSU8ukrPUMf7Plva0RW/31/1T/wCRcq2nZJSkkkklKSSSSUpIkDU9kld6Vji3IL3jdXSJ2kaFx+i1JTpdNrLMGprhBdLiPJx3t/6JVlL8UklKSSSSUpTp/nB5SoIlA98+ASU//9X0/IGgI7IKtPbuaR9yqpKUkkkkpSSSSSmn1PF+0Y+5om2mXCOS3/CMWGDIHwXUCZ0+9YXUsYY+T7P5u0F7B4a+5qSmokkkkpSSSXPkkpUwJ/3ldBg4xxsYVn6bvc8+Z4H9hZvScX1rvWeP0dJ083n83+ytopKUkkkkpSSSSSlI1DYaT4/wQY+86BWmtDWgeCSn/9b1RV7mhh3dj2VlRe0PaWngpKaqSTgWkg8jSUklKSSShJSlldcPvoH8l2vzatQkAFxIaG8uJgD5rA6hkjJyS8D9GwbKx4t7n+0kprpJJJKUl2SSSU7HRD+q2N/ds/6oLQWJ0zLZj2uZadtVsAuP5rh9Fy2wQ4bmw5p7tMj8ElKSSGvCSSlJJJ2gudA+aSmdLNx3HgflVhRY0NG0cBSSU//X9VSSSSUjsr3jTRw4KrxBjgjSFcVbMx7bqXCi30Le1gAOn7pSUhttqpbuue2seLjz8vpKhd1moSMasvP779G/5v0nLOyab6bduQ0i493EncP3mP8AzkKZ7ykpLfk35Jm95fHDeGj+rWhJJJKUkkkkpSSSSSlKdVttDt1L3MPfaY+8fRUEklOjT1q0GMhgsb+8z2n/ADfoLRozMXI0qsG79x3td/muXOouPj3ZVgrqbvfzJ+i0fvOP5qSnowDMRqdIOhViusMbHfuUHBxDi0hjrXXP7ucZA/k1zO2tWklKSSSSU//Q9VSSSSUpJJJJSLIxqcis13ND29vEf1T+asTL6FfV7sZ3rV9mO0eP++2LoE2iSnjXBzHFljSxw5a7Q/8AS2pl1uWMI1xmen6Z49WAJ8t6y7um9IfJqyW1Hysa4fc8/wDfklOMkr7+lVj+bzqHDtuIb+RzkI9PsHF+M7/rsf8AfUlNVJWh0+w834o/67/5ijM6XUT+kzqG/wBUh3/VOakpoaJ62PteK6gXvP5rRP5FsU9O6MzW3JbaR2dY1rfuYR/1S08X7JsjF9PZ39OI/wCikpxsToV1hDst3pM/0QguP9Z35i3KMenHrFdLAxg7D+KnpHknSUtCdJJJSkkkklP/2f/tEcpQaG90b3Nob3AgMy4wADhCSU0EBAAAAAAADxwBWgADGyVHHAIAAAIAAAA4QklNBCUAAAAAABDNz/p9qMe+CQVwdq6vBcNOOEJJTQQ6AAAAAAELAAAAEAAAAAEAAAAAAAtwcmludE91dHB1dAAAAAUAAAAAUHN0U2Jvb2wBAAAAAEludGVlbnVtAAAAAEludGUAAAAAQ2xybQAAAA9wcmludFNpeHRlZW5CaXRib29sAAAAAAtwcmludGVyTmFtZVRFWFQAAAAUAEMAYQBuAG8AbgAgAGkAUAAyADcAMAAwACAAcwBlAHIAaQBlAHMAAAAAAA9wcmludFByb29mU2V0dXBPYmpjAAAADABQAHIAbwBvAGYAIABTAGUAdAB1AHAAAAAAAApwcm9vZlNldHVwAAAAAQAAAABCbHRuZW51bQAAAAxidWlsdGluUHJvb2YAAAAJcHJvb2ZDTVlLADhCSU0EOwAAAAACLQAAABAAAAABAAAAAAAScHJpbnRPdXRwdXRPcHRpb25zAAAAFwAAAABDcHRuYm9vbAAAAAAAQ2xicmJvb2wAAAAAAFJnc01ib29sAAAAAABDcm5DYm9vbAAAAAAAQ250Q2Jvb2wAAAAAAExibHNib29sAAAAAABOZ3R2Ym9vbAAAAAAARW1sRGJvb2wAAAAAAEludHJib29sAAAAAABCY2tnT2JqYwAAAAEAAAAAAABSR0JDAAAAAwAAAABSZCAgZG91YkBv4AAAAAAAAAAAAEdybiBkb3ViQG/gAAAAAAAAAAAAQmwgIGRvdWJAb+AAAAAAAAAAAABCcmRUVW50RiNSbHQAAAAAAAAAAAAAAABCbGQgVW50RiNSbHQAAAAAAAAAAAAAAABSc2x0VW50RiNQeGxAUgAAAAAAAAAAAAp2ZWN0b3JEYXRhYm9vbAEAAAAAUGdQc2VudW0AAAAAUGdQcwAAAABQZ1BDAAAAAExlZnRVbnRGI1JsdAAAAAAAAAAAAAAAAFRvcCBVbnRGI1JsdAAAAAAAAAAAAAAAAFNjbCBVbnRGI1ByY0BZAAAAAAAAAAAAEGNyb3BXaGVuUHJpbnRpbmdib29sAAAAAA5jcm9wUmVjdEJvdHRvbWxvbmcAAAAAAAAADGNyb3BSZWN0TGVmdGxvbmcAAAAAAAAADWNyb3BSZWN0UmlnaHRsb25nAAAAAAAAAAtjcm9wUmVjdFRvcGxvbmcAAAAAADhCSU0D7QAAAAAAEABIAAAAAQACAEgAAAABAAI4QklNBCYAAAAAAA4AAAAAAAAAAAAAP4AAADhCSU0EDQAAAAAABAAAAB44QklNBBkAAAAAAAQAAAAeOEJJTQPzAAAAAAAJAAAAAAAAAAABADhCSU0nEAAAAAAACgABAAAAAAAAAAI4QklNA/UAAAAAAEgAL2ZmAAEAbGZmAAYAAAAAAAEAL2ZmAAEAoZmaAAYAAAAAAAEAMgAAAAEAWgAAAAYAAAAAAAEANQAAAAEALQAAAAYAAAAAAAE4QklNA/gAAAAAAHAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAOEJJTQQIAAAAAAAQAAAAAQAAAkAAAAJAAAAAADhCSU0EHgAAAAAABAAAAAA4QklNBBoAAAAAA10AAAAGAAAAAAAAAAAAAAC7AAAAvAAAABQAdQBzAGUAcgAtAHAAcgBvAGYAaQBsAGUALQBkAGUAZgBhAHUAbAB0AAAAAQAAAAAAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAC8AAAAuwAAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAABAAAAABAAAAAAAAbnVsbAAAAAIAAAAGYm91bmRzT2JqYwAAAAEAAAAAAABSY3QxAAAABAAAAABUb3AgbG9uZwAAAAAAAAAATGVmdGxvbmcAAAAAAAAAAEJ0b21sb25nAAAAuwAAAABSZ2h0bG9uZwAAALwAAAAGc2xpY2VzVmxMcwAAAAFPYmpjAAAAAQAAAAAABXNsaWNlAAAAEgAAAAdzbGljZUlEbG9uZwAAAAAAAAAHZ3JvdXBJRGxvbmcAAAAAAAAABm9yaWdpbmVudW0AAAAMRVNsaWNlT3JpZ2luAAAADWF1dG9HZW5lcmF0ZWQAAAAAVHlwZWVudW0AAAAKRVNsaWNlVHlwZQAAAABJbWcgAAAABmJvdW5kc09iamMAAAABAAAAAAAAUmN0MQAAAAQAAAAAVG9wIGxvbmcAAAAAAAAAAExlZnRsb25nAAAAAAAAAABCdG9tbG9uZwAAALsAAAAAUmdodGxvbmcAAAC8AAAAA3VybFRFWFQAAAABAAAAAAAAbnVsbFRFWFQAAAABAAAAAAAATXNnZVRFWFQAAAABAAAAAAAGYWx0VGFnVEVYVAAAAAEAAAAAAA5jZWxsVGV4dElzSFRNTGJvb2wBAAAACGNlbGxUZXh0VEVYVAAAAAEAAAAAAAlob3J6QWxpZ25lbnVtAAAAD0VTbGljZUhvcnpBbGlnbgAAAAdkZWZhdWx0AAAACXZlcnRBbGlnbmVudW0AAAAPRVNsaWNlVmVydEFsaWduAAAAB2RlZmF1bHQAAAALYmdDb2xvclR5cGVlbnVtAAAAEUVTbGljZUJHQ29sb3JUeXBlAAAAAE5vbmUAAAAJdG9wT3V0c2V0bG9uZwAAAAAAAAAKbGVmdE91dHNldGxvbmcAAAAAAAAADGJvdHRvbU91dHNldGxvbmcAAAAAAAAAC3JpZ2h0T3V0c2V0bG9uZwAAAAAAOEJJTQQoAAAAAAAMAAAAAj/wAAAAAAAAOEJJTQQRAAAAAAABAQA4QklNBBQAAAAAAAQAAAACOEJJTQQMAAAAAAiPAAAAAQAAAKAAAACfAAAB4AABKiAAAAhzABgAAf/Y/+0ADEFkb2JlX0NNAAL/7gAOQWRvYmUAZIAAAAAB/9sAhAAMCAgICQgMCQkMEQsKCxEVDwwMDxUYExMVExMYEQwMDAwMDBEMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMAQ0LCw0ODRAODhAUDg4OFBQODg4OFBEMDAwMDBERDAwMDAwMEQwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCACfAKADASIAAhEBAxEB/90ABAAK/8QBPwAAAQUBAQEBAQEAAAAAAAAAAwABAgQFBgcICQoLAQABBQEBAQEBAQAAAAAAAAABAAIDBAUGBwgJCgsQAAEEAQMCBAIFBwYIBQMMMwEAAhEDBCESMQVBUWETInGBMgYUkaGxQiMkFVLBYjM0coLRQwclklPw4fFjczUWorKDJkSTVGRFwqN0NhfSVeJl8rOEw9N14/NGJ5SkhbSVxNTk9KW1xdXl9VZmdoaWprbG1ub2N0dXZ3eHl6e3x9fn9xEAAgIBAgQEAwQFBgcHBgU1AQACEQMhMRIEQVFhcSITBTKBkRShsUIjwVLR8DMkYuFygpJDUxVjczTxJQYWorKDByY1wtJEk1SjF2RFVTZ0ZeLys4TD03Xj80aUpIW0lcTU5PSltcXV5fVWZnaGlqa2xtbm9ic3R1dnd4eXp7fH/9oADAMBAAIRAxEAPwD1VJJJJSkkkklKTKL7WsGvPggPtc74eCSk7rWN0J18AhnIP5o+9C+CSSmXrW+MfJN6j/3imSSUy9R/7x+9L1bPFRSSUlbkH84fMIjbq3cH79FWSSU3ElVba5ug+Uo7LGvEj7klM0kkklKSSSSU/wD/0PVUkkklKQbLoO1v0vFK62Pa3nufBBSUqTJPc8lJJJJSkkkznNY0vc4Na3lx0ASUukqNvWMVsirdeRyW+1v+c76SrP63f+bTW34lx/Ikp10lkt63aNX0sd/VcWn8S5Waer4lhDX7qHH9/Vv+e1JTdSSGoBGoPBGs/NJJSkgSIjQjhJJJSeu3d7XaFEVRHqs3DafpBJSVJMnSU//R9VULH7Gz37KSrWP3u8klMTPcye5SSSSUpJJITOnPZJSLJyK8ap1lh/kho5c79wLCycu7KfvtPt5ZX+a3+r/5kidRyfXynAfzdRLK/kfc/wDzlWSUskkkkpSXwSSSU2MTMuxHyz31n6VROh/q/uvW7TdXfU22s7munyII+k138pq5pXuk5JryfRcf0d+keDm+5p/76kp2kkkklKSBIII0ISSSU2mPD2yPmFJVqXw8N7FWUlP/0vUrXbWE/JVkXIOgb46lCSUpJJJJSlC6w1U2WDljXEfGNFNV8/8AoN/9T+ISU8+NGgf668/9JJOmSUpJJJJSkkkklKThxY5rx9JhDm/IpkzuD8ElPUyCA4cET96ShV/M1/1G/kU0lKSSSSUr8FZY7cwHv3VZGxzoR80lP//T9MuP6Q/BQUrf5xyikpSSSSSlIWUw2Yt7QJljv70VZ3W5FVLvB7m/eB/ckpyPPxSTpklKSSSSUpJJJJSkiJG0cu0Hz0/iknGhnSex7hJT0wbsaGcbQBHwCdUukl5wpe5zy57vc4yREBXUlKSSSSUpEoPvjyQ1On+cHz/Ikp//1PS7P5x3xlRU7h758QoJKUkkkkpSo9YY5+IHAT6bwXeTSNrnf5yvJdjpI7jxSU8ukrPUMf7Plva0RW/31/1T/wCRcq2nZJSkkkklKSSSSUpIkDU9kld6Vji3IL3jdXSJ2kaFx+i1JTpdNrLMGprhBdLiPJx3t/6JVlL8UklKSSSSUpTp/nB5SoIlA98+ASU//9X0/IGgI7IKtPbuaR9yqpKUkkkkpSSSSSmn1PF+0Y+5om2mXCOS3/CMWGDIHwXUCZ0+9YXUsYY+T7P5u0F7B4a+5qSmokkkkpSSSXPkkpUwJ/3ldBg4xxsYVn6bvc8+Z4H9hZvScX1rvWeP0dJ083n83+ytopKUkkkkpSSSSSlI1DYaT4/wQY+86BWmtDWgeCSn/9b1RV7mhh3dj2VlRe0PaWngpKaqSTgWkg8jSUklKSSShJSlldcPvoH8l2vzatQkAFxIaG8uJgD5rA6hkjJyS8D9GwbKx4t7n+0kprpJJJKUl2SSSU7HRD+q2N/ds/6oLQWJ0zLZj2uZadtVsAuP5rh9Fy2wQ4bmw5p7tMj8ElKSSGvCSSlJJJ2gudA+aSmdLNx3HgflVhRY0NG0cBSSU//X9VSSSSUjsr3jTRw4KrxBjgjSFcVbMx7bqXCi30Le1gAOn7pSUhttqpbuue2seLjz8vpKhd1moSMasvP779G/5v0nLOyab6bduQ0i493EncP3mP8AzkKZ7ykpLfk35Jm95fHDeGj+rWhJJJKUkkkkpSSSSSlKdVttDt1L3MPfaY+8fRUEklOjT1q0GMhgsb+8z2n/ADfoLRozMXI0qsG79x3td/muXOouPj3ZVgrqbvfzJ+i0fvOP5qSnowDMRqdIOhViusMbHfuUHBxDi0hjrXXP7ucZA/k1zO2tWklKSSSSU//Q9VSSSSUpJJJJSLIxqcis13ND29vEf1T+asTL6FfV7sZ3rV9mO0eP++2LoE2iSnjXBzHFljSxw5a7Q/8AS2pl1uWMI1xmen6Z49WAJ8t6y7um9IfJqyW1Hysa4fc8/wDfklOMkr7+lVj+bzqHDtuIb+RzkI9PsHF+M7/rsf8AfUlNVJWh0+w834o/67/5ijM6XUT+kzqG/wBUh3/VOakpoaJ62PteK6gXvP5rRP5FsU9O6MzW3JbaR2dY1rfuYR/1S08X7JsjF9PZ39OI/wCikpxsToV1hDst3pM/0QguP9Z35i3KMenHrFdLAxg7D+KnpHknSUtCdJJJSkkkklP/2QA4QklNBCEAAAAAAFUAAAABAQAAAA8AQQBkAG8AYgBlACAAUABoAG8AdABvAHMAaABvAHAAAAATAEEAZABvAGIAZQAgAFAAaABvAHQAbwBzAGgAbwBwACAAQwBTADYAAAABADhCSU0EBgAAAAAABwAEAAAAAQEA/+EMtWh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8APD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4zLWMwMTEgNjYuMTQ1NjYxLCAyMDEyLzAyLzA2LTE0OjU2OjI3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06RG9jdW1lbnRJRD0iQkNGQTU3RTk2NDFBMjY1QkM4RDU2RUNFNUY3RjkzQjkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MDEyODYzMkFBQTNGRUExMUFGRUNFQjhEMTM5MjQ0MjYiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0iQkNGQTU3RTk2NDFBMjY1QkM4RDU2RUNFNUY3RjkzQjkiIGRjOmZvcm1hdD0iaW1hZ2UvanBlZyIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyIgeG1wOkNyZWF0ZURhdGU9IjIwMjAtMDEtMjZUMDI6MzY6MDkrMDc6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDIwLTAxLTI2VDAyOjM3OjQ3KzA3OjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDIwLTAxLTI2VDAyOjM3OjQ3KzA3OjAwIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6MDEyODYzMkFBQTNGRUExMUFGRUNFQjhEMTM5MjQ0MjYiIHN0RXZ0OndoZW49IjIwMjAtMDEtMjZUMDI6Mzc6NDcrMDc6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDwvcmRmOlNlcT4gPC94bXBNTTpIaXN0b3J5PiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8P3hwYWNrZXQgZW5kPSJ3Ij8+/+4ADkFkb2JlAGQAAAAAAf/bAIQABgQEBAUEBgUFBgkGBQYJCwgGBggLDAoKCwoKDBAMDAwMDAwQDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAEHBwcNDA0YEBAYFA4ODhQUDg4ODhQRDAwMDAwREQwMDAwMDBEMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwM/8AAEQgAuwC8AwERAAIRAQMRAf/dAAQAGP/EAaIAAAAHAQEBAQEAAAAAAAAAAAQFAwIGAQAHCAkKCwEAAgIDAQEBAQEAAAAAAAAAAQACAwQFBgcICQoLEAACAQMDAgQCBgcDBAIGAnMBAgMRBAAFIRIxQVEGE2EicYEUMpGhBxWxQiPBUtHhMxZi8CRygvElQzRTkqKyY3PCNUQnk6OzNhdUZHTD0uIIJoMJChgZhJRFRqS0VtNVKBry4/PE1OT0ZXWFlaW1xdXl9WZ2hpamtsbW5vY3R1dnd4eXp7fH1+f3OEhYaHiImKi4yNjo+Ck5SVlpeYmZqbnJ2en5KjpKWmp6ipqqusra6voRAAICAQIDBQUEBQYECAMD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'));
        } else {
            echo json_encode($data);
        }
    }

}