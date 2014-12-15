<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Propertygeolocation_model extends CI_Model
{
	//topic
	public function create($property,$lat,$long)
	{
		$data  = array(
			'property' => $property,
			'lat' => $lat,
			'long' => $long
		);
		$query=$this->db->insert( 'propertygeolocation', $data );
		
		return  1;
	}
	function viewpropertygeolocationbyproperty($id)
	{
		$query="SELECT `propertygeolocation`.`id`,`propertygeolocation`.`property`, `propertygeolocation`.`lat`,`propertygeolocation`.`long`, `property`.`name` AS `propertyname`
        FROM `propertygeolocation` LEFT OUTER JOIN `property` ON `property`.`id`=`propertygeolocation`.`property` WHERE `propertygeolocation`.`property`='$id'";
        $result=$this->db->query($query)->result();
        
        return $result;
        
//		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'propertygeolocation' )->row();
		return $query;
	}
    
	public function getpropertygeolocationbyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `propertygeolocation` WHERE `id`='$id'")->row();
		return $query;
	}
	
	public function edit( $id,$property,$lat,$long)
	{
		$data = array(
			'property' => $property,
			'lat' => $lat,
			'long' => $long
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'propertygeolocation', $data );
		
		return 1;
	}
	function deletepropertygeolocation($id)
	{
		$query=$this->db->query("DELETE FROM `propertygeolocation` WHERE `id`='$id'");
		
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