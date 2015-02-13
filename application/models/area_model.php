<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Area_model extends CI_Model
{
	public function create($name)
	{
		$data  = array(
			'name' => $name
		);
		$query=$this->db->insert( 'area', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewarea()
	{
		$query="SELECT `id`, `name` FROM `area`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'area' )->row();
		return $query;
	}
	
	public function edit($id,$name)
	{
		$data  = array(
			'name' => $name
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'area', $data );
		return 1;
	}
	function deletearea($id)
	{
		$query=$this->db->query("DELETE FROM `area` WHERE `id`='$id'");
	}
    
	public function getareaimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `area` WHERE `id`='$id'")->row();
		return $query;
	}
    
    public function getareadropdown()
	{
		$query=$this->db->query("SELECT * FROM `area`  ORDER BY `id` ASC")->result();
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
    
	public function getallarea()
	{
		$query=$this->db->query("SELECT * FROM `area`")->result();
		return $query;
	}
	public function getallweekday()
	{
		$query=$this->db->query("SELECT * FROM `day`")->result();
		return $query;
	}
}
	
?>