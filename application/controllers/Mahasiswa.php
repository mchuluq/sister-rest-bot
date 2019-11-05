<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Mahasiswa extends MY_REST_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('mahasiswa/mahasiswa_model','mhs_m');
        $this->load->library('form_validation');
    }

    function index_get($nim=null){
        $data = ($nim) ? array('mhs_nim'=>$nim) : $this->input->get(['mhs_nim']);
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('mhs_nim','mhs_nim','required|max_length[20]|min_length[8]');
        $this->form_validation->set_error_delimiters('', ' ');
        if($this->form_validation->run()){
            $mhs = $this->mhs_m->quick_info_mhs($data['mhs_nim']);
            if($mhs){
                $this->response($mhs, REST_Controller::HTTP_OK);
            }else{
                $this->response([
                    'status' => false,
                    'message' => ch_lang_line('result_not_found',FALSE,['name'=>'mahasiswa'])
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response([
                'status' => false,
                'message' => validation_errors(),
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    function prodi_get(){
        $prodi = ci_cache_method('ch_get_prodi',[TRUE,FALSE,TRUE],TWO_WEEKS);
        $data = array();
        foreach($prodi as $key=>$val){
            $data[] = array('name'=>$key,'label'=>$val);
        }
        $data[] = array('name'=>'PRA MAHASISWA','label'=>'PRA MAHASISWA');
        $this->response($data,REST_Controller::HTTP_OK);
    }
}
