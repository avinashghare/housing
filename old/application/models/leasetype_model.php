<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Leasetype_model extends CI_Model
{
	public function create($name)
	{
		$data  = array(
			'name' => $name
		);
		$query=$this->db->insert( 'leasetype', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewleasetype()
	{
		$query="SELECT `id`, `name` FROM `leasetype`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'leasetype' )->row();
		return $query;
	}
	
	public function edit($id,$name)
	{
		$data  = array(
			'name' => $name
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'leasetype', $data );
		return 1;
	}
	function deleteleasetype($id)
	{
		$query=$this->db->query("DELETE FROM `leasetype` WHERE `id`='$id'");
	}
    
    public function getleasetypedropdown()
	{
		$query=$this->db->query("SELECT * FROM `leasetype`  ORDER BY `id` ASC")->result();
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