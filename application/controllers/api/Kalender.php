<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Kalender extends CI_Controller {
    
    use REST_Controller { 
        REST_Controller::__construct as private __resTraitConstruct; 
    }

    function __construct(){
        parent::__construct();
        $this->__resTraitConstruct();
		$this->load->library('form_validation');
		$this->load->model('kalender_m','km');
  	}

	function index_get(){
		$input = $this->input->get(['id_smt']);
        $this->form_validation->set_data($input);
        $this->form_validation->set_rules('id_smt','Semester','required|numeric|exact_length[5]');
        $this->form_validation->set_error_delimiters('', ' ');
        if($this->form_validation->run()){
            $data = $this->km->get_event($this->input->get('id_smt'));
            if(!$data){
                $this->response([
                    'status' => false,
                    'message' => $this->km->message
                ], 400);
            }else{
                $this->response([
                    'status' => true,
                    'data' => $data
                ], 200);
            }		
        }else{
            $this->response([
                'status' => false,
                'message' => validation_errors(),
            ], 400);
        }
	}

}