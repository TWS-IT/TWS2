<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warning_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    // Insert a new Warning
    public function insertWarning($data)
    {
        if ($this->db->insert('warning', $data)) {
            return true;
        } else {
            log_message('error', 'Insert failed: ' . $this->db->error()['message']);
            return false;
        }
    }

    // Get all Warnings with employee details
    public function getAllWarnings()
    {
        $this->db->select('warning.*, employee.first_name, employee.last_name, employee.em_code, employee.em_email, employee.em_role, employee.pro_id');
        $this->db->from('warning');
        $this->db->join('employee', 'warning.employee_id = employee.em_code', 'left');
        $this->db->order_by('warning.id', 'DESC');
        return $this->db->get()->result();
    }

    // Get Warning by Employee ID
    public function getWarningsByEmpId($emp_id)
    {
        $this->db->select('warning.*, employee.em_id, employee.first_name, employee.last_name, employee.em_code');
        $this->db->from('warning');
        $this->db->join('employee', 'warning.employee_id = employee.em_id', 'left');
        $this->db->where('warning.employee_id', $emp_id);
        return $this->db->get()->result();
    }

    // Get Warning by Warning ID
    public function getWarningById($id)
    {
        $this->db->select('warning.*, employee.em_id, employee.first_name, employee.last_name, employee.em_code, designation.des_name as designation_name');
        $this->db->from('warning');
        $this->db->join('employee', 'warning.employee_id = employee.em_code', 'left'); // use em_code here
        $this->db->join('designation', 'designation.id = employee.des_id', 'left'); // join designation
        $this->db->where('warning.id', $id);
        return $this->db->get()->row();
    }


    // Update Warning by ID
    public function updateWarning($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('warning', $data);
    }

    // Delete Warning by ID
    public function deleteWarning($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('warning');
    }

    // Check if Warning exists for a given employee
    public function checkEmployeeWarning($emp_id)
    {
        return $this->db->get_where('warning', ['employee_id' => $emp_id])->row();
    }
}
