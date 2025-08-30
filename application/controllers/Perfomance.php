<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perfomance extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Perfomance_model');
        $this->load->model('settings_model');
        $this->load->model('atas_model');
        $this->load->model('W_model');
        $this->load->model('W1W_Deposit_Model');
        $this->load->model('w1w_w_Model');
        $this->load->model('employee_model');
        $this->load->model('leave_model');
        $this->load->helper(array('form', 'url'));
        
        $this->load->library('session');

        if (!$this->session->userdata('user_login_access')) {
            redirect('login');
        }
    }

   public function index()
{
    // Get all performance data
    $performance_data = $this->Perfomance_model->get_all_performance_data();

    // Make sure mistakes is always set for each record
    foreach ($performance_data as &$record) {
        $record['mistakes'] = isset($record['mistakes']) ? $record['mistakes'] : 0;
    }

    $data['performance_data'] = $performance_data;

    $this->load->view('backend/header');
    $this->load->view('backend/perfomance', $data);
    $this->load->view('backend/footer');
}

}

?>