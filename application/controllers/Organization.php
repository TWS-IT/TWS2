<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Organization extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('organization_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->helper('log');
    }

    public function index()
    {
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
        $this->load->view('login');
    }

    public function Department()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['department'] = $this->organization_model->depselect();
            $this->load->view('backend/department', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Save_dep()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $dep = $this->input->post('department');
            $this->form_validation->set_rules('department', 'department', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                $data = array('dep_name' => $dep);
                $this->organization_model->Add_Department($data);
                $this->session->set_flashdata('feedback', 'Successfully Added');
                log_action($this, 'Save', "Department '{$dep}' Successfully Added");
                echo "Successfully Added";
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Delete_dep($dep_id)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $dep_name = $this->organization_model->department_delete($dep_id);
            if ($dep_name) {
                log_action($this, 'delete_department', "Department '{$dep_name}' successfully deleted");
                $this->session->set_flashdata('delsuccess', 'Successfully Deleted');
            } else {
                $this->session->set_flashdata('error', 'Department not found');
            }
            redirect('organization/Department');
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Dep_edit($dep)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['department'] = $this->organization_model->depselect();
            $data['editdepartment'] = $this->organization_model->department_edit($dep);
            $this->load->view('backend/department', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Update_dep()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->post('id');
            $new_department = $this->input->post('department');
            $old_dep = $this->organization_model->department_edit($id);
            $data = array('dep_name' => $new_department);
            $this->organization_model->Update_Department($id, $data);
            if ($old_dep) {
                log_action($this, 'update_department', "Department '{$old_dep->dep_name}' changed to '{$new_department}'");
            }
            echo "Successfully Updated";
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Designation()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['designation'] = $this->organization_model->desselect();
            $this->load->view('backend/designation', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Save_des()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $des = $this->input->post('designation');
            $this->form_validation->set_rules('designation', 'designation', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                $data = array('des_name' => $des);
                $this->organization_model->Add_Designation($data);
                echo "Successfully Added";
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function des_delete($des_id)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $this->organization_model->designation_delete($des_id);
            $this->session->set_flashdata('delsuccess', 'Successfully Deleted');
            redirect('organization/Designation');
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Edit_des($des)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['designation'] = $this->organization_model->desselect();
            $data['editdesignation'] = $this->organization_model->designation_edit($des);
            $this->load->view('backend/designation', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Update_des()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->post('id');
            $designation = $this->input->post('designation');
            $data = array('des_name' => $designation);
            $this->organization_model->Update_Designation($id, $data);
            echo "Successfully Updated";
        } else {
            redirect(base_url(), 'refresh');
        }
    }
}
