<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MyModel extends CI_Model {

	public function insert($table,$data)
	{
		return $this->db->insert($table,$data);
	}

	public function replace($table,$data)
	{
		return $this->db->replace($table,$data);
	}

	public function update($table,$data,$where)
	{
		return $this->db->update($table,$data,$where);
	}

	/**
	*	function general delete 
	*	@param $table table name
	*	@param $where record filter condition
	*	@param $softDelete soft delete (visible=0) / hard delete (delete from table). (default : true)
	*
	*/
	public function delete($table,$where,$softDelete=true)
	{
		if ($softDelete) {
			return $this->db->update($table,array('visible'=>0),$where);
		} else {
			return $this->db->delete($table,$where);			
		}
	}

	public function all($table) 
	{
		return $this->db->get($table);
	}

	public function get_field($table,$field) 
	{
		$this->db->select($field);
		return $this->db->get($table);
	}

	public function get_field_distinct($table,$field) 
	{
		$this->db->distinct();
		$this->db->select($field);
		return $this->db->get($table);
	}

	public function get_where($table,$data) 
	{
		return $this->db->get_where($table, $data);
	}

	public function get_where_field($table,$field,$data,$order='',$direction='asc') 
	{
		$this->db->select($field);
		if ($order != '') $this->db->order_by($order,$direction);
		return $this->db->get_where($table, $data);
	}

	public function get_where_distinct($table,$kolom) 
	{
		$this->db->distinct();
		$this->db->select($kolom);
		
		return $this->db->get($table);
	}

	public function get_where_like($table,$field,$data) 
	{
		$this->db->like($field, $data);
		return $this->db->get($table);
	}

	public function get_last_record($tabel, $kolom) {
		$sql = "select $kolom from $tabel order by $kolom desc limit 1";

		return $this->db->query($sql)->row();
	}
	
	function cek_data($table,$data){
		$query= $this->db->get_where($table,$data);
		if($query->num_rows() > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function query($sql){
		return $this->db->query($sql);
	}

	function getKesediaanAjar($id_hari, $id_sesi){
		$sql = "SELECT id_ajar
				FROM   ajar 
				       INNER JOIN dosen ON dosen.id_dosen = ajar.id_dosen
				       INNER JOIN kesediaan ON kesediaan.id_dosen = dosen.id_dosen
				WHERE 
				       id_hari = '". $id_hari ."' AND id_sesi = '". $id_sesi ."'";

		return $this->db->query($sql);
	}
}