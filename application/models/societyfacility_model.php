<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Societyfacility_model extends CI_Model
{
	public function create($name)
	{
		$data  = array(
			'name' => $name
		);
		$query=$this->db->insert( 'societyfacility', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewsocietyfacility()
	{
		$query="SELECT `id`, `name` FROM `societyfacility`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'societyfacility' )->row();
		return $query;
	}
	
	public function edit($id,$name)
	{
		$data  = array(
			'name' => $name
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'societyfacility', $data );
		return 1;
	}
	function deletesocietyfacility($id)
	{
		$query=$this->db->query("DELETE FROM `societyfacility` WHERE `id`='$id'");
	}
    
    public function getsocietyfacilitydropdown()
	{
		$query=$this->db->query("SELECT * FROM `societyfacility`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
}
	
?>