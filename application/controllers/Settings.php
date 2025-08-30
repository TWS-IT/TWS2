<?php
	defined('BASEPATH') OR exit('No direct script access allowed');


    class Projects extends CI_Controller
    {

        function __construct()
        {
	        parent::__construct();
	        $this->load->database();
        	$this->load->model('login_model');
	        $this->load->model('dashboard_model');
	        $this->load->model('employee_model');
        	$this->load->model('order_model'); // This is your custom model for orders
	        $this->load->model('settings_model');
        }

        public function index()
        {
	        // Redirect to Admin dashboard after authentication
	        if ($this->session->userdata('user_login_access') == 1) {
		        redirect('dashboard/Dashboard');
	        }
	
	        $data = array();
	        // $data['settingsvalue'] = $this->dashboard_model->GetSettingsValue(); // Optional
	        $this->load->view('login');
        }

        


    }?>