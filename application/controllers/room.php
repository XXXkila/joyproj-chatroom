<?php 

class Room extends CI_Controller {

	public function index($cate_id) {
		$data['cate_name'] = $this->getCategoryName($cate_id);
		
		if ($data['cate_name'] === false) {
			echo '非法访问';
			return;
		}
		
		session_start();		
		if (isset($_SESSION['user']['username'])) {
			$data['username'] = $_SESSION['user']['username'];
		} else {
			$data['username'] = '游客';
		}
		
		$this->load->view('room/index', $data);
	}
	
	public function sendMsg() {
		
	}
	
	public function getMsg() {
		// set php runtime to unlimited
		set_time_limit(0);
		// main loop
		while (true) {
			
			continue;
			
		    $timestamp = intval($this->input->post('timestamp'));
		    usleep(500000);
		    
		    $msgs = array(
		    		array('username' => 'jmjoy', 'time' => 123, 'content' => 'thinkphp'),
		    		array('username' => 'jmjoy', 'time' => 123, 'content' => 'thinkphp'),
		    		array('username' => 'jmjoy', 'time' => 123, 'content' => 'thinkphp'),
		    		array('username' => 'jmjoy', 'time' => 123, 'content' => 'thinkphp'),
		    		array('username' => 'jmjoy', 'time' => 123, 'content' => 'thinkphp'),
		    );
		    echo json_encode(array(
		    		'timestamp'		=>	time(),
		    		'msgs'			=>	$msgs,
		    ));
		    break;
		}
	}
	
	protected function getCategoryName($cate_id) {
		$cate_id = intval($cate_id);
		$sql = 'select sub.name sub_name, parent.name parent_name 
				from lc_category sub
				join lc_category parent
				on sub.parent_id = parent.id
				where sub.id = ?
				limit 1';
		$query = $this->db->query($sql, $cate_id);
		
		if ($query->num_rows() <= 0) {
			return false;
		}
		$row = $query->row();
		
		return $row->parent_name . ' / ' . $row->sub_name;
	}
	
}