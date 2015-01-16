<?php 

class JmjoyAdmin extends CI_Controller {

	public function index() {
		if ($this->checkSignIn()) {
			redirect('jmjoyadmin/base');
		}
		$data['username'] = $this->input->cookie('admin_form_username');
		setcookie('admin_form_username', '', time() - 3600);
		$data['msg'] = $this->input->cookie('admin_form_msg');
		setcookie('admin_form_msg', '', time() - 3600);

		$this->load->view('admin/index', $data);
	}
	
	public function base() {
		$this->forbiddenIfNotSignIn();
		$this->load->view('admin/base');
	}
	
	public function home() {
		$this->forbiddenIfNotSignIn();
		$this->load->view('admin/home');
	}
	
	public function category() {
		$this->forbiddenIfNotSignIn();
		$this->load->view('admin/category');
	}	
	
	public function user() {
		$this->forbiddenIfNotSignIn();
		$this->load->view('admin/user');
	}
	
	public function listUser() {
		
	}
	
	public function room() {
		$this->forbiddenIfNotSignIn();
		$this->load->view('admin/room');
	}
	
	public function info() {
		$this->forbiddenIfNotSignIn();
		phpinfo();
	}
	
	public function handleSignIn() {
		$username = $this->input->post('username');
		if ($username == "") {
			setcookie('admin_form_username', $username, 0);
			setcookie('admin_form_msg', '账号不能为空', 0);
			return redirect('jmjoyadmin/index');
		}
		$password =  $this->input->post('password');
		if ($password == "") {
			setcookie('admin_form_username', $username, 0);
			setcookie('admin_form_msg', '密码不能为空', 0);
			return redirect('jmjoyadmin/index');
		}
		$sql = 'select id, username, password 
				from lc_admin 
				where username = ?
				limit 1';
		$query = $this->db->query($sql, $username);
		if ($query->num_rows() <= 0) {
			setcookie('admin_form_username', $username, 0);
			setcookie('admin_form_msg', '账号不存在', 0);
			return redirect('jmjoyadmin/index');
		}
		$row = $query->row();
		if ($row->password != sha1(md5($password))) {
			setcookie('admin_form_username', $username, 0);
			setcookie('admin_form_msg', '密码错误', 0);
			return redirect('jmjoyadmin/index');			
		}
		session_start();
		$_SESSION['admin']['id'] = $row->id;
		$_SESSION['admin']['id'] = $row->username;
		redirect('jmjoyadmin/base');
	}
	
	public function handleSignOut() {
		session_start();
		unset($_SESSION['admin']);
		redirect('jmjoyadmin/index');
	}
	
	protected function checkSignIn() {
		session_start();
		if (!isset($_SESSION['admin']['id'])) {
			return false;
		}
		return true;
	}

	protected function forbiddenIfNotSignIn() {
		if (!$this->checkSignIn()) {
			redirect('jmjoyadmin/index');
			die();
		}
	}
	
}
