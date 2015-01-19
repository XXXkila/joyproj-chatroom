<?php 

class Welcome extends CI_Controller {

	public function index() {
		$data['is_sign_in'] = $this->checkSignIn();
		if (!$data['is_sign_in']) {
			$data['email'] = $this->input->cookie('user_form_email');
			setcookie('user_form_email', '', time() - 3600);
			$data['msg'] = $this->input->cookie('user_form_msg');
			setcookie('user_form_msg', '', time() - 3600);
			$data['succ'] = $this->input->cookie('user_form_succ');
			setcookie('user_form_succ', '', time() - 3600);
		} else {
			$data['username'] = $_SESSION['user']['username'];
		}
		$this->load->view('welcome/index', $data);
	}
	
	public function signUp() {
		$this->load->view('welcome/signUp');
	}
	
	public function forget() {
		$this->load->view('welcome/forget');
	}
	
	public function changePassword() {
		$token = $this->input->get('token');
		if ($token == "") {
			return;
		}
		$this->load->library('encrypt');
		$token = $this->encrypt->decode($token);
		$raw_token = explode('|', $token);
		if (!is_array($raw_token) || count($raw_token) != 2) {
			return;
		}
		$uid = $raw_token[0];
		$token = $raw_token[1];
		
		$sql = 'select id, token, ctime  
				from lc_user_token 
				where uid = ?';
		$query = $this->db->query($sql, $uid);
		if ($query->num_rows() <= 0) {
			return;
		}
		$row = $query->row();
		if ($row->token != $token) {
			return;
		}
		if ($row->ctime + 20 * 60 < time()) {
			$data['status'] = false;
		} else {
			$data['status'] = true;
			session_start();
			$_SESSION['forget_uid'] = $uid;
		}
		$this->load->view('welcome/changePassword', $data);
	}	
	
	public function mailSuccess() {
		$data['status'] = $this->input->cookie('forget_status');
		setcookie('forget_status', '', time() - 3600);
		$data['email'] = $this->input->cookie('forget_email');
		setcookie('forget_email', '', time() - 3600);
		$this->load->view('welcome/mailSuccess', $data);
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
		if ($row->password != sha1($password)) {
			setcookie('user_form_email', $email, 0);
			setcookie('user_form_msg', '密码错误', 0);
			return redirect('welcome/index');
		}
		session_start();
		$_SESSION['user']['id'] = $row->id;
		$_SESSION['user']['username'] = $row->username;
		return redirect('welcome/index');
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
		$username = $this->input->post('username');
		$result = $this->validateUsername($username);
		if (!$result['status']) {
			return;
		}
		
		$sql = 'insert into lc_user values(null, ?, ?, ?, ?)';
		$data[] = $username;
		$data[] = $email;
		$data[] = sha1(md5($password));
		$data[] = time();
		$this->db->query($sql, $data);
		
		setcookie('user_form_succ', '注册成功', 0);
		redirect('welcome/index');
	}
	
	public function handleForget() {
		$verify = $this->input->post('verify');
		$this->load->helper('verifycode');
		if (!check_verifycode($verify)) {
			return;
		}
		
		$email = $this->input->post('email');
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return;
		}

		$sql = 'select id, username 
				from lc_user 
				where email = ?
				limit 1';
		$query = $this->db->query($sql, $email);
		if ($query->num_rows() < 1) {
			return;
		}
		$row = $query->row();
		
		$uid = intval($row->id);
		$username = $row->username;
		$date = date('Y-m-d H:i:s');
		$token = md5(uniqid());
		
		$sql = 'delete from lc_user_token where uid = ?';
		$this->db->query($sql, $uid);
		
		$sql = 'insert into lc_user_token values(null, ?, ?, ?)';
		$this->db->query($sql, array($uid, $token, time()));
		
		$this->load->library('encrypt');
		$token = $this->encrypt->encode($uid . '|' . $token);
		$token = urlencode($token);
		
		$url = site_url('welcome/changePassword') . "?token=$token";
		
		$this->load->library('mailer');
		$subject = '找回密码';
		$body = "
您好，$username ：

请点击下面的链接来重置您的密码。

$url

如果您的邮箱不支持链接点击，请将以上链接地址拷贝到你的浏览器地址栏中。

该验证邮件有效期为22分钟，超时请重新发送邮件。

发件时间：$date

此邮件为系统自动发出的，请勿直接回复。";
		
		$result = $this->mailer->sendEmail($email, $subject, $body);
		
		if (!$result) {
			setcookie('forget_status', 'false', 0);
		} else {
			setcookie('forget_status', 'true', 0);
		}
		setcookie('forget_email', $email, 0);
		redirect('welcome/mailSuccess');
	}
	
	public function handleChangePassword() {
		session_start();
		if (!isset($_SESSION['forget_uid'])) {
			echo '操作超时！';
			return;
		}
		
		$uid = intval($_SESSION['forget_uid']);
		$password = $this->input->post('password');
		$result = $this->validatePassword($password);
		if (!$result['status']) {
			return;
		}
		
		$password = sha1(md5($password));
		$sql = 'update lc_user 
				set password = ?
				where id = ?';
		$this->db->query($sql, array($password, $uid));
		
		setcookie('user_form_succ', '密码修改成功', 0);
		redirect('welcome/index');
	}	
	
	public function ajaxValidateEmail() {
		$email = $this->input->post('email');
		echo json_encode($this->validateEmail($email));
	}
	
	public function ajaxValidateEmailAndExist() {
		$email = $this->input->post('email');
		echo json_encode($this->validateEmailAndExist($email));
	}
	
	public function ajaxCheckVerifyCode() {
		$verify = $this->input->post('verify');
		$this->load->helper('verifycode');
		echo json_encode(array(
				'status'	=>	check_verifycode($verify, false)
		));
	}
	
	public function getVerifyCode() {
		$this->load->helper('verifycode');
		create_verifycode();
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
		if ($row->c) {
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
	
	protected function validateEmailAndExist($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return array(
					'status'	=>	false,
					'msg'		=>	'邮箱地址不合法'
			);
		}
		$sql = 'select count(*) c from lc_user where email = ?';
		$query = $this->db->query($sql, $email);
		$row = $query->row();
		if (!$row->c) {
			return array(
					'status'	=>	false,
					'msg'		=>	'邮箱地址不存在',
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
	
	protected function validateUsername($username) {
		if (!preg_match('/^[-\w\x{4e00}-\x{9fa5}]{2,8}$/u', $username)) {
			return array(
					'status'	=>	false,
					'msg'		=>	'用户名格式不对',			
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
