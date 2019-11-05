<?php defined('BASEPATH') || exit();

class Kalender_m extends CI_Model {

    public $table = 't_kalender';
    public $pk = 'id';

    public function __construct(){
        parent::__construct();
    }

    function get_event($id_smt=null){
        return $this->db->select('nama,tgl_mulai,tgl_akhir')->from($this->table)->where('id_smt',$id_smt)->get()->result_array();
    }



}