 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->model('payroll_model');
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('leave_model'); 
        $this->load->model('settings_model');    
        $this->load->model('organization_model');    
        // $this->load->model('loan_model'); // Removed
    }

    public function index() {
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
        $data = array();
        $this->load->view('login');
    }

    public function Salary_Type() {
        if($this->session->userdata('user_login_access') != False) { 
            $data['typevalue'] = $this->payroll_model->GetsalaryType();
            $this->load->view('backend/salary_type', $data);
        } else {
            redirect(base_url(), 'refresh');
        }        
    }

    public function Add_Sallary_Type() {
        if($this->session->userdata('user_login_access') != False) {
            $id = $this->input->post('id');
            $type = $this->input->post('typename');
            $createdate = $this->input->post('createdate');

            $this->form_validation->set_error_delimiters();
            $this->form_validation->set_rules('typename', 'Type name', 'trim|required|min_length[3]|max_length[120]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                $data = array(
                    'salary_type' => $type,
                    'create_date' => $createdate
                );

                if(empty($id)) {
                    $success = $this->payroll_model->Add_typeInfo($data);
                    echo "Successfully Added";
                } else {
                    $success = $this->payroll_model->Update_typeInfo($id, $data);
                    echo "Successfully Updated";
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }            
    }

    public function GetSallaryTypeById() {
        if($this->session->userdata('user_login_access') != False) {  
            $id = $this->input->get('id');      
            $data['typevalueid'] = $this->payroll_model->Get_typeValue($id);
            echo json_encode($data);    
        } else {
            redirect(base_url(), 'refresh');
        }        
    }

    public function GetSallaryById() {
        if($this->session->userdata('user_login_access') != False) {  
            $id = $this->input->get('id');
            $data = array();    
            $data['salaryvalue'] = $this->payroll_model->GetsalaryValueByID($id);
            // $data['loanvaluebyid'] = $this->payroll_model->GetLoanValueByID($id); // Removed
            echo json_encode($data);
        } else {
            redirect(base_url(), 'refresh');
        }        
    }

    public function Generate_salary() {
        if($this->session->userdata('user_login_access') != False) {    
            $data['typevalue'] = $this->payroll_model->GetsalaryType();   
            $data['employee'] = $this->employee_model->emselect();    
            $data['salaryvalue'] = $this->payroll_model->GetAllSalary();
            $data['department'] = $this->organization_model->depselect();    
            $this->load->view('backend/salary_view', $data);
        } else {
            redirect(base_url(), 'refresh');
        }  
    }

    public function Add_Sallary_Pay() {
        if($this->session->userdata('user_login_access') != False) {
            $id = $this->input->post('id');
            $emid = $this->input->post('emid');
            $month = $this->input->post('month');
            $basic = $this->input->post('basic');
            $totalday = $this->input->post('hours_worked'); // overwritten correctly
            $total = $this->input->post('total_paid');
            $paydate = $this->input->post('paydate');
            $status = $this->input->post('status');
            $paid_type = $this->input->post('paid_type');

            $this->form_validation->set_error_delimiters();
            $this->form_validation->set_rules('emid', 'Employee Id', 'trim|required');
            $this->form_validation->set_rules('basic', 'Employee Basic', 'trim|required|min_length[2]|max_length[7]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                $data = array(
                    'emp_id' => $emid,
                    'month' => $month,
                    'paid_date' => $paydate,
                    'total_days' => $totalday,
                    'basic' => $basic,
                    'total_pay' => $total,
                    'status' => $status,
                    'paid_type' => $paid_type
                );

                if(empty($id)) {
                    $success = $this->payroll_model->insert_Salary_Pay($data);
                    echo "Successfully Added";
                } else {
                    $success = $this->payroll_model->Update_SalaryPayInfo($id, $data);
                    echo "Successfully Updated";
                }
            }
        } else {
            redirect(base_url(), 'refresh');
        }
    }

    public function Add_Salary() {
        if($this->session->userdata('user_login_access') != False) { 
            $sid = $this->input->post('sid');
            $aid = $this->input->post('aid');
            $did = $this->input->post('did');
            $em_id = $this->input->post('emid');
            $basic = $this->input->post('basic');
            $medical = $this->input->post('medical');
            $houserent = $this->input->post('houserent');
            $bonus = $this->input->post('bonus');
            $provident = $this->input->post('provident');
            $bima = $this->input->post('bima');
            $tax = $this->input->post('tax');
            $others = $this->input->post('others');

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            $this->form_validation->set_rules('basic', 'basic', 'trim|required|min_length[3]|max_length[10]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                echo validation_errors();
            } else {
                $data = array(
                    'emp_id' => $em_id,
                    'basic' => $basic
                );

                if(!empty($sid)) {
                    $success = $this->employee_model->Update_Salary($sid, $data);
                    $data1 = array(
                        'salary_id' => $sid,
                        'medical' => $medical,
                        'house_rent' => $houserent,
                        'bonus' => $bonus
                    );
                    $success = $this->employee_model->Update_Addition($aid, $data1);
                    $data2 = array(
                        'salary_id' => $sid,
                        'provident_fund' => $provident,
                        'bima' => $bima,
                        'tax' => $tax,
                        'others' => $others
                    );
                    $success = $this->employee_model->Update_Deduction($did, $data2); 
                    echo "Successfully Updated";                
                } else {
                    $success = $this->employee_model->Add_Salary($data);
                    $insertId = $this->db->insert_id();
                    $data1 = array(
                        'salary_id' => $insertId,
                        'medical' => $medical,
                        'house_rent' => $houserent,
                        'bonus' => $bonus
                    );
                    $success = $this->employee_model->Add_Addition($data1);
                    $data2 = array(
                        'salary_id' => $insertId,
                        'provident_fund' => $provident,
                        'bima' => $bima,
                        'tax' => $tax,
                        'others' => $others
                    );
                    $success = $this->employee_model->Add_Deduction($data2); 
                    echo "Successfully Added";
                }           
            }
        } else {
            redirect(base_url(), 'refresh');
        }        
    } 

    public function Invoice(){
    if($this->session->userdata('user_login_access') != False) { 
        $id = $this->input->get('Id');   
        $eid = $this->input->get('em');   
        $data2 = array();

        $data['salary_info'] = $this->payroll_model->getAllSalaryDataById($id);
        $data['employee_info'] = $this->payroll_model->getEmployeeID($eid);
        $data['salaryvaluebyid'] = $this->payroll_model->Get_Salary_Value($eid);
        $data['salarypaybyid'] = $this->payroll_model->Get_SalaryID($eid);
        $data['salaryvalue'] = $this->payroll_model->GetsalaryValueByID($eid);
        $data['settingsvalue'] = $this->settings_model->GetSettingsValue();

        $data['addition'] = $this->payroll_model->getAdditionDataBySalaryID($data['salaryvalue']->id);
        $data['diduction'] = $this->payroll_model->getDiductionDataBySalaryID($data['salaryvalue']->id);
        $data['otherInfo'] = $this->payroll_model->getOtherInfo($eid);
        $data['bankinfo'] = $this->payroll_model->GetBankInfo($eid);

        $month_init = $data['salary_info']->month;
        $month = date("n", strtotime($month_init));
        $year = $data['salary_info']->year;
        $id_em = $data['employee_info']->em_id;

        $data['id_em'] = $id_em;
        $data['month'] = $month;

        if ($month < 10){
            $month = '0' . $month;
        }

        $employeePIN = $this->getPinFromID($id_em);

        // Count Friday
        $fridays = $this->count_friday($month, $year);

        // Count holidays
        $month_holiday_count = $this->payroll_model->getNumberOfHolidays($month, $year);
        $total_days_off = $fridays + $month_holiday_count->total_days;

        // Days and hours
        $total_days_in_the_month = $this->total_days_in_a_month($month, $year);
        $total_work_days = $total_days_in_the_month - $total_days_off;
        $total_work_hours = $total_work_days * 8;

        $start_date = $year . '-' . $month . '-' . 1;
        $end_date = $year . '-' . $month . '-' . $total_days_in_the_month;

        // Hours worked
        $employee_actually_worked = $this->hours_worked_by_employee($employeePIN->em_code, $start_date, $end_date);

        $employee_salary = $this->payroll_model->GetsalaryValueByID($id_em);
        if($employee_salary) {
            $employee_salary = $employee_salary->total;
        }

        $hourly_rate = $employee_salary / $total_work_hours;
        $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours);

        $data['work_h_diff'] = $work_hour_diff;

        $addition = 0;
        $diduction = 0;
        if($work_hour_diff < 0) {
            $addition = abs($work_hour_diff) * $hourly_rate;
        } else if($work_hour_diff > 0) {
            $diduction = abs($work_hour_diff) * $hourly_rate;
        }

        // Final values
        $data['a'] = $addition;
        $data['d'] = $data['salary_info']->diduction;

        $this->load->view('backend/invoice', $data);
    } else {
        redirect(base_url(), 'refresh');
    }        
    }









    // Start Invoice
public function load_employee_Invoice_by_EmId_for_pay(){
    if($this->session->userdata('user_login_access') != False) {  
        $eid = $this->input->get('emid');
        $dateval = $this->input->get('date_time');
        $orderdate = explode('-', $dateval);
        $month = $orderdate[0];
        $year = $orderdate[1];
        $month = $this->month_number_to_name($month);

        $data2 = array();
        $salary_info = $this->payroll_model->getAllSalaryDataByMonthYearEm($eid,$month,$year);
        if(empty($salary_info)){
            echo "No Data Found";
            die();
        }

        $employee_info = $this->payroll_model->getEmployeeID($eid);
        $salaryvaluebyid = $this->payroll_model->Get_Salary_Value($eid);
        $salarypaybyid = $this->payroll_model->Get_SalaryID($eid);
        $salaryvalue = $this->payroll_model->GetsalaryValueByID($eid);
        $settingsvalue = $this->settings_model->GetSettingsValue();

        $addition = $this->payroll_model->getAdditionDataBySalaryID($salaryvalue->id);
        $diduction = $this->payroll_model->getDiductionDataBySalaryID($salaryvalue->id);

        $otherInfo = $this->payroll_model->getOtherInfo($eid);
        $bankinfo = $this->payroll_model->GetBankInfo($eid);

        $month_init = $salary_info->month;
        $month = date("n",strtotime($month_init));
        $year = $salary_info->year;
        $id_em = $employee_info->em_id;

        if ($month<10){
            $month = '0' . $month;
        }

        $employeePIN = $this->getPinFromID($id_em);

        // Count Friday and holidays
        $fridays = $this->count_friday($month, $year);
        $month_holiday_count = $this->payroll_model->getNumberOfHolidays($month, $year);

        $total_days_off = $fridays + $month_holiday_count->total_days;
        $total_days_in_the_month = $this->total_days_in_a_month($month, $year);
        $total_work_days = $total_days_in_the_month - $total_days_off;
        $total_work_hours = $total_work_days * 8;

        $start_date = $year . '-' . $month . '-' . 1;
        $end_date = $year . '-' . $month . '-' . $total_days_in_the_month;

        $employee_actually_worked = $this->hours_worked_by_employee($employeePIN->em_code, $start_date, $end_date);

        $employee_salary = $this->payroll_model->GetsalaryValueByID($id_em);
        if($employee_salary) {
            $employee_salary = $employee_salary->total;
        }

        $hourly_rate = $employee_salary / $total_work_hours;
        $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours);
        $work_h_diff = $work_hour_diff;

        if($work_hour_diff < 0) {
            $addition = abs($work_hour_diff) * $hourly_rate;
        } else if($work_hour_diff > 0) {
            $diduction = abs($work_hour_diff) * $hourly_rate;
        }

        $obj_merged = (object) array_merge((array) $employee_info, (array) $salaryvaluebyid, (array) $salarypaybyid, (array) $salaryvalue);

        $dd = date('j F Y',strtotime($salary_info->paid_date));
        $a = $addition;
        $d = $diduction;
        $base = base_url();

        echo "<div class='row payslip_print' id='payslip_print'>
        <div class='col-md-12'>
        <div class='card card-body'>
        <div class='row'>
        <div class='col-md-4 col-xs-6 col-sm-6'>
        <img src='$base/assets/images/hrinv.png' style=' width:180px; margin-right: 10px;' />
        </div>
        <div class='col-md-8 col-xs-6 col-sm-6 text-left payslip_address'>
        <p>$settingsvalue->address</p>
        <p>$settingsvalue->address2</p>
        <p>Phone: $settingsvalue->contact, Email: $settingsvalue->system_email</p>
        </div>
        </div>
        <div class='row'>
        <div class='col-md-12 text-left'>
        <h5 style='margin-top: 15px;'>Payslip for the period of $salary_info->month $salary_info->year</h5>
        </div>
        </div>
        <div class='row' style='margin-bottom: 5px;'>
        <div class='col-md-12'>
        <table class='table table-condensed borderless payslip_info'>
        <tr>
            <td>Employee PIN</td>
            <td>: $obj_merged->em_code</td>
            <td>Employee Name</td>
            <td>: $salary_info->first_name $salary_info->last_name</td>
        </tr>
        <tr>
            <td>Department</td>
            <td>: ".$otherInfo[0]->dep_name."</td>
            <td>Designation</td>
            <td>: ".$otherInfo[0]->name."</td>
        </tr>
        <tr>
            <td>Pay Date</td>
            <td>: $dd</td>
            <td>Date of Joining</td>
            <td>: $obj_merged->em_joining_date</td>
        </tr>
        <tr>
            <td>Days Worked</td>
            <td>: ".ceil($salary_info->total_days / 8)."</td>";
            if(!empty($bankinfo->bank_name)){
                echo "<td>Bank Name</td><td>: $bankinfo->bank_name</td>";
            } else {
                echo "<td>Pay Type</td><td>: Hand Cash</td>";
            }
        echo "</tr>";
        if(!empty($bankinfo->bank_name)){
            echo "<tr>
                <td>Account Name</td>
                <td>: $bankinfo->holder_name </td>
                <td>Account Number</td>
                <td>: $bankinfo->account_number </td>
            </tr>";
        }
        echo "</table>
        </div>
        </div>
        <style>
            .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td { padding: 2px 5px; }
        </style>
        <div class='row'>
        <div class='col-md-12'>
        <table class='table table-condensed borderless' style='border-left: 1px solid #ececec;'>
        <thead class='thead-light' style='border: 1px solid #ececec;'>
        <tr>
            <th>Description</th>
            <th class='text-right'>Earnings</th>
            <th class='text-right'>Deductions</th>
        </tr>
        </thead>
        <tbody style='border: 1px solid #ececec;'>
        <tr>
            <td>Basic Salary</td>
            <td class='text-right'>".$addition[0]->basic." USD</td>
            <td class='text-right'>  </td>
        </tr>
        <tr>
            <td>Medical Allowance</td>
            <td class='text-right'>".$addition[0]->medical." USD</td>
            <td class='text-right'>  </td>
        </tr>
        <tr>
            <td>House Rent</td>
            <td class='text-right'>".$addition[0]->house_rent." USD</td>
            <td class='text-right'>  </td>
        </tr>
        <tr>
            <td>Conveyance Allowance</td>
            <td class='text-right'>".$addition[0]->conveyance." USD</td>
            <td class='text-right'>  </td>
        </tr>
        <tr>
            <td>Bonus</td>
            <td class='text-right'>".$salary_info->bonus."</td>
            <td class='text-right'></td>
        </tr>
        <tr>
            <td>Working Hour ($salary_info->total_days hrs)</td>
            <td class='text-right'></td>
            <td class='text-right'> $salary_info->diduction USD</td>
        </tr>
        <tr>
            <td>Tax</td>
            <td class='text-right'></td>
            <td class='text-right'></td>
        </tr>
        </tbody>
        <tfoot class='tfoot-light'>
        <tr>
            <th>Total</th>
            <th class='text-right'>".round($salary_info->basic + $salary_info->medical + $salary_info->house_rent + $salary_info->bonus, 2)." USD</th>
            <th class='text-right'>".round($salary_info->diduction, 2)." USD</th>
        </tr>
        <tr>
            <th></th>
            <th class='text-right'>Net Pay</th>
            <th class='text-right'>$salary_info->total_pay USD</th>
        </tr>
        </tfoot>
        </table>
        </div>
        </div>
        </div>
        </div>
        </div>";
    } else {
        redirect(base_url(), 'refresh');
    }       
}






    // End Invoice

    private function count_friday($month, $year) {
        $fridays=0;
        $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        for($i=1;$i<=$total_days;$i++) {
            if(date('N',strtotime($year.'-'.$month.'-'.$i))==5) {
                $fridays++;
            }
        }
        return $fridays;
    }

    private function total_days_in_a_month($month, $year) {
        return cal_days_in_month(CAL_GREGORIAN, $month, $year);
    }

    // Totals hours worked by an emplyee in a month
    private function hours_worked_by_employee($employeeID, $start_date, $end_date) {
        return $this->payroll_model->totalHoursWorkedByEmployeeInAMonth($employeeID, $start_date, $end_date);
    }

    private function getPinFromID($employeeID) {
        return $this->payroll_model->getPinFromID($employeeID);
    }

    /*GET WORKHOURS OF ANY MONTH - */
    /*||||| Method has not been used anywhere |||||*/
    public function GetSalaryByWorkdays(){
    if($this->session->userdata('user_login_access') != False) {  

        $monthName = $this->input->get('monthName');
        $employeeID = $this->input->get('employeeID');
        $year = date("Y");

        $fridays = $this->count_friday($monthName, $year);
        $month_holiday_count = $this->payroll_model->getNumberOfHolidays($monthName, $year);
        $total_days_off = $fridays + $month_holiday_count->total_days;

        $total_days_in_the_month = $this->total_days_in_a_month($monthName, $year);
        $total_work_days = $total_days_in_the_month - $total_days_off;
        $total_work_hours = $total_work_days * 8;

        $start_date = $year . '-' . $monthName . '-01';
        $end_date = $year . '-' . $monthName . '-' . $total_days_in_the_month;

        $employee_actually_worked = $this->hours_worked_by_employee($employeeID, $start_date, $end_date);
        $employee_salary = $this->payroll_model->GetsalaryValueByID($employeeID);
        if($employee_salary) {
            $employee_salary = $employee_salary->total;
        }

        $hourly_rate = $employee_salary / $total_work_hours;

        $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours);
        $addition = 0;
        $diduction = 0;

        if($work_hour_diff < 0) {
            $addition = abs($work_hour_diff) * $hourly_rate;
        } else if($work_hour_diff > 0) {
            $diduction = abs($work_hour_diff) * $hourly_rate;
        }

        $data = array(
            'basic_salary' => $employee_salary,
            'total_work_hours' => $total_work_hours,
            'employee_actually_worked' => $employee_actually_worked[0]->Hours,
            'addition' => $addition,
            'diduction' => $diduction,
        );

        echo json_encode($data);

    } else {
        redirect(base_url(), 'refresh');
    }        
}

    public function month_number_to_name($month) {
        $dateObj   = DateTime::createFromFormat('!m', $month);
        return $dateObj->format('F'); // March
    }

    public function get_full_name($first_name, $last_name) {
        return $first_name . ' ' . $last_name;
    }

    // Add or update the salary record
    public function pay_salary_add_record() {
    if($this->session->userdata('user_login_access') != False) {

        $emid = $this->input->post('emid');
        $month = $this->month_number_to_name($this->input->post('month'));
        $basic = $this->input->post('basic');
        $year = $this->input->post('year');
        $hours_worked = $this->input->post('hours_worked');
        $addition = $this->input->post('addition');
        $diduction = $this->input->post('diduction');
        $total_paid = $this->input->post('total_paid');
        $paydate = $this->input->post('paydate');
        $status = $this->input->post('status');
        $paid_type = $this->input->post('paid_type');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('basic', 'basic', 'trim|required|min_length[3]|max_length[10]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
        } else {
            $data = array(
                'emp_id' => $emid,
                'month' => $month,
                'year' => $year,
                'paid_date' => $paydate,
                'total_days' => $hours_worked,
                'basic' => $basic,
                'total_pay' => $total_paid,
                'addition' => $addition,
                'diduction' => $diduction,
                'status' => $status,
                'paid_type' => $paid_type,
            );

            $get_salary_record = $this->payroll_model->getSalaryRecord($emid, $month, $year);

            if($get_salary_record) {
                $payID = $get_salary_record[0]->pay_id;
                $payment_status = $get_salary_record[0]->status;
            }

            if( isset($payID) && $payID > 0 ) {
                if($payment_status == "Paid") {
                    echo "Has already been paid";
                } else {
                    $this->payroll_model->updatePaidSalaryData($payID, $data);
                    echo "Successfully updated";
                }
            } else {
                $this->payroll_model->insertPaidSalaryData($data);
                echo "Successfully added";
            }
        }
    } else {
        redirect(base_url(), 'refresh');
    }        
}

    // Generate the list of employees by dept. to generate their payments
    public function load_employee_by_deptID_for_pay(){

        if($this->session->userdata('user_login_access') != False) {  

        // Get the month and year
        $date_time = $this->input->get('date_time');
        $dep_id = $this->input->get('dep_id');

        $year = explode('-', $date_time);
        $month = $year[0];
        $year = $year[1];

        $employees = $this->payroll_model->GetDepEmployee($dep_id);

        foreach($employees as $employee){

            $full_name = $this->get_full_name($employee->first_name, $employee->last_name);

            echo "<tr>
                    <td>$employee->em_code</td>
                    <td>$full_name</td>
                    <td>$employee->total</td>
                    <td><a href=''
                                data-id='$employee->em_id' 
                                data-month='$month' 
                                data-year='$year' 
                                class='btn btn-sm btn-danger waves-effect waves-light salaryGenerateModal' 
                                data-toggle='modal'
                                data-target='#salaryGenerateModal'>
                        Generate Salary</a></td>
                </tr>";
        }

        echo json_encode(array());
        }
        else{
            redirect(base_url() , 'refresh');
        }        
    }


    public function generate_payroll_for_each_employee(){
    if($this->session->userdata('user_login_access') != False) {

        $month = $this->input->get('month');
        $year = $this->input->get('year');
        $employeeID = $this->input->get('employeeID');

        $employeePIN = $this->getPinFromID($employeeID);
        $fridays = $this->count_friday($month, $year);
        $month_holiday_count = $this->payroll_model->getNumberOfHolidays($month, $year);

        $total_days_off = $fridays + $month_holiday_count->total_days;
        $total_days_in_the_month = $this->total_days_in_a_month($month, $year);
        $total_work_days = $total_days_in_the_month - $total_days_off;
        $total_work_hours = $total_work_days * 8;

        $start_date = "{$year}-{$month}-01";
        $end_date = "{$year}-{$month}-{$total_days_in_the_month}";

        $employee_actually_worked = $this->hours_worked_by_employee($employeePIN->em_code, $start_date, $end_date);
        $employee_salary = $this->payroll_model->GetsalaryValueByID($employeeID);
        if($employee_salary) {
            $employee_salary = $employee_salary->total;
        }

        $hourly_rate = $employee_salary / $total_work_hours;
        $work_hour_diff = abs($total_work_hours) - abs($employee_actually_worked[0]->Hours);

        $addition = 0;
        $diduction = 0;

        if($work_hour_diff < 0) {
            $addition = abs($work_hour_diff) * $hourly_rate;
        } else if($work_hour_diff > 0) {
            $diduction = abs($work_hour_diff) * $hourly_rate;
        }

        $final_salary = $employee_salary + $addition - $diduction;

        $data = array(
            'basic_salary' => $employee_salary,
            'total_work_hours' => $total_work_hours,
            'employee_actually_worked' => $employee_actually_worked[0]->Hours,
            'wpay' => $total_work_hours - $employee_actually_worked[0]->Hours,
            'addition' => round($addition, 2),
            'diduction' => round($diduction, 2),
            'final_salary' => round($final_salary, 2),
            'rate' => round($hourly_rate, 2)
        );

        echo json_encode($data);

    } else {
        redirect(base_url(), 'refresh');
    }      
}

    public function Payslip_Report(){
        if($this->session->userdata('user_login_access') != False) {  
        $data=array();    
        $data['employee'] = $this->employee_model->emselect();
        $this->load->view('backend/salary_report',$data);
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }

}