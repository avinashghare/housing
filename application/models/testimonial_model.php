<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class testimonial_model extends CI_Model
{
	public function create($user,$testimonial)
	{
		$data  = array(
			'user' => $user,
			'testimonial' => $testimonial
		);
		$query=$this->db->insert( 'testimonial', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewtestimonial()
	{
		$query="SELECT `id`, `name` FROM `testimonial`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'testimonial' )->row();
		return $query;
	}
	
	public function edit($id,$user,$testimonial)
	{
		$data  = array(
			'user' => $user,
			'testimonial' => $testimonial
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'testimonial', $data );
		return 1;
	}
	function deletetestimonial($id)
	{
		$query=$this->db->query("DELETE FROM `testimonial` WHERE `id`='$id'");
	}
    
	public function gettestimonialimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `testimonial` WHERE `id`='$id'")->row();
		return $query;
	}
    
    public function gettestimonialdropdown()
	{
		$query=$this->db->query("SELECT * FROM `testimonial`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
	public function gettestimonial()
	{
		$query=$this->db->query("SELECT `testimonial`.`id`, `testimonial`.`user`, `testimonial`.`testimonial`, `testimonial`.`timestamp` ,`user`.`name` AS `username`
FROM `testimonial` LEFT OUTER JOIN `user` ON `testimonial`.`user`=`user`.`id`
ORDER BY `testimonial`.`id` DESC LIMIT 0,10")->result();
		return $query;
	}
    
    
}
	
?>