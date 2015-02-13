<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Builder_model extends CI_Model
{
	public function create($name,$email,$contact,$address)
	{
		$data  = array(
			'name' => $name,
			'email' => $email,
			'contact' => $contact,
			'address' => $address
		);
		$query=$this->db->insert( 'builder', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewbuilder()
	{
		$query="SELECT `id`, `name`,`contact`,`email`,`address` FROM `builder`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'builder' )->row();
		return $query;
	}
	
	public function getbuilderbyid( $id )
	{
		$query="SELECT `id`, `name`,`contact`,`email`,`address` FROM `builder` WHERE `id`='$id'";
		$query=$this->db->query($query)->row();
		return $query;
	}
	
	public function edit($id,$name,$email,$contact,$address)
	{
		$data  = array(
			'name' => $name,
			'email' => $email,
			'contact' => $contact,
			'address' => $address
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'builder', $data );
		return 1;
	}
	function deletebuilder($id)
	{
		$query=$this->db->query("DELETE FROM `builder` WHERE `id`='$id'");
	}
    
	public function getbuilderimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `builder` WHERE `id`='$id'")->row();
		return $query;
	}
    
    public function getbuilderdropdown()
	{
		$query=$this->db->query("SELECT * FROM `builder`  ORDER BY `id` ASC")->result();
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