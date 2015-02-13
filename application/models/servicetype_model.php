<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Servicetype_model extends CI_Model
{
	public function create($name)
	{
		$data  = array(
			'name' => $name
		);
		$query=$this->db->insert( 'servicetype', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewservicetype()
	{
		$query="SELECT `id`, `name` FROM `servicetype`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'servicetype' )->row();
		return $query;
	}
	
	public function edit($id,$name)
	{
		$data  = array(
			'name' => $name
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'servicetype', $data );
		return 1;
	}
	function deleteservicetype($id)
	{
		$query=$this->db->query("DELETE FROM `servicetype` WHERE `id`='$id'");
	}
    
	public function getservicetypeimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `servicetype` WHERE `id`='$id'")->row();
		return $query;
	}
    
    public function getservicetypedropdown()
	{
		$query=$this->db->query("SELECT * FROM `servicetype`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    public function getdaydropdown()
	{
		$query=$this->db->query("SELECT * FROM `day`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
     
	public function getallservicetype()
	{
		$query=$this->db->query("SELECT * FROM `servicetype`")->result();
		return $query;
	}
    
}
	
?>