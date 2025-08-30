<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Emp_Perfomance extends CI_Controller
{
    private $project_tables = [
        'daily_order'
    ];
    public function __construct()
    {
        parent::__construct();
        $this->load->model('settings_model');
        $this->load->model('Emp_Pr_Model');
        $this->load->model('employee_model');
        $this->load->model('leave_model');
    }

    public function index($employee_id = null)
    {
        if (!$employee_id) {
            show_error("Employee ID is required", 400);
            return;
        }


        $employee = $this->Emp_Pr_Model->get_employee_info($employee_id);

        if (!$employee) {
            show_error("Employee not found", 404);
            return;
        }


        $data = [
            'employee' => [
                'first_name' => $employee['first_name'] ?? 'N/A',
                'last_name' => $employee['last_name'] ?? '',
                'des_name' => $employee['des_name'] ?? 'N/A',
                'pro_name' => $employee['pro_name'] ?? 'N/A',
                'mistakes' => $employee['mistakes'] ?? 0,
                'efficiency' => $employee['efficiency'] ?? 0,
                'total_orders' => $employee['total_orders'] ?? 0,
                'profile_img' => $employee['profile_img'] ?? 'default.png',
            ],

        ];

        $this->load->view('backend/emp_perfomance', $data);
    }
    public function emp_perfomance($em_code = null)
    {
        if (!$em_code) {
            show_error("Employee code is missing.", 400);
            return;
        }

        // Fetch employee info with project
        $employee = $this->db
            ->select('employee.*, project.pro_name')
            ->from('employee')
            ->join('project', 'project.id = employee.pro_id', 'left')
            ->where('em_code', $em_code)
            ->get()
            ->row();

        if (!$employee) {
            show_error("Invalid employee code", 404);
            return;
        }

        // Configuration
        $daily_target = 100;  // Daily target orders
        $mistake_weight = 2;
        $ir_weight = 5;

        // ✅ Fetch total orders
        $total_orders = $this->db
            ->select('SUM(order_count) as total_orders')
            ->from('daily_order')
            ->where('employee_code', $em_code)
            ->get()
            ->row()
            ->total_orders ?? 0;

        // ✅ Fetch total distinct working days
        $total_days = $this->db
            ->distinct()
            ->select('order_date')
            ->from('daily_order')
            ->where('employee_code', $em_code)
            ->count_all_results();

        $total_days = max(1, $total_days); // Avoid division by zero

        // ✅ Fetch total mistakes & approved IRs
        $total_mistakes = $this->db->where('emp_id', $em_code)
            ->count_all_results('mistake_records');

        $total_ir = $this->db->where('emp_id', $em_code)
            ->where('status', 'approved')
            ->count_all_results('ir');

        // ✅ Calculate expected orders and raw efficiency
        $expected_orders = $daily_target * $total_days;
        $raw_efficiency = ($total_orders / $expected_orders) * 100;

        // ✅ Apply penalties
        $penalty = ($total_mistakes * $mistake_weight) + ($total_ir * $ir_weight);
        $efficiency = max(0, min(100, $raw_efficiency - $penalty));

        // ✅ Classify performance
        if ($efficiency >= 120) {
            $performance = "High Performer";
        } elseif ($efficiency >= 80) {
            $performance = "Meets Expectations";
        } else {
            $performance = "Low Performer";
        }

        // ✅ Profile image
        $image_path = 'assets/images/users/' . $employee->em_image;
        $profile_img = (!empty($employee->em_image) && file_exists(FCPATH . $image_path))
            ? base_url($image_path)
            : base_url('assets/images/users/user.png');

        // ✅ Prepare data for view
        $data = [
            'profile_img' => $profile_img,
            'first_name' => $employee->first_name,
            'last_name' => $employee->last_name,
            'des_id' => $employee->des_id,
            'pro_name' => $employee->pro_name ?? 'N/A',
            'total_orders' => $total_orders,
            'total_mistakes' => $total_mistakes,
            'total_ir' => $total_ir,
            'efficiency' => round($efficiency, 2),
            'performance_level' => $performance,
            'em_code' => $employee->em_code,
            'employee' => $employee,
            'employee_name' => $employee->first_name,
        ];

        // ✅ Load the view
        $this->load->view('backend/emp_perfomance', $data);
    }


 public function json_chart_data($em_code)
{
    if (!$em_code) {
        show_error("Employee code is required", 400);
        return;
    }

    // Fetch daily orders, mistakes, IRs, and mistake types
    $query = $this->db->query("
        SELECT 
            o.order_date AS date,
            SUM(o.order_count) AS total_orders,
            COUNT(DISTINCT mr.id) AS total_mistakes,
            GROUP_CONCAT(DISTINCT mr.mistake_type SEPARATOR ', ') AS mistake_types,
            COUNT(DISTINCT i.id) AS total_ir
        FROM daily_order o
        LEFT JOIN mistake_records mr 
            ON mr.emp_id = o.employee_code 
            AND mr.date = o.order_date
        LEFT JOIN ir i 
            ON i.emp_id = o.employee_code 
            AND i.ir_date = o.order_date
            AND i.status = 'approved'
        WHERE o.employee_code = ?
        GROUP BY o.order_date
        ORDER BY o.order_date ASC
    ", [$em_code]);

    $performance_data = [];
    foreach ($query->result() as $row) {
        $performance_data[] = [
            'x' => strtotime($row->date) * 1000,
            'orders' => (int)$row->total_orders,
            'mistakes' => (int)$row->total_mistakes,
            'mistake_types' => $row->mistake_types,
            'approved_ir' => (int)$row->total_ir
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($performance_data);
}



    public function get_shift_order_data($em_code, $shift = null)
    {
        if (!$em_code) {
            show_error("Employee code is required", 400);
            return;
        }

        $this->db->select("employee_code, order_date, shift, pc_position, SUM(order_count) as order_count", false);
        $this->db->from("daily_order");
        $this->db->where("employee_code", $em_code);

        if (!empty($shift)) {
            $this->db->where("shift", $shift);
        }

        $this->db->group_by(["order_date", "shift", "pc_position"]);
        $this->db->order_by("order_date", "ASC");

        $query = $this->db->get();
        $results = $query->result();

        header('Content-Type: application/json');
        echo json_encode($results);
    }




}
