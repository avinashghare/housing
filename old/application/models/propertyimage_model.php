<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Propertyimage_model extends CI_Model
{
	//topic
	public function create($property,$image)
	{
		$data  = array(
			'property' => $property,
			'image' => $image
		);
		$query=$this->db->insert( 'propertyimage', $data );
		
		return  1;
	}
	function viewpropertyimagebyproperty($id)
	{
		$query="SELECT `propertyimage`.`id`,`propertyimage`.`property`, `propertyimage`.`image`, `property`.`name` AS `propertyname`
        FROM `propertyimage` LEFT OUTER JOIN `property` ON `property`.`id`=`propertyimage`.`property` WHERE `propertyimage`.`property`='$id'";
        $result=$this->db->query($query)->result();
        
        return $result;
        
//		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'propertyimage' )->row();
		return $query;
	}
    
	public function getpropertyimagebyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `propertyimage` WHERE `id`='$id'")->row();
		return $query;
	}
	
	public function edit( $id,$property,$image)
	{
		$data = array(
			'property' => $property,
			'image' => $image
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'propertyimage', $data );
		
		return 1;
	}
	function deletepropertyimage($id)
	{
		$query=$this->db->query("DELETE FROM `propertyimage` WHERE `id`='$id'");
		
	}
    
     public function getpropertydropdown()
	{
		$query=$this->db->query("SELECT * FROM `property`  ORDER BY `id` ASC")->result();
		$return=array();
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    
}
?>