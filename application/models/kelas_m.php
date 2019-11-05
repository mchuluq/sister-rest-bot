<?php defined('BASEPATH') || exit();

class Kelas_m extends CI_Model {

    public $table = 't_kelas';
    public $pk = 'kode_mk';

    public function __construct(){
        parent::__construct();
    }

    function get_jadwal($nim,$smt){
        return $this->db
        ->select('hari,jam_mulai,jam_selesai,ruang,nm_kelas,mk_nama,mk_sks,nama_dosen')->from($this->table)
        ->join('t_frs_items','t_frs_items.kode_kelas = t_kelas.kode_kelas')
        ->join('t_frs','t_frs.mhs_nim = t_frs_items.mhs_nim')
        ->where([
            't_frs.mhs_nim' => $nim,
            't_frs.semester' => $smt
        ])->get()->result_array();
    }
}