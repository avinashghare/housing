<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Propertytype_model extends CI_Model
{
	public function create($name)
	{
		$data  = array(
			'name' => $name
		);
		$query=$this->db->insert( 'propertytype', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewpropertytype()
	{
		$query="SELECT `id`, `name` FROM `propertytype`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'propertytype' )->row();
		return $query;
	}
	
	public function edit($id,$name)
	{
		$data  = array(
			'name' => $name
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'propertytype', $data );
		return 1;
	}
	function deletepropertytype($id)
	{
		$query=$this->db->query("DELETE FROM `propertytype` WHERE `id`='$id'");
	}
    
    public function getpropertytypedropdown()
	{
		$query=$this->db->query("SELECT * FROM `propertytype`  ORDER BY `id` ASC")->result();
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