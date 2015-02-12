<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Propertyenquiry_model extends CI_Model
{
	//topic
	public function create($property,$message,$user,$contact,$email)
	{
		$data  = array(
			'property' => $property,
			'message' => $message,
			'contact' => $contact,
			'email' => $email,
			'user' => $user
		);
		$query=$this->db->insert( 'propertyenquiry', $data );
		
		return  1;
	}
	function viewpropertyenquirybyproperty($id)
	{
		$query="SELECT `propertyenquiry`.`id`,`propertyenquiry`.`property`, `propertyenquiry`.`message`, `propertyenquiry`.`contact`, `propertyenquiry`.`email`, `propertyenquiry`.`user`, `user`.`name` AS `username`, `property`.`name` AS `propertyname`
        FROM `propertyenquiry` LEFT OUTER JOIN `property` ON `property`.`id`=`propertyenquiry`.`property` LEFT OUTER JOIN `user` ON `user`.`id`=`propertyenquiry`.`user` WHERE `propertyenquiry`.`property`='$id'";
        $result=$this->db->query($query)->result();
        
        return $result;
        
//		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'propertyenquiry' )->row();
		return $query;
	}
    
	public function getpropertyenquirybyid($id)
	{
		$query=$this->db->query("SELECT `image` FROM `propertyenquiry` WHERE `id`='$id'")->row();
		return $query;
	}
	
	public function edit( $id,$property,$message,$user,$contact,$email)
	{
		$data = array(
			'property' => $property,
			'message' => $message,
			'contact' => $contact,
			'email' => $email,
			'user' => $user
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'propertyenquiry', $data );
		
		return 1;
	}
	function deletepropertyenquiry($id)
	{
		$query=$this->db->query("DELETE FROM `propertyenquiry` WHERE `id`='$id'");
		
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
    
	public function addfrontendenquiry($userid,$propertyid,$message,$email,$contact)
	{
		$data  = array(
			'property' => $propertyid,
			'message' => $message,
			'contact' => $contact,
			'email' => $email,
			'user' => $userid
		);
		$query=$this->db->insert( 'propertyenquiry', $data );
		if($query)
        {
		return  1;
        }
        else
        {
        return 0;
        }
	}
    
}
?>