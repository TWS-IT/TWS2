<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Order_model');
        $this->load->model('employee_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->helper('url');
    }


    public function index()
    {
        $data['projects'] = $this->db->get('project')->result();
        $data['employee'] = $this->db->get('employee')->result();

        $this->load->view('backend/header');
        $this->load->view('backend/order_report', $data);
    }


    public function save_order()
    {
        $project_id = $this->input->post('project_id', true);
        $employee_code = $this->input->post('employee_code', true);
        $pc_position = $this->input->post('pc_position', true);
        $order_date = $this->input->post('order_date', true);
        $shift = $this->input->post('shift', true);
        $order_count = $this->input->post('order_count', true);

        $this->form_validation->set_data($_POST);
        $this->form_validation->set_rules('project_id', 'Project', 'required|trim');
        $this->form_validation->set_rules('employee_code', 'Employee', 'required|trim');
        $this->form_validation->set_rules('pc_position', 'Employee Position', 'required|trim');
        $this->form_validation->set_rules('order_date', 'Order Date', 'required');
        $this->form_validation->set_rules('shift', 'Shift', 'required');
        $this->form_validation->set_rules('order_count', 'Order Count', 'required|integer');

        if (!$this->form_validation->run()) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        if ($project_id === 'ALL') {
            echo json_encode(['status' => 'error', 'message' => 'Please select a specific project.']);
            return;
        }

        $employee = $this->db->get_where('employee', ['em_code' => $employee_code])->row();
        if (!$employee) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid employee selected.']);
            return;
        }

        $data = [
            'project_id' => (int) $project_id,
            'employee_code' => $employee_code,
            'pc_position' => $pc_position,
            'order_date' => $order_date,
            'shift' => $shift,
            'order_count' => (int) $order_count
        ];

        $this->db->insert('daily_order', $data);
        echo json_encode(['status' => 'success', 'message' => 'Order saved successfully']);
    }

    public function get_summary_counts()
    {
        $project_id = $this->input->get('project_id', true);
        $date_from = $this->input->get('date_from', true);
        $date_to = $this->input->get('date_to', true);


        $this->db->from('employee');
        $this->db->where('status', 'ACTIVE');
        if ($project_id && $project_id !== 'ALL') {
            $this->db->where('pro_id', (int) $project_id);
        }
        $employees_count = (int) $this->db->count_all_results();

        $this->db->select_sum('order_count');
        if ($project_id && $project_id !== 'ALL') {
            $this->db->where('project_id', (int) $project_id);
        }
        if ($date_from) {
            $this->db->where('order_date >=', $date_from);
        }
        if ($date_to) {
            $this->db->where('order_date <=', $date_to);
        }
        $sum = $this->db->get('daily_order')->row();
        $orders_total = (int) ($sum->order_count ?? 0);

        $this->db->from('mistake_records m');
        $this->db->join('employee e', 'e.em_code = m.emp_id', 'inner');
        if ($project_id && $project_id !== 'ALL') {
            $this->db->where('e.pro_id', (int) $project_id);
        }
        if ($date_from) {
            $this->db->where('m.mistake_date >=', $date_from);
        }
        if ($date_to) {
            $this->db->where('m.mistake_date <=', $date_to);
        }
        $mistakes_count = (int) $this->db->count_all_results();

        $label = 'All Projects';
        if ($project_id && $project_id !== 'ALL') {
            $p = $this->db->get_where('project', ['id' => (int) $project_id])->row();
            if ($p) {
                $label = $p->pro_name;
            }
        }

        echo json_encode([
            'label' => $label,
            'employees_count' => $employees_count,
            'orders_total' => $orders_total,
            'mistakes_count' => $mistakes_count
        ]);
    }

    public function get_all_orders_barline_chart()
    {
        if (!$this->session->userdata('user_login_access')) {
            show_error("Unauthorized access", 403);
        }

        $projectId = $this->input->get('project_id') ?? 'ALL';
        $startDate = $this->input->get('date_from') ?? null;
        $endDate = $this->input->get('date_to') ?? null;
        $shiftid = $this->input->get('shiftid') ?? 'ALL';

        $data = $this->Order_model->get_orders_chart_data($projectId, $startDate, $endDate, $shiftid);
        echo json_encode($data);
    }

    public function get_mistakes_chart()
    {
        if (!$this->session->userdata('user_login_access')) {
            show_error("Unauthorized access", 403);
        }

        $projectId = $this->input->get('project_id') ?? 'ALL';
        $startDate = $this->input->get('date_from') ?? null;
        $endDate = $this->input->get('date_to') ?? null;

        $data = $this->Order_model->get_mistake_chart_data($projectId, $startDate, $endDate);

        echo json_encode($data);
    }

    public function delete_order()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $order_id = $input['order_id'] ?? null;

        if (!$order_id) {
            echo json_encode(['status' => 'error', 'message' => 'Order ID is required']);
            return;
        }

        $order = $this->db->get_where('daily_order', ['order_id' => $order_id])->row();

        if (!$order) {
            echo json_encode(['status' => 'error', 'message' => 'Order not found']);
            return;
        }

        $this->db->where('order_id', $order_id)->delete('daily_order');

        echo json_encode(['status' => 'success', 'message' => 'Order deleted successfully']);
    }

    public function update_order()
    {
        $order_id = $this->input->post('order_id', true);

        if (!$order_id) {
            echo json_encode(['status' => 'error', 'message' => 'Order ID is required']);
            return;
        }

        $order = $this->db->get_where('daily_order', ['order_id' => $order_id])->row();
        if (!$order) {
            echo json_encode(['status' => 'error', 'message' => 'Order not found']);
            return;
        }

        $project_id = $this->input->post('project_id', true);
        $pc_position = $this->input->post('pc_position', true);
        $order_date = $this->input->post('order_date', true);
        $shift = $this->input->post('shift', true);
        $order_count = $this->input->post('order_count', true);
        $employee_code = $this->input->post('employee_code', true);

        if (!$project_id || !$employee_code || !$pc_position || !$order_date || !$shift || $order_count === null) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
            return;
        }

        $employee = $this->db->get_where('employee', ['em_code' => $employee_code])->row();
        if (!$employee) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid employee selected']);
            return;
        }

        $data = [
            'project_id' => (int) $project_id,
            'employee_code' => $employee_code,
            'pc_position' => $pc_position,
            'order_date' => $order_date,
            'shift' => $shift,
            'order_count' => (int) $order_count
        ];

        if ($this->db->where('order_id', $order_id)->update('daily_order', $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Order updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update order']);
        }
    }



    public function get_orders()
    {
        $project_id = $this->input->get('project_id') ?? 0;
        $shift = $this->input->get('shift') ?? 'ALL';
        $date_from = $this->input->get('date_from') ?? null;
        $date_to = $this->input->get('date_to') ?? null;

        $orders = $this->Order_model->get_orders($project_id, $shift, $date_from, $date_to);

        $total = array_sum(array_column($orders, 'order_count'));

        echo json_encode([
            'orders' => $orders,
            'total' => $total
        ]);
    }
    public function get_order()
    {
        $order_id = $this->input->get('order_id', true);

        $this->db->select('o.*, e.first_name, e.last_name, e.em_code, p.pro_name');
        $this->db->from('daily_order o');
        $this->db->join('employee e', 'e.em_code = o.employee_code', 'left');
        $this->db->join('project p', 'p.id = o.project_id', 'left');
        $this->db->where('o.order_id', (int) $order_id);
        $order = $this->db->get()->row();

        if (!$order) {
            echo json_encode(['status' => 'error', 'message' => 'Order not found']);
            return;
        }

        echo json_encode(['status' => 'success', 'order' => $order]);
    }




}
