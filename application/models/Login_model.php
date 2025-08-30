<?php

	class Login_model extends CI_Model{


	function __construct(){
	parent::__construct();
	 $this->load->library('form_validation');
	
	}
	public function getUserForLogin($credential){			
    return $this->db->get_where('employee', $credential);
	}
	public function getdata(){
	$query =$this->db->get('users');
	$result=$query->result();
	return $result;
	}
	public function login_log_report() {
    $this->load->model('Login_model');
    $data['logs'] = $this->Login_model->get_login_logs();
    $this->load->view('admin/login_log_report', $data);
}

	
    public function Does_email_exists($email) {
		$user = $this->db->dbprefix('users');
        $sql = "SELECT `email` FROM $user
		WHERE `email`='$email'";
		$result=$this->db->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }
    public function insertUser($data){
		$this->db->insert('users',$data);
	}
	public function UpdateKey($data,$email){
		$this->db->where('email',$email);
		$this->db->update('users',$data);
	}
	public function UpdatePassword($key,$data){
		$this->db->where('forgotten_code',$key);
		$this->db->update('users',$data);	    
	}	
	public function UpdateStatus($verifycode,$data){
		$this->db->where('confirm_code',$verifycode);
		$this->db->update('users',$data);	    
	}
	
    public function Does_Key_exists($reset_key) {
		$user = $this->db->dbprefix('users');
        $sql = "SELECT `forgotten_code` FROM $user
		WHERE `forgotten_code`='$reset_key'";
		$result=$this->db->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }
	public function GetUserInfo($key){
		$user = $this->db->dbprefix('users');
        $sql = "SELECT `password` FROM $user
		WHERE `forgotten_code`='$key'";
		$query=$this->db->query($sql);
		$result = $query->row();
		return $result;			
	}		
	public function GetuserInfoBycode($verifycode){
		$user = $this->db->dbprefix('users');
        $sql = "SELECT * FROM $user
		WHERE `confirm_code`='$verifycode'";
		$query=$this->db->query($sql);
		$result = $query->row();
		return $result;			
	}	
}
?>