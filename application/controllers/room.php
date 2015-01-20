<?php 

class Room extends CI_Controller {

	public function index($cate_id = 0) {
		$cate_id = intval($cate_id);
		
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
		
		$data['cate_id'] = $cate_id;
		$data['timestamp'] = time() - 5 * 60;
		$this->load->view('room/index', $data);
	}
	
	public function sendMsg($cate_id = 0) {
		$cate_id = intval($cate_id);

		session_start();
		if (!isset($_SESSION['user']['id'])) {
			return;
		}
		$uid = $_SESSION['user']['id'];
		
		if (!$this->isCategoryExist($cate_id)) {
			return;
		}
		
		$content = $this->input->post('content');
		$content = mb_substr($content, 0, 250, 'utf-8');
		if ($content == "") {
			return;
		}
		
		$sql = "insert into lc_room_auto_{$cate_id} values(null, ?, ?, ?)";
		$this->db->query($sql, array($uid, $content, time()));
	}
	
	public function getMsg($cate_id = 0) {
		// set php runtime to unlimited
		set_time_limit(0);
		
		$cate_id = intval($cate_id);
		if (!$this->isCategoryExist($cate_id)) {
			return;
		}
		$timestamp = intval($this->input->post('timestamp'));
		
		// main loop
		while (true) {

			$sql = "select max(ctime) max_time from lc_room_auto_{$cate_id}";
			$query = $this->db->query($sql);
			$row = $query->row();
			
			if ($row->max_time <= $timestamp) {
				sleep(1);
				continue;
			}
			$max_time = $row->max_time;
			
			$sql = "select u.username, r.content, r.ctime
					from lc_room_auto_{$cate_id} r 
					join lc_user u 
					on r.uid = u.id 
					where r.ctime > ?
					limit 100";
			$query = $this->db->query($sql, $timestamp);
			$resArr = $query->result_array();
			
			foreach ($resArr as $key => $row) {
				$resArr[$key]['content'] = htmlspecialchars($row['content']);
				$resArr[$key]['ctime'] = date('Y-m-d H:i:s', $row['ctime']);
			}
			
		    echo json_encode(array(
		    		'timestamp'		=>	$max_time,
		    		'msgs'			=>	$resArr,
		    ));
		    
		    break;
		}
	}
	
	protected function getCategoryName($cate_id) {
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
	
	protected function isCategoryExist($cate_id) {
		$sql = "select 1 from lc_category where id = ? limit 1";
		$query = $this->db->query($sql, $cate_id);
		if ($query->num_rows() <= 0) {
			return false;
		}
		return true;
	}
	
}