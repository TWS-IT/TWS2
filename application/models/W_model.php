<?php
class W_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
         $this->load->library('form_validation');

    }
    public function Get_w()
    {
        $this->db->select('w_order.*, employee.first_name, employee.last_name');
        $this->db->from('w_order');
        $this->db->join('employee', 'employee.em_code = w_order.employee_id', 'left');
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
    public function Add_w($data)
    {
        $this->db->insert('w_order', $data);
    }

    public function get_orders_with_employee_names()
    {
        $this->db->select('w_order.order_id, w_order.employee_id, employee.employee_name, w_order.order_date, w_order.shift, w_order.order_count, w_order.pc_position');
        $this->db->from('w_order');
        $this->db->join('employee', 'employee.employee_id = w_order.employee_id', 'left');
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
    public function update_W($id, $data)
    {
        $this->db->where('order_id', $id);
        $this->db->update('w_order', $data);
    }
    public function get_order_by_id($id)
    {
        $this->db->select('w_order.*, employee.first_name, employee.last_name');
        $this->db->from('w_order');
        $this->db->join('employee', 'employee.em_code = w_order.employee_id', 'left');
        $this->db->where('w_order.order_id', $id);
        return $this->db->get()->row();
    }
    public function DeleteWOrder($id)
    {
        $this->db->where('order_id', $id);
        return $this->db->delete('w_order');
    }

    public function get_sum_order_count()
    {
        $sql = "SELECT SUM(order_count) AS total FROM w_order";
        $query = $this->db->query($sql);
        $result = $query->row_array();

        return ($result && $result['total'] !== null) ? $result['total'] : 0;
    }
    public function get_orders_by_date_range($startDate, $endDate)
    {
        $this->db->select('w_order.*, employee.full_name as employee_name');
        $this->db->from('w_order');
        $this->db->join('employee', 'employee.em_id = w_order.employee_id', 'left');

        if (!empty($startDate) && !empty($endDate)) {
            $this->db->where('order_date >=', $startDate);
            $this->db->where('order_date <=', $endDate);
        }

        $query = $this->db->get();
        return $query->result();
    }
    public function get_sum_order_count_by_date($startDate, $endDate, $shiftid)
    {
        // Ensure date parameters are in the correct format
        if (!empty($startDate) && !empty($endDate)) {
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
        }

        $this->db->select_sum('order_count');
        $this->db->from('w_order');

        if (!empty($startDate) && !empty($endDate)) {
            $this->db->where('order_date >=', $startDate);
            $this->db->where('order_date <=', $endDate);
        }

        // Only filter by shift if not "ALL"
        if (!empty($shiftid) && strtoupper($shiftid) !== 'ALL') {
            $this->db->where('shift', $shiftid);
        }

        $query = $this->db->get();
        return $query->row()->order_count ?? 0;
    }





    // public function get_total_mistakes()
// {
//     return $this->db->count_all('mistakes'); // Replace 'mistakes' with your actual table name
// }


    public function get_all_orders_for_barline_chart($startDate = null, $endDate = null, $shiftid = 'ALL')
    {
        $this->db->select('order_date, employee_id, SUM(order_count) AS total_orders');
        $this->db->from('w_order');

        // Apply date range filter only if both dates are provided
        if (!empty($startDate) && !empty($endDate)) {
            $this->db->where('order_date >=', $startDate);
            $this->db->where('order_date <=', $endDate);
        }

        // Apply shift filter only if shift is provided and not "ALL"
        if (!empty($shiftid) && strtoupper($shiftid) !== 'ALL') {
            $this->db->where('shift', $shiftid);
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




    // public function getMistakesForProject($project = 'W')
    // {
    //     // Join mistakes_records with employee to filter by project
    //     $this->db->select('m.*');
    //     $this->db->from('mistakes_records m');
    //     $this->db->join('employee e', 'm.emp_id = e.em_code');
    //     $this->db->where('e.project', $project);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }


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