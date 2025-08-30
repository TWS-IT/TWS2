<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Colombo');
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('settings_model');
        $this->load->model('notice_model');
        $this->load->model('project_model');
        $this->load->model('leave_model');
    }

    public function mistake_count()
    {
        $timeRange = $this->input->post('timeRange');
        $projectId = $this->input->post('projectId');

        $this->db->from('mistake_records m');

        // Time filter
        $currentDate = new DateTime();
        $startDate = clone $currentDate;

        switch ($timeRange) {
            case 'today':
                $this->db->where('m.date', $currentDate->format('Y-m-d'));
                break;
            case 'week':
                $startDate->modify('-7 days');
                $this->db->where('m.date >=', $startDate->format('Y-m-d'));
                break;
            case 'month':
                $startDate->modify('first day of this month');
                $this->db->where('m.date >=', $startDate->format('Y-m-d'));
                break;
            case 'year':
                $startDate->modify('first day of January this year');
                $this->db->where('m.date >=', $startDate->format('Y-m-d'));
                break;
            default:
                // no filter
                break;
        }

        // Project filter
        if ($projectId !== 'all') {
            $this->db->where('m.project_id', $projectId);
        }

        $count = $this->db->count_all_results();
        echo json_encode(['count' => $count]);
    }



    public function index()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
        $data = array();
        #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
        $this->load->view('login');
    }
    function Dashboard()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $this->load->view('backend/dashboard');
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function add_todo()
    {
        $userid = $this->input->post('userid');
        $tododata = $this->input->post('todo_data');
        $date = date("Y-m-d h:i:sa");
        $this->load->library('form_validation');
        //validating to do list data
        $this->form_validation->set_rules('todo_data', 'To-do Data', 'trim|required|min_length[5]|max_length[150]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            $data = array();
            $data = array(
                'user_id' => $userid,
                'to_dodata' => $tododata,
                'value' => '1',
                'date' => $date
            );
            $success = $this->dashboard_model->insert_tododata($data);
            #echo "successfully added";
            if ($this->db->affected_rows()) {
                echo "Successfully Added";
            } else {
                echo "validation Error";
            }
        }
    }
    public function Update_Todo()
    {
        $id = $this->input->post('toid');
        $value = $this->input->post('tovalue');
        $data = array();
        $data = array(
            'value' => $value
        );
        $update = $this->dashboard_model->UpdateTododata($id, $data);
        $inserted = $this->db->affected_rows();
        if ($inserted) {
            $message = "Successfully Added";
            echo $message;
        } else {
            $message = "Something went wrong";
            echo $message;
        }
    }




    public function get_order_comparison_chart($filter = 'all')
    {
        $shiftCondition = "";
        if ($filter !== 'all') {
            $shiftCondition = "AND d.shift = " . $this->db->escape($filter);
        }

        $query = $this->db->query("
        SELECT 
            d.order_date,
            p.pro_name,
            SUM(d.order_count) as total_orders
        FROM daily_order d
        INNER JOIN project p ON d.project_id = p.id
        WHERE 1=1 $shiftCondition
        GROUP BY d.order_date, p.pro_name
        ORDER BY d.order_date
    ");

        echo json_encode($query->result());
    }


    public function get_total_order_count($timeRange, $projectId = 'all')
    {
        $currentDate = new DateTime();
        $startDate = clone $currentDate;

        switch ($timeRange) {
            case 'today':
                $this->db->where('order_date', $currentDate->format('Y-m-d'));
                break;
            case 'week':
                $startDate->modify('-7 days');
                $this->db->where('order_date >=', $startDate->format('Y-m-d'));
                break;
            case 'month':
                $startDate->modify('first day of this month');
                $this->db->where('order_date >=', $startDate->format('Y-m-d'));
                break;
            case 'year':
                $startDate->modify('first day of January this year');
                $this->db->where('order_date >=', $startDate->format('Y-m-d'));
                break;
            default:
                // 'all' → no filter
                break;
        }

        if ($projectId !== 'all') {
            $this->db->where('project_id', $projectId);
        }

        $this->db->select_sum('order_count');
        $query = $this->db->get('daily_order');
        $result = $query->row();

        $totalOrderCount = $result->order_count ?? 0;

        echo json_encode(['success' => true, 'orderCount' => $totalOrderCount]);
    }


    public function getMistakeCountByProject()
    {
        $project = $this->input->get('project');

        $this->db->from("mistake_records m");
        $this->db->join("employee e", "e.em_code = m.employee_id", "inner");

        if (!empty($project)) {
            $this->db->where("e.project", $project);
        }

        $count = $this->db->count_all_results();

        echo json_encode(['count' => $count]);
    }




    public function top_employees()
    {
        $top_employees = $this->db
            ->select('e.first_name, e.last_name, SUM(d.order_count) as total_orders')
            ->from('daily_order d')
            ->join('employee e', 'e.em_code = d.employee_code')
            ->group_by('d.employee_code')
            ->order_by('total_orders', 'DESC')
            ->limit(10)
            ->get()
            ->result();

        $data['top_employees'] = $top_employees;

        $this->load->view('backend/top_employees', $data);
    }





}