<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
}

class Member_Controller extends MY_Controller{

    protected $limited_access = TRUE;

    function __construct(){
        parent::__construct();
        $this->load->library('uac');
        $this->template->load_asset(['pace','framework','bootstrap','jquery-ui','app']);

        if($this->limited_access === TRUE){
            $this->_check_access();
        }elseif(is_array($this->limited_access)){
            $method = $this->router->method;
            $access_list = $this->limited_access;
            if(in_array($method,$access_list)){
                $this->_check_access();
            }
        }
    }

    private function _check_access(){
        if(!$this->_is_login()){
            $param = array("request"=>urlencode(ch_current_url()));
            $this->session->set_flashdata('sign_in','Anda harus login terlebih dahulu');
            redirect(ch_create_url('sign',$param));
        }elseif(!$this->_is_allowed()){
            redirect(site_url('error/error403'));
        }
    }

    private function _is_login(){
        return $this->uac->is_login();
    }

    private function _is_allowed(){
        return $this->uac->check_permission();
    }

}

class Ajax_controller extends MY_Controller {
    var $offset;
    var $limit;
    var $search;
    var $sort_by;
    var $sort_type;
    var $query;
    var $trash;

    var $akses_prodi;
    var $akses_biro;
    var $akses_fakultas;

    var $cache_time = CACHE_EXPIRE;
    var $long_cache_time = 2592000;
    var $cache_stat = TRUE;

    var $max_limit = 100;

    // TODO : class constructor for class API :: set the property of datagrid - offset, limit, search, sort
    function __construct(){
        parent::__construct();

        $this->offset = ($this->input->get('offset',TRUE)!=NULL) ? $this->input->get('offset',TRUE) : 0;
        $this->limit = ($this->input->get('limit',TRUE)!=NULL && $this->input->get('limit',TRUE) <= $this->max_limit) ? $this->input->get('limit',TRUE) : 25;
        $this->search = $this->input->get('search',TRUE);
        $this->sort_by = $this->input->get('sort',TRUE);
        $this->sort_type = $this->input->get('order',TRUE);
        $this->query = $this->input->get('query',TRUE);
        $this->trash = $this->input->get('trash',TRUE);

        $user_group = $this->session->userdata('user_group');
        $sess_akses = $user_group['user_access_data'];
        $sess_akses = (!$sess_akses) ? array() : $sess_akses;

        $this->akses_prodi = element('prodi',$sess_akses);
        $this->akses_biro = element('biro',$sess_akses);
        $this->akses_fakultas = element('fakultas',$sess_akses);

        $this->cache_stat = ($this->input->get('cache') == 'NO') ? FALSE : TRUE;

        header('Content-Type: application/json');
    }
}
