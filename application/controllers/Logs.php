<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('log_model');
    }

    public function index() {
        
        $user = $this->session->userdata('user');
        if (!$user || !in_array($user['em_role'], ['ADMIN', 'SUPER ADMIN'])) {
            show_error('You are not authorized to view this page.', 403);
            return;
        }

        $data['logs'] = $this->log_model->get_all_logs();
        $this->load->view('logs_view', $data);
    }
}
