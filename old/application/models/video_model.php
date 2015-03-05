<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class video_model extends CI_Model
{
	public function create($title,$video)
	{
		$data  = array(
			'title' => $title,
			'video' => $video
		);
		$query=$this->db->insert( 'video', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewvideo()
	{
		$query="SELECT `id`, `name` FROM `video`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'video' )->row();
		return $query;
	}
	
	public function edit($id,$title,$video)
	{
		$data  = array(
			'title' => $title,
			'video' => $video
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'video', $data );
		return 1;
	}
	function deletevideo($id)
	{
		$query=$this->db->query("DELETE FROM `video` WHERE `id`='$id'");
	}
    
	public function getvideoimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `video` WHERE `id`='$id'")->row();
		return $query;
	}
    
    public function getvideodropdown()
	{
		$query=$this->db->query("SELECT * FROM `video`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
     
	public function getvideo()
	{
		$query=$this->db->query("SELECT * FROM `video` ORDER BY `id` DESC LIMIT 0,10")->result();
		return $query;
	}
}
	
?>