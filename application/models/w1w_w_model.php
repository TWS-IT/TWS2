<?php
class w1w_w_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

    }
    public function Get_w1w_w()
    {
        $this->db->select('w1w_w.*, employee.first_name, employee.last_name');
        $this->db->from('w1w_w');
        $this->db->join('employee', 'employee.em_code = w1w_w.employee_id', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPINFromID($employee_ID)
    {
        $sql = "SELECT `em_code` FROM `employee`
      WHERE `em_id`='$employee_ID'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function Add_W1W_W($data)
    {
        $this->db->insert('w1w_w', $data);
    }

    public function get_orders_with_employee_names()
    {
        $this->db->select('w1w_w.order_id, w1w_w.employee_id, employee.employee_name, w1w_w.order_date, w1w_w.shift, w1w_w.order_count, w1w_w.pc_position');
        $this->db->from('w1w_w');
        $this->db->join('employee', 'employee.employee_id = w1w_w.employee_id', 'left');
        $query = $this->db->get();
        return $query->result();
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
    public function update_W1W_W($id, $data)
    {
        $this->db->where('order_id', $id);
        $this->db->update('w1w_w', $data);
    }
    public function get_order_by_id($id)
    {
        $this->db->select('w1w_w.*, employee.first_name, employee.last_name');
        $this->db->from('w1w_w');
        $this->db->join('employee', 'employee.em_code = w1w_w.employee_id', 'left');
        $this->db->where('w1w_w.order_id', $id);
        return $this->db->get()->row();
    }
    public function DeleteW1W_W($id)
    {
        $this->db->where('order_id', $id);
        return $this->db->delete('w1w_w');
    }

    public function get_sum_order_count()
    {
        $this->db->select_sum('order_count');
        $query = $this->db->get('w1w_w');
        $result = $query->row_array();

        return ($result && $result['total'] !== null) ? $result['total'] : 0;
    }
    public function get_orders_by_date_range($startDate, $endDate)
    {
        $this->db->select('w1w_w.*, employee.full_name as employee_name');
        $this->db->from('w1w_w');
        $this->db->join('employee', 'employee.em_id = w1w_w.employee_id', 'left');

        if (!empty($startDate) && !empty($endDate)) {
            $this->db->where('order_date >=', $startDate);
            $this->db->where('order_date <=', $endDate);
        }

        $query = $this->db->get();
        return $query->result();
    }
    public function get_sum_order_count_by_date($startDate, $endDate)
    {
        $this->db->select_sum('order_count');
        $this->db->from('w1w_w');

        if (!empty($startDate) && !empty($endDate)) {
            $this->db->where('order_date >=', $startDate);
            $this->db->where('order_date <=', $endDate);
        }

        $query = $this->db->get();
        return $query->row()->order_count ?? 0;
    }




    public function get_all_orders_for_barline_chart($startDate = null, $endDate = null)
    {

        $this->db->select('order_date, employee_id, SUM(order_count) AS total_orders');
        $this->db->from('w1w_deposit_order');

        if (!empty($startDate) && !empty($endDate)) {
            $this->db->where('order_date >=', $startDate);
            $this->db->where('order_date <=', $endDate);
        }

        $this->db->group_by(['order_date', 'employee_id']);
        $query = $this->db->get();
        $rows = $query->result();

        $datewiseOrders = [];

        foreach ($rows as $row) {
            $date = $row->order_date;
            if (!isset($datewiseOrders[$date])) {
                $datewiseOrders[$date] = [
                    'total_orders' => 0,
                    'employee_ids' => []
                ];
            }
            $datewiseOrders[$date]['total_orders'] += (int) $row->total_orders;
            $datewiseOrders[$date]['employee_ids'][$row->employee_id] = true;
        }

        $filledTotal = [];
        $filledAverage = [];

        if (!empty($startDate) && !empty($endDate)) {
            $start = new DateTime($startDate);
            $end = new DateTime($endDate);
            $end = $end->modify('+1 day');

            while ($start < $end) {
                $dateStr = $start->format('Y-m-d');
                $totalOrders = isset($datewiseOrders[$dateStr]) ? $datewiseOrders[$dateStr]['total_orders'] : 0;
                $employeeCount = isset($datewiseOrders[$dateStr]) ? count($datewiseOrders[$dateStr]['employee_ids']) : 0;
                $avgOrders = $employeeCount > 0 ? round($totalOrders / $employeeCount, 2) : 0;

                $filledTotal[] = ['x' => $dateStr, 'y' => $totalOrders];
                $filledAverage[] = ['x' => $dateStr, 'y' => $avgOrders];

                $start->modify('+1 day');
            }
        } else {
            foreach ($datewiseOrders as $date => $info) {
                $totalOrders = $info['total_orders'];
                $employeeCount = count($info['employee_ids']);
                $avgOrders = $employeeCount > 0 ? round($totalOrders / $employeeCount, 2) : 0;

                $filledTotal[] = ['x' => $date, 'y' => $totalOrders];
                $filledAverage[] = ['x' => $date, 'y' => $avgOrders];
            }
        }

        return [
            'total_orders' => $filledTotal,
            'avg_orders' => $filledAverage
        ];
    }

    public function getMistakesByProject($project)
    {
        $this->db->select('m.*, e.project');
        $this->db->from('mistake_records m');
        $this->db->join('employee e', 'm.emp_id = e.em_code', 'inner');
        $this->db->where('e.project', $project);
        $query = $this->db->get();

        if (!$query) {
            throw new Exception($this->db->last_query() . ' | ' . $this->db->error()['message']);
        }

        return $query->result_array();
    }


}
?>