<?php

function check_menu_access()
{
    $ci = get_instance();
    $ci->load->helper('url');

    if (!$ci->session->userdata('user_sid')) {
        redirect('auth');
    } else {
        $menu = strtoupper(str_replace(base_url(), '', current_url()));
        $queryMenu = $ci->db->get_where('user_sub_menu', array('UPPER(url)' => $menu))->row_array();
        $menu_sid = $queryMenu['sub_sid'];
        $userAccess = $ci->db->get_where('user_access_menu', array('role_sid' => $ci->session->userdata('user_role_sid'), 'menu_sid' => $menu_sid));
        if ($userAccess->num_rows() < 1 && !in_array($menu, menu_bypass_block())) {
            redirect('auth/blocked');
        }
    }
}

function is_logged_in()
{
    $ci = get_instance();
    $ci->load->helper('url');
    if (!$ci->session->userdata('user_sid')) {
        $ci->session->set_userdata(array('redirec_url' => current_url()));
        redirect('auth');
    }
}

function formatRp($angka){
    return number_format($angka,0,',','.');
}

function menu_bypass_block()
{
    return array(
        'role',
        'user',
        'dashboard',
    );
}
function format_date($var)
{
    return date('d/m/Y H:i:s', strtotime($var));
}
function is_wrog_id($id)
{
    $result = false;
    $ref = str_split($id, 1);
    foreach ($ref as $item) {
        if ($item == '+') {
            $result = true;
            return $result;
        }
    }
    return $result;
}
function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_sid', $role_id);
    $ci->db->where('menu_sid', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
    return "";
}

function get_access_client_sid($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_sid', $role_id);
    $ci->db->where('menu_sid', $menu_id);
    $result = $ci->db->get('client_access_menu');
    $access = $result->row_array();
    if ($result->num_rows() > 0) {
        return $access['access_sid'];
    }
    return "";
}

function check_access_client($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_sid', $role_id);
    $ci->db->where('menu_sid', $menu_id);
    $result = $ci->db->get('client_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
    return "";
}

function check_access_client_create($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_sid', $role_id);
    $ci->db->where('menu_sid', $menu_id);
    $ci->db->where('create', 1);
    $result = $ci->db->get('client_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
    return "";
}
function check_access_client_read($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_sid', $role_id);
    $ci->db->where('menu_sid', $menu_id);
    $ci->db->where('read', 1);
    $result = $ci->db->get('client_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
    return "";
}
function check_access_client_update($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_sid', $role_id);
    $ci->db->where('menu_sid', $menu_id);
    $ci->db->where('update', 1);
    $result = $ci->db->get('client_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
    return "";
}
function check_access_client_delete($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_sid', $role_id);
    $ci->db->where('menu_sid', $menu_id);
    $ci->db->where('delete', 1);
    $result = $ci->db->get('client_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
    return "";
}

function put_user_last_connect($user_sid, $last_connect, $lat = null, $lon = null)
{
    $ci = get_instance();

    $ci->db->where('user_sid', $user_sid);
    $ci->db->update('users', array(
        'last_connect' => $last_connect,
        'lat_connect' => $lat,
        'lon_connect' => $lon
    ));
}
function get_ulp_user()
{
    $ci = get_instance();
    $ci->db->where('ref_sid', $ci->session->userdata('user_unit'));
    return $ci->db->get('generic_references')->row_array();
}
function uid_generator($field, $table)
{
    $ci = get_instance();
    $q = $ci->db->query("SELECT MAX(RIGHT(" . $field . ",6)) AS kd_max FROM " . $table . "");
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%06s", $tmp);
        }
    } else {
        $kd = "000001";
    }
    return date('Ymd', time()) . $kd;
}
function new_pju_uid()
{
    $ci = get_instance();
    $q = $ci->db->query("SELECT MAX(RIGHT(pju_uid,6)) AS kd_max FROM data_pju");
    $kd = "";
    if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
            $tmp = ((int)$k->kd_max) + 1;
            $kd = sprintf("%06s", $tmp);
        }
    } else {
        $kd = "000001";
    }
    return $kd;
}
function get_times_now($format = NULL)
{
    date_default_timezone_set('Asia/Jakarta');
    if ($format) {
        return date($format, time());
    } else {
        return date('Y-m-d H:i:s', time());
    }
}

function get_date_now($format = NULL)
{
    date_default_timezone_set('Asia/Jakarta');
    if ($format) {
        return date($format, time());
    } else {
        return date('Y-m-d', time());
    }
}

function get_month_now($format = NULL)
{
    date_default_timezone_set('Asia/Jakarta');
    if ($format) {
        return date($format, time());
    } else {
        return date('m', time());
    }
}

function get_year_now($format = NULL)
{
    date_default_timezone_set('Asia/Makassar');
    if ($format) {
        return date($format, time());
    } else {
        return date('Y', time());
    }
}

function role_level_indicator($val, $type)
{
    $line = '';
    if ($val == 0) {
        $line .= "▪";
    } else {
        $line .= "";
    }
    for ($i = 0; $i < $val; $i++) {
        if ($type == 'IS_ADMIN') {
            if ($val != 0) {
                $line .= "━━";
            } else {
                $line = "";
            }
        } else {
            if ($i >= 4) {
                $line .= "";
            } else {
                $line .= "━━";
            }
        }
    }
    return $line;
}
function getImage()
{
    return 'iVBORw0KGgoAAAANSUhEUgAAAjMAAAOLCAMAAACSYvJcAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAxBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NzI4RTIyRTg0NDczMTFFQUEyMTFBMUYxMzJBRTEyQzEiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NzI4RTIyRTc0NDczMTFFQUEyMTFBMUYxMzJBRTEyQzEiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiBXaW5kb3dzIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9IkNEMTZDQTAwMEVCQTM5RDI5M0I3Rjc2REE1NDAwNDFBIiBzdFJlZjpkb2N1bWVudElEPSJDRDE2Q0EwMDBFQkEzOUQyOTNCN0Y3NkRBNTQwMDQxQSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PkkmtUoAAAIiUExURf///9bW1tDQ0Pr6+vz7+8vLy83Nzfv7+8jI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';
}
function app_name()
{
    return get_instance()->config->app_name();
}
function app_name_alt()
{
    return get_instance()->config->app_name_alt();
}
function app_version()
{
    return get_instance()->config->app_version();
}
function sqlite_db_version()
{
    return get_instance()->config->sqlite_db_version();
}
function get_no_image()
{
    return 'iVBORw0KGgoAAAANSUhEUgAAAjMAAAJcCAMAAAA7LtV/AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QjBBQ0NDODM2MjIxMTFFQTg5NkZFQzYzMDc4QkE2RDkiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QjBBQ0NDODQ2MjIxMTFFQTg5NkZFQzYzMDc4QkE2RDkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpCMEFDQ0M4MTYyMjExMUVBODk2RkVDNjMwNzhCQTZEOSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpCMEFDQ0M4MjYyMjExMUVBODk2RkVDNjMwNzhCQTZEOSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PktE0UwAAAEyUExURb+/v76+vrm5ub29vcDAwOzs7Ly8vLKysv///7i4uPv7+8zMzP39/d7e3vb29rCwsLq6uvr6+q+vr7S0tP7+/rW1tfLy8sHBwcLCwq6urra2trGxsbu7u/j4+PHx8be3t9XV1cfHx+Pj47Ozs+jo6Pz8/Obm5qurq9DQ0Nra2vn5+ff39/X19cnJye/v7/T09K2traysrMvLy83Nzefn5/Dw8MPDw93d3e7u7tjY2OTk5PPz86qqqtzc3OXl5cjIyOLi4sTExN/f36enp6mpqdvb2+np6evr69LS0u3t7dHR0erq6tPT087OztfX1+Hh4aioqMXFxdbW1uDg4M/Pz9TU1MbGxqOjo6ampsrKyqSkpJ2dnaWlpaKioqCgoJ+fn5qampWVldnZ2Z6enpycnP///5mY8QQAAABmdFJOU///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////ADWOqLcAACLjSURBVHja7J0He9tIlmgLRBEgFQiSIgUmK1GygoMkux3boR267c45zczuvrD8/39hUREFkvZIft98b9o6p9u2RJAgJRzeunUrUMwALofgVwA4AzgDOAM4AzgDgDOAM4AzgDOAMwA4AzgDOAM4AzgDOAOAM4AzgDOAM4AzADgDOAM4AzgDOAOAM4AzgDOAM4AzgDMAOAM4AzgDOAM4A4AzgDOAM4AzgDOAM/wKAGcAZwBnAGcAZwBwBnAGcAZwBnAGAGcAZwBnAGcAZwBnAHAGcAZwBnAGcAYAZwBnAGcAZwBnAHAGcAZwBnAGcAZwBgBnAGcAZwBnAGcAcAZwBnAGcAZwBnCGXwHgDOAM4AzgDOAMAM4AzgDOAM4AzgDgDOAM4AzgDOAM4AwAzgDOAM4AzgDOAOAM4AzgDOAM4AwAzgDOAM4AzgDOAM4A4AzgDOAM4AzgDADOAM4AzgDOAM4AzvArAJwBnAGcAZwBnAHAGcAZwBnAGcAZAJwBnAGcAZwBnAGcAcAZwBnAGcAZwBkAnAGcAZwBnAGcAcAZwBnAGcAZwBnAGQCcAZwBnAGcAZwBwBnAGcAZwBnAGcAZfgWAM4AzgDOAM4AzADgDOAM4AzgDOAOAM4AzgDOAM4AzgDMA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OgVZtVe7M7u4M7N9M7C55W+vH0VqxLLuM2nTTn3ULdMVnkPe2l9fv3wwqK+vL9Eh6Lyre+y3Pu5fHesOPpytnYEfKti9Qj83znwwKinaLUJV66is7uEMvA89NFmLorneF87Ae9omP3NrsIUzcLFIY7pJ1d4XzsA/iTX1+tZV+5lxBnAGcAZwBnAGcAYAZ6pd44vcbV1VXDpL7jt/W+di58OZvy6tcMr4e5TRE/LqwVRhx/xty+6DMx8V6xcbTcQZnPEMartmV5H309nRs4VxBmfUPOAtv4Tyn4IzOKPm7x4Vf3bemR+33uFDecTc1vFjTIEzV2fPz6vkTCeq7an1+urarq96dXZWixSntROOUK+qCb3Wh8oRdVt9tfp9eaePfK+iq+jMnl6yFukVTfu+A7Wlvqqr5dy7fh2CnktufKgeKW7bC+fMWGf2oyVbIOHMR8CqvqTHZlLdwHWgdtQig1U9S3O2F5kVB4Ez1SN1u1Gamjmz6/PkreKbLXXj1ZjjeYWcafkFcS3dnx6UDVZxue2iWXMwcKZ6pO72RVOnWQ+86rhOegtnPqrijLFkV6/Eb9kO1J7da8YSaa8CZ6pH6mUk2VGn0/dplSuooqsQaK6QMwO7a8O6seTIrPNftbfu7ayurq5vrS46Ex6pl9vVmDxI3afIcOqW3auQ0VwdZ4rLu6M3odoxEcZ0oFqmNdnyq2bnnakeCWOP3aHP7ktzBfaduXrO7AQX9shnwcf6IncGRWbbmrX2d+admTvyDmcG6549nPmYijO7q4ZdW6JRCUmkY86e38Rod86ZuSOBM6qo7J2ZXSWujDN7ZSbSMZlqp7joe+Zyr7smpTUfZ+aO1Mv9anRapO+zdSV6S1fQmd1gU9cdU6LZqe0cmX6OjxRHi85UjtTt9mh6iyw/9j1wYnUGO/S1P6biTDk2uW8anLraSaZl82MVPvRm0FVn5o74rayKHpLdDd88/EhvtLfrNkfDmY+A40oZZmC6xAO/w+9qocLxUVRbXehrV4/U9Ycb6JQo2p/5/GZP72+16gt+OPNxFGd2Fg1a98GnY/Y5O+4sOFM9om4zC27NtkQuJza7GX3kexVdvb72P2u89tf3Whc70iluWJBj6+PfqwhnAGcAZwBnAGcAZwBwBnAGcAZwBnAGAGcAZwBnAGcAZwBwBnAGcAZwBnAGcAYAZwBnAGcAZwBnAHAGcAZwBnAGcAZwBgBnAGcAZwBnAGcAcAZwBnAGcAZwBgBnAGcAZwBnAGcAZwBwBnAGcAZwBnAGAGcAZwBnAGcAZwBwBnAGcAZwBnAGcAYAZwBnAGcAZwBnAHAGcAZwBnAGcAZwBgBnAGcAZwBnAGcAcAZwBnAGcAZwBgBnAGcAZwBnAGcAZwBwBnAGcAZwBnAGAGcAZwBnAGcAZwBwBnAGcAZwBnAGcAYAZwBnAGcAZwBnAHAGcAZwBnAGcAZwBgBnAGcAZwBnAGcAcAZwBnAGcAZwBgBnAGcAZwBnAGcAZwBwBnAGcAZwBnAGAGcAZwBnAGcAZwBwBnAGcAZwBnAGcAYAZwBnAGcAZwBnAHAGcAZwBnAGcAZwBgBnAGcAZwBnAGcAcAZwBnAGcAZwBgBnAGcAZwBnAGcAZwBwBnAGcAZwBnAGAGcAZwBnAGcAZwBwBnAGcAb+/fgfAQYAaxwlng+BeoUAAAAASUVORK5CYII=';
}
function get_no_image_profile()
{
    return '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CgABAAAAAAAAAAI4QklNA/UAAAAAAEgAL2ZmAAEAbGZmAAYAAAAAAAEAL2ZmAAEAoZmaAAYAAAAAAAEAMgAAAAEAWgAAAAYAAAAAAAEANQAAAAEALQAAAAYAAAAAAAE4QklNA/gAAAAAAHAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAOEJJTQQIAAAAAAAQAAAAAQAAAkAAAAJAAAAAADhCSU0EHgAAAAAABAAAAAA4QklNBBoAAAAAA10AAAAGAAAAAAAAAAAAAAC7AAAAvAAAABQAdQBzAGUAcgAtAHAAcgBvAGYAaQBsAGUALQBkAGUAZgBhAHUAbAB0AAAAAQAAAAAAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAC8AAAAuwAAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAABAAAAABAAAAAAAAbnVsbAAAAAIAAAAGYm91bmRzT2JqYwAAAAEAAAAAAABSY3QxAAAABAAAAABUb3AgbG9uZwAAAAAAAAAATGVmdGxvbmcAAAAAAAAAAEJ0b21sb25nAAAAuwAAAABSZ2h0bG9uZwAAALwAAAAGc2xpY2VzVmxMcwAAAAFPYmpjAAAAAQAAAAAABXNsaWNlAAAAEgAAAAdzbGljZUlEbG9uZwAAAAAAAAAHZ3JvdXBJRGxvbmcAAAAAAAAABm9yaWdpbmVudW0AAAAMRVNsaWNlT3JpZ2luAAAADWF1dG9HZW5lcmF0ZWQAAAAAVHlwZWVudW0AAAAKRVNsaWNlVHlwZQAAAABJbWcgAAAABmJvdW5kc09iamMAAAABAAAAAAAAUmN0MQAAAAQAAAAAVG9wIGxvbmcAAAAAAAAAAExlZnRsb25nAAAAAAAAAABCdG9tbG9uZwAAALsAAAAAUmdodGxvbmcAAAC8AAAAA3VybFRFWFQAAAABAAAAAAAAbnVsbFRFWFQAAAABAAAAAAAATXNnZVRFWFQAAAABAAAAAAAGYWx0VGFnVEVYVAAAAAEAAAAAAA5jZWxsVGV4dElzSFRNTGJvb2wBAAAACGNlbGxUZXh0VEVYVAAA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PHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4zLWMwMTEgNjYuMTQ1NjYxLCAyMDEyLzAyLzA2LTE0OjU2OjI3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06RG9jdW1lbnRJRD0iQkNGQTU3RTk2NDFBMjY1QkM4RDU2RUNFNUY3RjkzQjkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MDEyODYzMkFBQTNGRUExMUFGRUNFQjhEMTM5MjQ0MjYiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0iQkNGQTU3RTk2NDFBMjY1QkM4RDU2RUNFNUY3RjkzQjkiIGRjOmZvcm1hdD0iaW1hZ2UvanBlZyIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyIgeG1wOkNyZWF0ZURhdGU9IjIwMjAtMDEtMjZUMDI6MzY6MDkrMDc6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDIwLTAxLTI2VDAyOjM3OjQ3KzA3OjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDIwLTAxLTI2VDAyOjM3OjQ3KzA3OjAwIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6MDEyODYzMkFBQTNGRUExMUFGRUNFQjhEMTM5MjQ0MjYiIHN0RXZ0OndoZW49IjIwMjAtMDEtMjZUMDI6Mzc6NDcrMDc6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDwvcmRmOlNlcT4gPC94bXBNTTpIaXN0b3J5PiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8P3hwYWNrZXQgZW5kPSJ3Ij8+/+4ADkFkb2JlAGQAAAAAAf/bAIQABgQEBAUEBgUFBgkGBQYJCwgGBggLDAoKCwoKDBAMDAwMDAwQDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAEHBwcNDA0YEBAYFA4ODhQUDg4ODhQRDAwMDAwREQwMDAwMDBEMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwM/8AAEQgAuwC8AwERAAIRAQMRAf/dAAQAGP/EAaIAAAAHAQEBAQEAAAAAAAAAAAQFAwIGAQAHCAkKCwEAAgIDAQEBAQEAAAAAAAAAAQACAwQFBgcICQoLEAACAQMDAgQCBgcDBAIGAnMBAgMRBAAFIRIxQVEGE2EicYEUMpGhBxWxQiPBUtHhMxZi8CRygvElQzRTkqKyY3PCNUQnk6OzNhdUZHTD0uIIJoMJChgZhJRFRqS0VtNVKBry4/PE1OT0ZXWFlaW1xdXl9WZ2hpamtsbW5vY3R1dnd4eXp7fH1+f3OEhYaHiImKi4yNjo+Ck5SVlpeYmZqbnJ2en5KjpKWmp6ipqqusra6voRAAICAQIDBQUEBQYECAMD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';
}
function get_image_by_parent($id)
{
    $ci = get_instance();

    $query = $ci->db->get_where('base64_data', array('parent_sid' => $id))->row_array();
    return $query['data'];
}
