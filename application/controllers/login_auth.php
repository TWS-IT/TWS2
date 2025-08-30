<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database(); 
        $this->load->library(['session']);
        $this->load->helper(['url', 'security']);
    }

    public function index() {
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $ip_address = $this->input->ip_address();
    $user_agent = $this->input->user_agent();

    $hashed_password = sha1($password);

    $user = $this->db->get_where('employee', [
        'em_email' => $email,
        'em_password' => $hashed_password,
        'status' => 'ACTIVE'
    ])->row();

    $login_status = $user ? 'SUCCESS' : 'FAILED';

    
    $this->db->set([
        'em_email' => $email,
        'ip_address' => $ip_address,
        'user_agent' => $user_agent,
        'login_status' => $login_status
    ]);
    // $this->db->set('login_time', 'NOW()', false);
    // $this->db->insert('login_log');

    if ($user) {
        $this->session->set_userdata('user_id', $user->id);
        $this->session->set_userdata('em_email', $user->em_email);
        redirect('dashboard');
    } else {
        $this->session->set_flashdata('feedback', 'Invalid email or password');
        redirect('login');
    }
}



//  public function view_logs() {
//         $data['logs'] = $this->db->order_by('login_time', 'DESC')->get('login_log')->result();
//         $this->load->view('log_report', $data);
//     }
//      public function Sup_logs() {
//         $data['logs'] = $this->db->order_by('login_time', 'DESC')->get('login_log')->result();
//         $this->load->view('log_report', $data);
//     }
}



   
