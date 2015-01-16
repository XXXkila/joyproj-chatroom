<?php 

class Room extends CI_Controller {

	public function index() {
		$this->load->view('room/index');
	}
	
	public function sendMsg() {
		
	}
	
	public function getMsg() {
		// set php runtime to unlimited
		set_time_limit(0);
		// main loop
		while (true) {
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
	
}