<?php

class Organization_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    // Get all departments
    public function depselect() {
        $query = $this->db->get('department');
        return $query->result();
    }

    // Add new department
    public function Add_Department($data) {
        $this->db->insert('department', $data);
        return $this->db->affected_rows() > 0;
    }

    // Delete department by ID
    public function department_delete($dep_id) {
        $department = $this->db->get_where('department', array('id' => $dep_id))->row();
        $dep_name = $department->dep_name;
        $this->db->delete('department', array('id' => $dep_id));
        return $dep_name;
    }

    // Get department by ID
    public function department_edit($dep) {
        return $this->db->get_where('department', array('id' => $dep))->row();
    }

    // Update department
    public function Update_Department($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('department', $data);
    }

    // Add new designation
    public function Add_Designation($data) {
        $this->db->insert('designation', $data);
    }

    // Delete designation by ID
    public function designation_delete($des_id) {
        $this->db->delete('designation', array('id' => $des_id));
    }

    // Get designation by ID
    public function designation_edit($des) {
        return $this->db->get_where('designation', array('id' => $des))->row();
    }

    // Update designation
    public function Update_Designation($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('designation', $data);
    }

    // Get all designations
    public function desselect() {
        $query = $this->db->get('designation');
        return $query->result();
    }
}