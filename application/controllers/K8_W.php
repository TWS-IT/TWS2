<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property CI_Loader $load
 * @property CI_DB $db
 * @property login_model $login_model
 * @property dashboard_model $dashboard_model
 * @property employee_model $employee_model
 * @property K8_W_Model $K8_W_Model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */


class K8_W extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('settings_model');
        $this->load->model('K8_W_Model');
        $this->load->model('leave_model');

        $this->load->helper('log');
    }

    public function index()
    {


        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
        $data = array();
        $data['orders'] = $this->K8_W_Model->get_orders_with_employee_names();
        $this->load->view('orders_view', $data);

        $this->load->view('login');
    }

    public function Get_Data()
    {
        $data['employee'] = $this->employee_model->emselectK8W();
        $data['k8_w'] = $this->K8_W_Model->Get_K8_W();
    }
    public function Save_K8_W()
    {
        if ($this->session->userdata('user_login_access') != false) {
            $this->load->library('form_validation');

            $this->form_validation->set_rules('pc_position', 'pc_position', 'trim|required|xss_clean');
            $this->form_validation->set_rules('employee_id', 'employee_id', 'trim|required|xss_clean');
            $this->form_validation->set_rules('order_date', 'order_date', 'required');
            $this->form_validation->set_rules('shift', 'shift', 'required');
            $this->form_validation->set_rules('order_count', 'order_count', 'required');

            if ($this->form_validation->run() == false) {
                echo json_encode([
                    'status' => 'error',
                    'message' => validation_errors()
                ]);
            } else {
                $data = array(
                    'pc_position' => $this->input->post('pc_position'),
                    'employee_id' => $this->input->post('employee_id'),
                    'order_date' => $this->input->post('order_date'),
                    'shift' => $this->input->post('shift'),
                    'order_count' => $this->input->post('order_count'),
                );

                $this->K8_W_Model->Add_K8_W($data);
                $this->session->set_flashdata('feedback', 'Successfully Added');
                log_action($this, 'Save', "Order for employee '{$data['employee_id']}' added.");

                echo json_encode([
                    'status' => 'success',
                    'message' => $this->session->flashdata('feedback')
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'unauthorized',
                'message' => 'Unauthorized Access'
            ]);
        }
    }


    function K8_W_order()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['employee'] = $this->employee_model->emselectW1WWithdrawal();
            if ($this->session->userdata('user_type') == 'EMPLOYEE') {
                $id = $this->session->userdata('user_login_id');
                $data['k8_w'] = $this->K8_W_Model->Get_K8_W();
            } else {
                $data['k8_w'] = $this->K8_W_Model->Get_K8_W();
            }

            $this->load->view('backend/k8_w', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }
    public function K8_W_order_count()
    {

        $user = $this->session->userdata('user');
        if (!$user || !in_array($user['em_role'], ['ADMIN', 'SUPER ADMIN'])) {

            show_error('You are not authorized to view this page.', 403);
            return;


        } else {

            $this->load->model('K8_W_Model');
            $this->load->model('employee_model');

            $sum_order_count = $this->K8_W_Model->get_sum_order_count();
            $k8_w_order = $this->K8_W_Model->Get_K8_W();

            $employee = $this->employee_model->emselectK8W();

            $data = [
                'sum_order_count' => $sum_order_count,
                'k8_w' => $k8_w_order,
                'employee' => $employee,
            ];

            $this->load->view('backend/k8_w', $data);
        }

    }



    public function update_K8_W()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $id = $this->input->post('order_id');

            $data = array(
                'pc_position' => $this->input->post('pc_position'),
                'employee_id' => $this->input->post('employee_id'),
                'order_date' => $this->input->post('order_date'),
                'shift' => $this->input->post('shift'),
                'order_count' => $this->input->post('order_count'),
            );

            $this->K8_W_Model->update_K8_W($id, $data);
            log_action($this, 'Update', "Order for employee '{$data['employee_id']}' updated.");

            echo json_encode([
                'status' => 'success',
                'message' => 'Successfully Updated'
            ]);
            exit;
        } else {
            echo json_encode([
                'status' => 'unauthorized',
                'message' => 'Unauthorized Access'
            ]);
            exit;
        }
    }


    public function Edit_K8_W($id)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $data['employee'] = $this->employee_model->emselectK8W();
            $data['order'] = $this->K8_W_Model->get_order_by_id($id);

            $this->load->view('backend/edit_k8_W_order', $data);
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Delete_K8_W($id)
    {
        if ($this->session->userdata('user_login_access') != False) {
            $this->K8_W_Model->DeleteK8_W($id);
            $this->session->set_flashdata('feedback', 'Order Deleted Successfully');
            redirect('K8_W/K8_W_Order');
        } else {
            redirect(base_url(), 'refresh');
        }
    }





    public function get_all_orders_barline_chart()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $startDate = $this->input->get('date_from');
            $endDate = $this->input->get('date_to');

            $data = $this->K8_W_Model->get_all_orders_for_barline_chart($startDate, $endDate);
            echo json_encode($data);
        } else {
            show_error("Unauthorized access", 403);
        }
    }

    public function get_filtered_order_sum()
    {
        if ($this->session->userdata('user_login_access') != False) {
            $startDate = $this->input->get('date_from');
            $endDate = $this->input->get('date_to');

            $this->load->model('K8_W_Model');
            $sum = $this->K8_W_Model->get_sum_order_count_by_date($startDate, $endDate);

            echo json_encode(['total' => $sum]);
        } else {
            show_error("Unauthorized access", 403);
        }
    }


    public function showMistakeChart($project)
    {
        $project = urldecode($project);

        $this->load->model('K8_W_Model');
        try {
            $data = $this->K8_W_Model->getMistakesByProject($project);

            header('Content-Type: application/json');
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }


}

?>