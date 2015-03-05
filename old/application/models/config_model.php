<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class config_model extends CI_Model
{
	public function create($name,$text)
	{
		$data  = array(
			'name' => $name,
			'text' => $text
		);
		$query=$this->db->insert( 'config', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
	function viewconfig()
	{
		$query="SELECT `id`, `name` FROM `config`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'config' )->row();
		return $query;
	}
	
	public function edit($id,$name,$text)
	{
		$data  = array(
			'name' => $name,
			'text' => $text
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'config', $data );
		return 1;
	}
	function deleteconfig($id)
	{
		$query=$this->db->query("DELETE FROM `config` WHERE `id`='$id'");
	}
    
	public function getconfigimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `config` WHERE `id`='$id'")->row();
		return $query;
	}
    
    public function getconfigdropdown()
	{
		$query=$this->db->query("SELECT * FROM `config`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
     
	public function getsearchbackground()
	{
		$query=$this->db->query("SELECT `config`.`id`, `config`.`name`, `config`.`text`
FROM `config`")->row();
		return $query;
	}
    
}
	
?>