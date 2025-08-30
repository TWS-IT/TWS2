<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Loader $load
 * @property CI_DB $db
 * @property login_model $login_model
 * @property dashboard_model $dashboard_model
 * @property employee_model $employee_model
 * @property daily_mistake_model $daily_mistake_model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */

class Daily_Mistake extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('settings_model');
        $this->load->model('daily_mistake_model');
        $this->load->model('leave_model');
        $this->load->helper('log');
    }

    public function index()
    {
        if ($this->session->userdata('user_login_access') != 1) {
            redirect('dashboard/Dashboard');
        }

        // Load all running projects
        // $this->load->model('Daily_Mistake_model');
        $data['project'] = $this->daily_mistake_model->getAllProjects();

        // Other data
        $data['employee'] = $this->daily_mistake_model->emselect_mis();
        $data['mistakes'] = $this->daily_mistake_model->daily_mistake();

        $this->load->view('backend/daily_mistake', $data);
    }



    public function save_mistake()
    {
        if ($this->session->userdata('user_login_access') != false) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('emp_id', 'Employee', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mistake_type', 'Mistake Type', 'required|xss_clean');
            $this->form_validation->set_rules('pc_number', 'PC Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('date', 'Date', 'required|xss_clean');
            $this->form_validation->set_rules('project_id', 'project', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                $data = array(
                    'emp_id' => $this->input->post('emp_id'),
                    'mistake_type' => $this->input->post('mistake_type'),
                    'pc_number' => $this->input->post('pc_number'),
                    'date' => $this->input->post('date'),
                    'project_id' => $this->input->post('project_id')
                );

                $this->daily_mistake_model->add_mistake($data);
                $this->session->set_flashdata('feedback', 'Mistake successfully recorded');
                redirect('Daily_Mistake/index');  // or daily_mistake, depending on where you want to land

                log_action($this, 'Save', "Mistake for employee ID '{$data['emp_id']}' recorded.");

            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function daily_mistake()
    {
        if ($this->session->userdata('user_login_access') != false) {
            $data['employee'] = $this->daily_mistake_model->emselect_mis();
            $data['projects'] = $this->daily_mistake_model->getAllProjects();


            $id = $this->session->userdata('user_login_id');
            $data['mistakes'] = $this->daily_mistake_model->daily_mistake();
        } else {
            $data['mistakes'] = $this->daily_mistake_model->daily_mistake();
        }

        $this->load->view('backend/daily_mistake', $data);

    }


    public function update_mistake()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->post('id');

            $data = array(
                'emp_id' => $this->input->post('emp_id'),
                'mistake_type' => $this->input->post('mistake_type'),
                'pc_number' => $this->input->post('pc_number'),
                'date' => $this->input->post('date'),
                'project_id' => $this->input->post('project_id')
            );

            $this->daily_mistake_model->update_mistake($id, $data);
            $this->session->set_flashdata('feedback', 'Mistake Updated Successfully');
            // $this->load->view('backend/daily_mistake', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function edit_mistake($id)
    {
        if ($this->session->userdata('user_login_access') != false) {
            $data['employee'] = $this->daily_mistake_model->emselect_mis();
            $data['project'] = $this->daily_mistake_model->getAllProjects();
            $data['mistake'] = $this->daily_mistake_model->get_mistake_by_id($id);
            $data['mistakes'] = [];
            $this->load->view('backend/daily_mistake', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }



    public function delete_mistake($id)
    {
        if ($this->session->userdata('user_login_access') != false) {
            $this->daily_mistake_model->delete_mistake($id);
            $this->session->set_flashdata('feedback', 'Mistake Deleted Successfully');
            redirect('Daily_Mistake/daily_mistake');
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function load_mistake()
    {
        if ($this->session->userdata('user_login_access') != false) {


            $data['mistake_types'] = [
                "Wrong Key in Amount",
                "Wrong Key in Bank Code",
                "Wrong Key - No Reference",
                "Wrong Key - Double Key in",
                "Wrong Key - Wrong Account",
                "Wrong Key - Reversal",
                "Double Payout",
                "custom"
            ];

            $data['employee'] = $this->daily_mistake_model->emselect_mis();
            $data['project'] = $this->daily_mistake_model->getAllProjects();
            $data['mistakes'] = $this->daily_mistake_model->daily_mistake();

            $this->load->view('backend/daily_mistake', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }


}





?>