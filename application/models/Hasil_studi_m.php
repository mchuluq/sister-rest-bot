<?php defined('BASEPATH') || exit();

class Hasil_studi_m extends CI_Model {

    public $table = 't_frs_items';
    public $pk = 'id';

    public function __construct(){
        parent::__construct();
    }

    function get_nilai($nim,$smt){
        return $this->db
        ->select('mk_nama,nilai_huruf')->from($this->table)
        ->join('t_kelas','t_kelas.kode_kelas = t_frs_items.kode_kelas')
        ->join('t_frs','t_frs.mhs_nim = t_frs_items.mhs_nim')
        ->where([
            't_frs.mhs_nim' => $nim,
            't_frs.semester' => $smt
        ])->get()->result_array();
    }



}