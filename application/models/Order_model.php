<?php
class Order_model extends CI_Model
{

    public function get_orders($project_id = 0, $shift = 'ALL', $date_from = null, $date_to = null)
    {
        $this->db->from('daily_order d');
        $this->db->join('project p', 'd.project_id = p.id', 'left');
        $this->db->join('employee e', 'd.employee_code = e.em_code', 'left');
        $this->db->select('
            p.pro_name,
            e.em_code,
            e.first_name,
            e.last_name,
            d.order_date,
            d.shift,
            d.order_count,
            d.pc_position,
            d.order_id
        ');


        if ($project_id !== 'ALL') { 
            $this->db->where('d.project_id', $project_id);
        }

        // if ($project_id && $project_id != 0) {
        //     $this->db->where('d.project_id', $project_id);
        // }

        if ($shift != 'ALL') {
            $this->db->where('d.shift', $shift);
        }

        if ($date_from) {
            $this->db->where('d.order_date >=', $date_from);
        }

        if ($date_to) {
            $this->db->where('d.order_date <=', $date_to);
        }

        $this->db->order_by('d.order_date', 'DESC');

        return $this->db->get()->result_array();
    }


    public function get_orders_chart_data($projectId = 'ALL', $startDate = null, $endDate = null, $shiftid = 'ALL')
    {
        $this->db->select('order_date, SUM(order_count) as total');
        $this->db->from('daily_order');

        if ($startDate && $endDate) {
            $this->db->where('order_date >=', $startDate);
            $this->db->where('order_date <=', $endDate);
        }

        if (!empty($shiftid) && strtoupper($shiftid) !== 'ALL') {
            $this->db->where('shift', $shiftid);
        }

        if (!empty($projectId) && strtoupper($projectId) !== 'ALL') {
            $this->db->where('project_id', $projectId);
        }

        $this->db->group_by('order_date');
        $this->db->order_by('order_date', 'ASC');
        $query = $this->db->get();

        $total_orders = [];
        foreach ($query->result() as $row) {
            $total_orders[] = ['x' => $row->order_date, 'y' => (int) $row->total];
        }

        $avg_orders = [];
        foreach ($total_orders as $row) {
            $avg_orders[] = ['x' => $row['x'], 'y' => round($row['y'] / 2)];
        }

        return ['total_orders' => $total_orders, 'avg_orders' => $avg_orders];
    }

    public function get_mistake_chart_data($projectId = 'ALL', $startDate = null, $endDate = null)
    {
        $this->db->select('date, COUNT(*) as total');
        $this->db->from('mistake_records');

        if (!empty($startDate) && !empty($endDate)) {
            $this->db->where('date >=', $startDate);
            $this->db->where('date <=', $endDate);
        }

        if (!empty($projectId) && strtoupper($projectId) !== 'ALL') {
            $this->db->where('project_id', (int) $projectId);
        }

        $this->db->group_by('date');
        $this->db->order_by('date', 'ASC');
        $query = $this->db->get();

        $mistakes = [];
        foreach ($query->result() as $row) {
            $mistakes[] = [
                'x' => $row->date,
                'y' => (int) $row->total
            ];
        }

        return $mistakes;
    }

public function get_order_by_id($id)
{
    return $this->db->get_where('daily_order', ['order_id' => $id])->row_array();
}


    
}
