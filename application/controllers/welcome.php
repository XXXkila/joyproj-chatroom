<?php 

class Welcome extends CI_Controller {

	public function index() {
		$data['is_sign_in'] = $this->checkSignIn();
		if (!$data['is_sign_in']) {
			$data['email'] = $this->input->cookie('user_form_email');
			setcookie('user_form_email', '', time() - 3600);
			$data['msg'] = $this->input->cookie('user_form_msg');
			setcookie('user_form_msg', '', time() - 3600);			
		}
		$this->load->view('welcome/index', $data);
	}
	
	public function handleSignIn() {
		$email = $this->input->post('email');
		if ($email == "") {
			setcookie('user_form_email', $email, 0);
			setcookie('user_form_msg', ' 邮箱不能为空', 0);
			return redirect('welcome/index');
		}
		$password =  $this->input->post('password');
		if ($password == "") {
			setcookie('user_form_username', $email, 0);
			setcookie('user_form_msg', '密码不能为空', 0);
			return redirect('welcome/index');
		}
		$sql = 'select id, username, email, password, ctime
				from lc_user
				where email = ?
				limit 1';
		$query = $this->db->query($sql, $email);
		if ($query->num_rows() <= 0) {
			setcookie('user_form_username', $email, 0);
			setcookie('user_form_msg', '邮箱不存在', 0);
			return redirect('welcome/index');
		}
		$row = $query->row();
		if ($row->password != sha1(md5($password))) {
			setcookie('user_form_email', $email, 0);
			setcookie('user_form_msg', '密码错误', 0);
			return redirect('welcome/index');
		}
		session_start();
		$_SESSION['user']['id'] = $row->id;
		$_SESSION['user']['id'] = $row->username;
		return redirect('welcome/index');
	}
	
	public function signUp() {
		$this->load->view('welcome/signUp');
	}
	
	public function handleSignUp() {
		$email = $this->input->post("email");
		$result = $this->validateEmail($email);
		if (!$result['status']) {
			return;
		}
		$password = $this->input->post("password");
		$result = $this->validatePassword($password);
		if (!$result['status']) {
			return;
		}
		$sql = 'insert into lc_user values(null, "", ?, ?, ?)';
		$data[] = $email;
		$data[] = sha1(md5($password));
		$data[] = time();
		$this->db->query($sql, $data);
		redirect('welcome/index');
	}
	
	public function ajaxValidateEmail() {
		$email = $this->input->post('email');
		echo json_encode($this->validateEmail($email));
	}
	
	protected function validateEmail($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return array(
					'status'	=>	false,
					'msg'		=>	'邮箱地址不合法'
			);
		}
		$sql = 'select count(*) c from lc_user where email = ?';
		$query = $this->db->query($sql, $email);
		$row = $query->row();
		if ($row->c > 0) {
			return array(
					'status'	=>	false,
					'msg'		=>	'邮箱地址已存在',
			);
		}
		return array(
				'status'	=>	true,
				'msg'		=>	'',
		);
	}
	
	protected function validatePassword($password) {
		if (!preg_match('/\S{6,32}/', $password)) {
			return array(
					'status'	=>	false,
					'msg'		=>	'密码格式不对',			
			);
		}
		return array(
				'status'	=>	true,
				'msg'		=>	'',
		);
	}
	
	protected function checkSignIn() {
		session_start();
		if (!isset($_SESSION['user']['id'])) {
			return false;
		}
		return true;
	}
	
}
