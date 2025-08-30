<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IR_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
         $this->load->library('form_validation');
    }

    // Insert a new Incident Report
    public function insertIR($data)
    {
        // Remove 'full_name' if it's still being passed in the $data array
        unset($data['full_name']); // Ensure this line is in place

        // Insert data into the 'ir' table
        if ($this->db->insert('ir', $data)) {
            return true;
        } else {
            // Log any database error
            log_message('error', 'Insert failed: ' . $this->db->_error_message());
            return false;
        }
    }

    // Get all Incident Reports with employee details
   public function getAllIRs()
{
    $this->db->select('ir.id, ir.ir_details, ir.ir_date, ir.status, ir.approved_by, ir.approved_at, ir.created_at, ir.ir_file, 
                       employee.first_name, employee.last_name, employee.em_code, employee.em_email, employee.em_role,
                       project.pro_name'); // <-- add project name
    $this->db->from('ir');
    $this->db->join('employee', 'ir.emp_id = employee.em_code', 'left');
    $this->db->join('project', 'ir.project_id = project.id', 'left'); // <-- join project table
    $this->db->where('ir.status', 'pending'); // Only pending status
    $this->db->order_by('ir.created_at', 'DESC');
    return $this->db->get()->result();
}


    // Get IR by Employee ID
    public function getIRByEmpId($emp_id)
    {
        $this->db->select('ir.*, employee.em_id, first_name, last_name, em_code');
        $this->db->from('ir');
        $this->db->join('employee', 'ir.emp_id = employee.em_id', 'left');
        $this->db->where('ir.emp_id', $emp_id);
        return $this->db->get()->row();
    }
        public function getAllProjects()
    {
      $this->db->select('id, pro_name');
      $this->db->from('project');
     return $this->db->get()->result();

    
    }


    // Get IR by IR ID
    public function getIRById($id)
    {
        $this->db->select('ir.*, employee.em_id, first_name, last_name, em_code');
        $this->db->from('ir');
        $this->db->join('employee', 'ir.emp_id = employee.em_id', 'left');
        $this->db->where('ir.id', $id);
        return $this->db->get()->row();
    }

    // Update IR by ID
    public function updateIR($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('ir', $data);
    }

    // Check if IR exists for a given employee
    public function checkEmployeeIR($emp_id)
    {
        return $this->db->get_where('ir', ['emp_id' => $emp_id])->row();
    }
}
