<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Kartu_ujian extends MY_REST_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('akademik/Kartu_ujian_model','kum');
        $this->load->library('form_validation');
    }

    function index_get(){
        $data = $this->input->get(['kode_kartu']);
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('kode_kartu','kode_kartu','required|max_length[100]');
        $this->form_validation->set_error_delimiters('', ' ');
        if($this->form_validation->run()){
            $kartu = $this->kum->view()->set_attr('print',TRUE)->get($data['kode_kartu']);
            if($kartu){
                $this->response([
                    'status' => true,
                    'data' => $kartu
                ], REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'message' => ch_lang_line('result_not_found',FALSE,['name'=>'Kartu Ujian'])
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response([
                'status' => false,
                'message' => validation_errors(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    //require mhs_nim, jenis_kartu, semester
    function mahasiswa_get(){
        $data = $this->input->get(['mhs_nim','jenis_kartu','semester']);
	    $this->form_validation->set_data($data);

        $this->form_validation->set_rules('mhs_nim','mhs_nim','required|max_length[20]');
	    $this->form_validation->set_rules('jenis_kartu','jenis_kartu','required|in_list[uts,uas]');
	    $this->form_validation->set_rules('semester','semester','required|numeric|less_than_equal_to[14]|greater_than_equal_to[1]');

        $this->form_validation->set_error_delimiters('', ' ');
        if($this->form_validation->run()){
		    $kartu = $this->kum->view()->set_attr('print',TRUE)->get_by($data);
		    if($kartu){
                $this->response([
                    'status' => true,
			        'data' => $kartu
                ], REST_Controller::HTTP_OK);
		    }else{
                $this->response([
			        'status' => false,
			        'message' => ch_lang_line('result_not_found',FALSE,['name'=>'Kartu Ujian'])
                ], REST_Controller::HTTP_BAD_REQUEST);
		    }
            }else{
		    $this->response([
                'status' => false,
                'message' => validation_errors(),
		    ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    //
}
