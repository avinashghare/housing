<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Amenity_model extends CI_Model
{
	public function create($name,$image)
	{
		$data  = array(
			'name' => $name,
			'image' => $image
		);
		$query=$this->db->insert( 'amenity', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewamenity()
	{
		$query="SELECT `id`, `name` FROM `amenity`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'amenity' )->row();
		return $query;
	}
	
	public function edit($id,$name,$image)
	{
		$data  = array(
			'name' => $name,
			'image' => $image
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'amenity', $data );
		return 1;
	}
	function deleteamenity($id)
	{
		$query=$this->db->query("DELETE FROM `amenity` WHERE `id`='$id'");
	}
    
	public function getamenityimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `amenity` WHERE `id`='$id'")->row();
		return $query;
	}
    
    public function getamenitydropdown()
	{
		$query=$this->db->query("SELECT * FROM `amenity`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    public function getagedropdown()
	{
		$query=$this->db->query("SELECT * FROM `ageofproperty`  ORDER BY `id` ASC")->result();
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