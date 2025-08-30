<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Input $input
 * @property IR_model $IR_model
 * @property employee_model $employee_model
 * @property settings_model $settings_model
 * @property leave_model $leave_model
 */

class IR extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('IR_model');
        $this->load->model('employee_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->library('session');
        $this->load->helper('url');

        if (!$this->session->userdata('user_login_access')) {
            redirect('Login');
        }

    }
    public function update_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $user_name = $this->session->userdata('user_name');

        if (!$id || !$status) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }


        $data = ['status' => $status];

        if ($status == 'approved' || $status == 'rejected') {
            $data['approved_by'] = $user_name;
            $data['approved_at'] = date('Y-m-d H:i:s');
        }


        $this->IR_model->updateIR($id, $data);
        echo json_encode(['status' => 'success', 'message' => ucfirst($status) . ' successfully']);
    }

    // List all IRs
    public function index()
    {
        $data['irview'] = $this->IR_model->getAllIRs();
        $data['employee'] = $this->employee_model->emselect();
        $data['projects'] = $this->IR_model->getAllProjects();

        // Define the status class helper function
        function getStatusClass($status)
        {
            switch ($status) {
                case 'Approved':
                    return 'text-success'; // Green color for approved
                case 'Rejected':
                    return 'text-danger'; // Red color for rejected
                case 'Pending':
                    return 'text-warning'; // Yellow color for pending
                default:
                    return 'text-muted'; // Default color
            }
        }

        // Pass the helper function to the view
        $data['getStatusClass'] = 'getStatusClass';

        $this->load->view('backend/ir', $data);
    }

    // Add or Update IR
    public function Add_IR()
    {
        $id = $this->input->post('id');
        $emp_id = $this->input->post('emid');
        $user_name = $this->session->userdata('user_name'); // Logged-in user's name


        $this->db->where(['em_id' => $emp_id]);
        $employee = $this->db->get('employee')->row();
        $full_name = '';
        if ($employee) {
            $full_name = $employee->first_name . ' ' . $employee->last_name;
        }

        // Prepare data for the incident report
        $data = array(
            'emp_id' => $emp_id,
            'ir_date' => $this->input->post('ir_date'),
            'ir_details' => $this->input->post('ir_details'),
            'prevent' => $this->input->post('prevent'),
            'project_id' => $this->input->post('project_id')
        );
        if (!empty($_FILES['ir_file']['name'])) {
            $config['upload_path'] = './assets/images/Uploads/';
            $config['allowed_types'] = 'pdf|doc|docx|jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = time() . '_' . $_FILES['ir_file']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('ir_file')) {
                $upload_data = $this->upload->data();
                // Corrected path
                $data['ir_file'] = 'assets/images/Uploads/' . $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('IR');
            }
        }



        if ($id) {
            $status = $this->input->post('status'); // Get status if available
            if ($status === 'approved') {
                // Only update approved_by and approved_at when the report is approved
                $data['approved_by'] = $user_name;
                $data['approved_at'] = date('Y-m-d H:i:s');
            } elseif ($status === 'rejected') {
                // Only update approved_by and approved_at when the report is approved
                $data['approved_by'] = $user_name;
                $data['approved_at'] = date('Y-m-d H:i:s');
            }

            $this->IR_model->updateIR($id, $data);
            $this->session->set_flashdata('feedback', 'Updated Successfully');
        } else {
            // If it's a new report, insert it into the database
            $result = $this->IR_model->insertIR($data);
            if ($result) {
                $this->session->set_flashdata('feedback', 'Added Successfully');
            } else {
                $this->session->set_flashdata('error', 'Data Missing or Invalid');
            }
        }

        // Redirect back to the incident report page
        redirect('IR');
    }
    public function ir_by_id()
    {
        $id = $this->input->get('id');
        $ir = $this->IR_model->getIRById($id);
        echo json_encode(['irvalue' => $ir]);
    }

    public function get_employee_project($em_id)
    {
        $this->db->select('project');
        $this->db->from('employee');
        $this->db->where('em_id', $em_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {

            echo json_encode(['project' => $query->row()->project]);
        } else {

            echo json_encode(['project' => '']);
        }
    }


    public function get_working_project($em_id)
    {
        $this->db->select('project');
        $this->db->from('employee');
        $this->db->where('em_code', $em_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->project;
        } else {
            return null;
        }
    }



    public function resolved_ir()
    {
        $this->db->select('ir.*, employee.em_code, employee.first_name, employee.last_name, project.pro_name');
        $this->db->from('ir');
        $this->db->join('employee', 'employee.em_code = ir.emp_id', 'left');
        $this->db->join('project', 'project.id = ir.project_id', 'left'); // join by name
        $this->db->where_in('ir.status', ['approved', 'rejected']);
        $query = $this->db->get();

        $data['irview'] = $query->result();

        $this->load->view('backend/resolved_ir', $data);
    }




}
