<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller
{
    public function index()
    {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'tls://smtp.migadu.com',
            'smtp_port' => 465,
            'smtp_user' => 'info.smokol@pasbe.id', // change it to yours
            'smtp_pass' => '123456', // change it to yours
            'mailtype' => 'html',
            'charset' => 'utf-8', //iso-8859-1
            'wordwrap' => TRUE,
            'newline' => "\r\n"
        );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('info.smokol@pasbe.id');
        $this->email->to('haerul.muttaqin@gmail.com');
        $this->email->subject("INFO SMOKOL");
        $this->email->message('TESTING');
        //$this->email->attach($path.'/'.$file_name);

        if($this->email->send())
        {
            echo 'Email send.';
        }
        else
        {
            show_error($this->email->print_debugger());
        }
    }
}