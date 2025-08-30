<?php

class Perfomance_model extends CI_Model
{
    
  public function get_all_performance_data()
{
    $this->db->select('employee.em_code, CONCAT(employee.first_name, " ", employee.last_name) AS full_name, employee.em_image, project.pro_name AS project_name');
    $this->db->from('employee');
    $this->db->join('project', 'employee.pro_id = project.id', 'left');
    $this->db->where('employee.status', 'ACTIVE');
    $employees = $this->db->get()->result();

    $data = [];

    foreach ($employees as $emp) {
        $em_code = $emp->em_code;
        $total_orders = $this->get_total_orders($em_code);

        $efficiency = $total_orders > 0 ? round(($total_orders / $total_orders) * 100) : 0;

        $data[] = [
            'em_image' => base_url('assets/images/users/' . $emp->em_image),
            'em_code' => $em_code,
            'full_name' => $emp->full_name,
            'project' => $emp->project_name ?? 'N/A',
            'total_orders' => $total_orders,
            'efficiency' => $efficiency
        ];
    }

    return $data;
}


    public function get_total_orders($em_code)
{
    // Only use the new daily_orders table
    if ($this->db->table_exists('daily_order')) {
        $this->db->select_sum('order_count');
        $this->db->where('employee_code', $em_code);
        $query = $this->db->get('daily_order');
        $result = $query->row();

        return $result->order_count ?? 0;
    }

    return 0;
}


}
