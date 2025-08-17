<?php

class Madmin extends CI_Model{
	
	public function cek_login($u, $p){
		$q = $this->db->get_where('tbl_admin', array('userName'=>$u, 'password'=>$p));
		return $q;
	}

	public function get_all_data($tabel){
		$q=$this->db->get($tabel);
		return $q;
	}

	public function get_produk(){
		$this->db->select('*');
		$this->db->from('tbl_produk');
		$this->db->join('tbl_toko', 'tbl_toko.idToko = tbl_produk.idToko');
		$this->db->join('tbl_member', 'tbl_member.idKonsumen = tbl_toko.idKonsumen');
		$q = $this->db->get();
		return $q;
	}

	public function get_kota_penjual($idToko){
		$this->db->select('*');
		$this->db->from('tbl_toko');
		$this->db->join('tbl_member', 'tbl_member.idKonsumen = tbl_toko.idKonsumen');
		$this->db->where('tbl_toko.idToko', $idToko);
		$q = $this->db->get();
		return $q;
	}

	public function get_order_history($idKonsumen) {
        $this->db->select('*');
        $this->db->from('tbl_order');
        $this->db->where('idKonsumen', $idKonsumen);
        $this->db->order_by('tglOrder', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

	public function get_history_penjualan($idToko) {
        $this->db->select('*');
        $this->db->from('tbl_history_penjualan');
        $this->db->where('idToko', $idToko);
        $this->db->order_by('tanggalJual', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

	public function insert($tabel, $data){
		$this->db->insert($tabel, $data);
	}

	public function get_by_id($tabel, $id){
		return $this->db->get_where($tabel, $id);
	}
	public function getRatingById($idProduk) {
		return $this->db->where('idProduk', $idProduk)->get('tbl_produk_rating');
	}	

	public function update($tabel, $data, $pk, $id){
		$this->db->where($pk, $id);
		$this->db->update($tabel, $data);
	}

	// public function delete($tabel, $id, $val){
	// 	$this->db->delete($tabel, array($id => $val)); 
	// }

	public function delete($table, $column, $id){
        $this->db->where($column, $id);
        $this->db->delete($table);
    }
	
	public function cek_login_member($u, $p){
		$q = $this->db->get_where('tbl_member', array('username'=>$u, 'password'=>$p, 'statusAktif'=>'Y'));
		return $q;
	}

	//BATAS RATING PRODUK
	public function save_rating($data) {
        $this->db->insert('tbl_produk_rating', $data);
    }

	public function save_sale($data) {
        $this->db->insert('tbl_history_penjualan', $data);
    }

	public function update_resi($idHistory, $resi) {
        $this->db->where('idHistory', $idHistory);
        $this->db->update('tbl_history_penjualan', array('resi' => $resi));
    }

    public function get_history_by_resi($resi) {
        $this->db->where('resi', $resi);
        return $this->db->get('tbl_history_penjualan')->row();
    }
}
