<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class blog_model extends CI_Model
{
	public function create($name,$text,$date,$image)
	{
		$data  = array(
			'name' => $name,
			'text' => $text,
			'date' => $date,
			'image' => $image
		);
		$query=$this->db->insert( 'blog', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewblog()
	{
		$query="SELECT `id`, `name`,`contact`,`email`,`address` FROM `blog`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'blog' )->row();
		return $query;
	}
	
	public function getblogbyid( $id )
	{
		$query="SELECT `id`, `name`,`contact`,`email`,`address` FROM `blog` WHERE `id`='$id'";
		$query=$this->db->query($query)->row();
		return $query;
	}
	
	public function edit($id,$name,$text,$date,$image)
	{
		$data  = array(
			'name' => $name,
			'text' => $text,
			'date' => $date,
			'image' => $image
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'blog', $data );
		return 1;
	}
	function deleteblog($id)
	{
		$query=$this->db->query("DELETE FROM `blog` WHERE `id`='$id'");
	}
    
	public function getblogimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `blog` WHERE `id`='$id'")->row();
		return $query;
	}
    
    public function getblogdropdown()
	{
		$query=$this->db->query("SELECT * FROM `blog`  ORDER BY `id` ASC")->result();
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