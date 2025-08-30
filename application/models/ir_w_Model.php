<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ir_w_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }




    public function getAllIRs()
    {
        $this->db->select('ir.id, ir.ir_details, ir.ir_date, ir.status, ir.approved_by, ir.approved_at, ir.created_at, 
                       employee.first_name, employee.last_name, employee.em_code, employee.em_email, employee.em_role, employee.project');
        $this->db->from('ir');
        $this->db->join('employee', 'ir.emp_id = employee.em_id', 'left');
        $this->db->where_in('ir.status', ['Approved', 'Rejected']);
        $this->db->order_by('ir.created_at', 'DESC');
        return $this->db->get()->result();
    }


    public function getIRByEmpId($emp_id)
    {
        $this->db->select('ir.*, employee.em_id, first_name, last_name, em_code');
        $this->db->from('ir');
        $this->db->join('employee', 'ir.emp_id = employee.em_id', 'left');
        $this->db->where('ir.emp_id', $emp_id);
        return $this->db->get()->row();
    }


    public function getIRById($id)
    {
        $this->db->select('ir.*, employee.em_id, first_name, last_name, em_code');
        $this->db->from('ir');
        $this->db->join('employee', 'ir.emp_id = employee.em_id', 'left');
        $this->db->where('ir.id', $id);
        return $this->db->get()->row();
    }

  
}
