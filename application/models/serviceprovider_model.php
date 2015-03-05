<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Serviceprovider_model extends CI_Model
{
	public function create($name,$contact,$area,$rate,$servicetype,$day)
	{
		$data  = array(
			'name' => $name,
			'contact' => $contact,
			'area' => $area,
			'rate' => $rate,
			'servicetype' => $servicetype
		);
		$query=$this->db->insert( 'serviceprovider', $data );
		$serviceproviderid=$this->db->insert_id();
        foreach($day AS $key=>$value)
        {
            $this->serviceprovider_model->createserviceproviderday($value,$serviceproviderid);
        }
		if(!$query)
			return  0;
		else
			return  1;
	}
    
    public function createserviceproviderday($value,$serviceproviderid)
	{
		$data  = array(
			'day' => $value,
			'serviceprovider' => $serviceproviderid
		);
		$query=$this->db->insert( 'serviceproviderday', $data );
		return  1;
	}
    
	function viewserviceprovider()
	{
		$query="SELECT `serviceprovider`.`id`, `serviceprovider`.`user`, `serviceprovider`.`name`, `serviceprovider`.`email`, `serviceprovider`.`contact`, `serviceprovider`.`line1`, `serviceprovider`.`line2`, `serviceprovider`.`line3`, `serviceprovider`.`city`,`serviceprovider`. `state`, `serviceprovider`.`pincode`, `serviceprovider`.`country`, `serviceprovider`.`landmark`, `serviceprovider`.`vat`, `serviceprovider`.`tin`, `serviceprovider`.`pan`, `serviceprovider`.`logo`,`serviceprovider`. `color1`, `serviceprovider`.`color2`, `serviceprovider`.`theme` ,`user`.`firstname`,`user`.`lastname`,`theme`.`name` as `themename`
        FROM `serviceprovider`
        LEFT OUTER JOIN `theme` ON `theme`.`id`=`serviceprovider`.`theme`
        LEFT OUTER JOIN `user` ON `user`.`id`=`serviceprovider`.`user`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'serviceprovider' )->row();
		return $query;
	}
	
	public function edit($id,$name,$contact,$area,$rate,$servicetype,$day)
	{
		$data  = array(
			'name' => $name,
			'contact' => $contact,
			'area' => $area,
			'rate' => $rate,
			'servicetype' => $servicetype
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'serviceprovider', $data );
        $querydelete=$this->db->query("DELETE FROM `serviceproviderday` WHERE `serviceprovider`='$id'");
        foreach($day AS $key=>$value)
        {
            $this->serviceprovider_model->createserviceproviderday($value,$id);
        }
		return 1;
	}
	function deleteserviceprovider($id)
	{
		$query=$this->db->query("DELETE FROM `serviceprovider` WHERE `id`='$id'");
	}
    
    public function getserviceproviderdropdown()
	{
		$query=$this->db->query("SELECT * FROM `serviceprovider`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
	public function getserviceproviderimagebyid($id)
	{
		$query=$this->db->query("SELECT `floorplan2d` FROM `serviceprovider` WHERE `id`='$id'")->row();
		return $query;
	}
    
    //for dropdown
   
     public function getdaybyserviceprovider($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`serviceprovider`,`day` FROM `serviceproviderday`  WHERE `serviceprovider`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->day;
            }
        }
         return $return;
         
		
	}
    
     
	public function addserviceenquiry($serviceproviderid,$name,$subject,$query)
	{
		$data  = array(
			'serviceprovider' => $serviceproviderid,
			'name' => $name,
			'subject' => $subject,
			'query' => $query
		);
		$query=$this->db->insert( 'serviceproviderenquiry', $data );
		if($query)
        {
            return  1;
        }
        else
        {
            return 0;
        }
	}
    
    
     public function getamenitybyserviceprovider($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`serviceprovider`,`amenity` FROM `serviceprovideramenity`  WHERE `serviceprovider`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->amenity;
            }
        }
         return $return;
         
		
	}
    public function getserviceproviderbyid($id)
    {
    
		$query['serviceprovider']=$this->db->query("SELECT * FROM `serviceprovider` WHERE `id`='$id'")->row();

        $query['amenity']=$this->db->query("SELECT `serviceprovideramenity`. `serviceprovider`, `serviceprovideramenity`.`amenity`,`amenity`.`name` AS `amenityname`,`serviceprovider`.`name` AS `serviceprovidername` 
FROM `serviceprovideramenity` 
LEFT OUTER JOIN `amenity` ON `amenity`.`id`=`serviceprovideramenity`.`amenity` 
LEFT OUTER JOIN `serviceprovider` ON `serviceprovider`.`id`=`serviceprovideramenity`.`serviceprovider` 
WHERE `serviceprovideramenity`.`serviceprovider`='$id'")->result();

$query['day']=$this->db->query("SELECT `serviceproviderday`. `serviceprovider`,`serviceproviderday`. `day`,`day`.`name` AS `dayname`
FROM `serviceproviderday`
LEFT OUTER JOIN `day` ON `day`.`id`=`serviceproviderday`.`day` 
LEFT OUTER JOIN `serviceprovider` ON `serviceprovider`.`id`=`serviceproviderday`.`serviceprovider` 
WHERE `serviceproviderday`.`serviceprovider`='$id'")->result();
        
$query['images']=$this->db->query("SELECT `image`
FROM `serviceproviderimage`
WHERE `serviceprovider`='$id'")->result();
        
$query['geolocation']=$this->db->query("SELECT `serviceprovidergeolocation`. `serviceprovider`,`serviceprovidergeolocation`. `lat`, `serviceprovidergeolocation`.`long` 
FROM `serviceprovidergeolocation` 
LEFT OUTER JOIN `serviceprovider` ON `serviceprovider`.`id`=`serviceprovidergeolocation`.`serviceprovider`
WHERE `serviceprovider`='$id'")->result();
   
		return $query;
    }
     
	public function getnewserviceprovider()
	{
		$query=$this->db->query("SELECT  `serviceprovider`.`id`  AS `id` ,  `serviceprovider`.`name`  AS `name` ,  `serviceprovider`.`email`  AS `email` ,  `category`.`name`  AS `categoryname` ,  `builder`.`name`  AS `buildername` ,  `serviceprovider`.`price`  AS `price` ,  `serviceprovider`.`bhk`  AS `bhk` ,  `serviceprovider`.`address1`  AS `address1` ,  `serviceprovider`.`address2`  AS `address2` ,  `serviceprovider`.`city`  AS `city` ,`serviceprovider`.`isnew`  AS `isnew` ,  `serviceprovider`.`builduparea`  AS `builduparea` ,  `serviceprovider`.`carpetarea`  AS `carpetarea`,`serviceprovider`.`floorplan2d`  AS `floorplan2d`   
FROM `serviceprovider` 
LEFT OUTER JOIN `category` ON `category`.`id`=`serviceprovider`.`category` 
LEFT OUTER JOIN `builder` ON `builder`.`id`=`serviceprovider`.`builder`   
WHERE `serviceprovider`.`isnew`=1     
ORDER BY  `id` DESC
LIMIT 0,10")->result();
		return $query;
	}
}
?>