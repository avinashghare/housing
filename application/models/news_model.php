<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class news_model extends CI_Model
{
	public function create($name,$text,$date,$image)
	{
		$data  = array(
			'name' => $name,
			'text' => $text,
			'date' => $date,
			'image' => $image
		);
		$query=$this->db->insert( 'news', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewnews()
	{
		$query="SELECT `id`, `name`,`contact`,`email`,`address` FROM `news`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'news' )->row();
		return $query;
	}
	
	public function getnewsbyid( $id )
	{
		$query="SELECT `id`, `name`,`contact`,`email`,`address` FROM `news` WHERE `id`='$id'";
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
		$query=$this->db->update( 'news', $data );
		return 1;
	}
	function deletenews($id)
	{
		$query=$this->db->query("DELETE FROM `news` WHERE `id`='$id'");
	}
    
	public function getnewsimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `news` WHERE `id`='$id'")->row();
		return $query;
	}
    
    public function getnewsdropdown()
	{
		$query=$this->db->query("SELECT * FROM `news`  ORDER BY `id` ASC")->result();
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