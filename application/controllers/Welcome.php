<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->helper('url');

		$this->load->view('welcome_message');
	}


	function sample(){
		$this->load->helper(['key','date']);
		$this->load->database();

		$data = array(
			'key' => my_keygen('api_keys',true),
			'date_created' => now(),
		);

		//$this->db->insert('api_keys',$data);
	}

	function kalender(){
		$this->load->model('kalender_m','km');
		header('Content-Type: application/json');
		echo json_encode($this->km->get_event($this->input->get('id_smt')));
	}
	function nilai(){
		$this->load->model('hasil_studi_m','hsm');
		header('Content-Type: application/json');
		echo json_encode($this->hsm->get_nilai($this->input->get('nim'),$this->input->get('smt')));
	}
	function jadwal(){
		$this->load->model('kelas_m','klm');
		header('Content-Type: application/json');
		echo json_encode($this->klm->get_jadwal($this->input->get('nim'),$this->input->get('smt')));
	}
}
