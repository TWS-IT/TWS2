<?php
class Daily_mistake_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function daily_mistake()
    {
        $this->db->select("
    mistake_records.id,
    mistake_records.emp_id,
    CONCAT(em.first_name, ' ', em.last_name) AS employee_name,
    mistake_records.mistake_type,
    mistake_records.pc_number,
    mistake_records.date AS date,
    mistake_records.project_id,
    project.pro_name AS project,
    mistake_records.updated_at
");
        $this->db->from('mistake_records');
        $this->db->join('employee em', 'em.em_code = mistake_records.emp_id', 'left');
        $this->db->join('project', 'project.id = mistake_records.project_id', 'left');
        $query = $this->db->get();
        return $query->result();


    }


    public function getPINFromID($employee_ID)
    {
        $sql = "SELECT `em_code` FROM `employee` WHERE `em_id` = ?";
        $query = $this->db->query($sql, array($employee_ID));
        return $query->row();
    }

    public function emselect_mis()
    {
        $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    // In Daily_mistake_model.php
    public function get_static_mistake_types()
    {
        return [
            "Wrong Key in Amount",
            "Wrong Key in Bank Code",
            "Wrong Key - No Reference",
            "Wrong Key - Double Key in",
            "Wrong Key - Wrong Account",
            "Wrong Key - Reversal",
            "Double Payout",
            "custom"
        ];
    }


    public function add_mistake($data)
    {
        return $this->db->insert('mistake_records', $data);
    }
    public function getAllProjects()
    {
        $sql = "SELECT * FROM `project`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }


    public function get_mistake_by_id($id)
    {
        $this->db->select('mistake_records.*, em.first_name, em.last_name, project.pro_name');
        $this->db->from('mistake_records');
        $this->db->join('employee em', 'em.em_code = mistake_records.emp_id', 'left');
        $this->db->join('project', 'project.id = mistake_records.project_id', 'left');
        $this->db->where('mistake_records.id', $id);
        return $this->db->get()->row();
    }

    public function update_mistake($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('mistake_records', $data);
    }

    public function delete_mistake($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('mistake_records');
    }

    public function search_by_name($q)
    {
        $this->db->select('em_code, first_name, last_name');
        if ($q) {
            $this->db->like('first_name', $q);
            $this->db->or_like('last_name', $q);
        }
        $query = $this->db->get('employee');
        return $query->result();
    }
}
?>