<?php
class Emp_Pr_Model extends CI_Model
{
    private $project_tables = [
        'w_order',
        'atas_order',
        'w1w_deposit_order',
        'w1w_w',
        'k8_d',
        'k8_w',
    ];

    public function __construct()
    {
        parent::__construct();
         $this->load->library('form_validation');
    }

    public function get_total_orders($employee_id)
{
    $total = 0;

    foreach ($this->project_tables as $table) {
        $this->db->select_sum('order_count');
        $this->db->where('employee_id', $employee_id);
        $query = $this->db->get($table);

        $row = $query->row();
        $sum = isset($row->order_count) ? (int)$row->order_count : 0;

        $total += $sum;
        
    }

    return $total;
}

public function get_employee_detailes($em_code){
    $this->db->select('employee.em_code, employee.em_image');
    $this->db->from('employee');
    $this->db->join('employee', 'employee.em_code = project_tables.Employee_id', 'left');
    $this->db->where('employee.em_code', $em_code);
    $employee = $this->db->get()->row();

    $image_path = 'assets/images/users/' . $employee->em_image;
    $em_image = (file_exists(FCPATH . $image_path) && !empty($employee->em_image))
    ? base_url($image_path)
: base_url('assets/images/users/user.png');

}
public function get_daily_order_count($emp_code, $date)
{
    $this->db->select('SUM(order_count) as total_count');
    $this->db->from('w_order');
    $this->db->where('employee_id', $emp_code);
    $this->db->where('DATE(order_date)', $date);
    $query = $this->db->get();

    $result = $query->row();
    return isset($result->total_count) ? (int) $result->total_count : 0;
}


public function get_orders_by_shift($employee_id, $shift)
{
    $shift_times = [
        'morning' => ['06:00:00', '14:00:00'],
        'noon'    => ['14:00:01', '22:00:00'],
        'night'   => ['22:00:01', '05:59:59']
    ];

    $time_range = $shift_times[strtolower($shift)];

    $query = $this->db->query("
        SELECT 
            DATE(order_date) AS order_date,
            SUM(order_count) AS order_count,
            GROUP_CONCAT(pc_position) AS pc_position
        FROM w_order
        WHERE employee_id = ?
        AND (
            (TIME(order_date) BETWEEN ? AND ?)
            OR
            (? = 'night' AND TIME(order_date) BETWEEN '00:00:00' AND '05:59:59')
        )
        GROUP BY DATE(order_date)
        ORDER BY order_date ASC
    ", [$employee_id, $time_range[0], $time_range[1], strtolower($shift)]);

    return $query->result();
}





}