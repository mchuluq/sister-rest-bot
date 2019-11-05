<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Hasil_studi extends CI_Controller {

    use REST_Controller { 
        REST_Controller::__construct as private __resTraitConstruct; 
    }

    function __construct(){
        parent::__construct();
        $this->__resTraitConstruct();

        $this->load->library('form_validation');
        $this->load->model('hasil_studi_m','hsm');
    }

    function nilai_get(){
	    $input = $this->input->get(['nim','smt']);
        $this->form_validation->set_data($input);
        $this->form_validation->set_rules('nim','NIM','required|max_length[20]|min_length[8]');
        $this->form_validation->set_rules('smt','semester','required|max_length[2]|in_list[1,2,3,4,5,6,7,8,9,10,11,12,13,14]');
        $this->form_validation->set_error_delimiters('', ' ');
        if($this->form_validation->run()){
            $data = $this->hsm->get_nilai($this->input->get('nim'),$this->input->get('smt'));
            if(!$data){
                $this->response([
                    'status' => false,
                    'message' => $this->hsm->message
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