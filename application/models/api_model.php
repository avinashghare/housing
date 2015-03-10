<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class api_model extends CI_Model
{
	
	public function gethomepageproperties($category,$iscommercial,$residential,$area)
	{
        $query="SELECT  `property`.`id`  AS `id` ,  `property`.`name`  AS `name` ,  `property`.`email`  AS `email` ,  `category`.`name`  AS `categoryname` ,  `builder`.`name`  AS `buildername` ,  `property`.`price`  AS `price` ,  `property`.`bhk`  AS `bhk` ,  `property`.`address1`  AS `address1` ,  `property`.`address2`  AS `address2` ,  `property`.`city`  AS `city` ,`property`.`isnew`  AS `isnew` ,  `property`.`builduparea`  AS `builduparea` ,  `property`.`carpetarea`  AS `carpetarea`,`property`.`floorplan2d`  AS `floorplan2d`   
FROM `property` 
LEFT OUTER JOIN `category` ON `category`.`id`=`property`.`category` 
LEFT OUTER JOIN `builder` ON `builder`.`id`=`property`.`builder`
WHERE 1";
        if($category=="")
        {
        }
        else
        {
        $query.=" AND `property`.`category`='$category'";
        }
        
        if($iscommercial=="")
        {
        }
        else
        {
        $query.=" AND `property`.`iscommercial`='$iscommercial'";
        }
        
        if($residential=="")
        {
        }
        else
        {
        $query.=" AND `property`.`residential`='$residential'";
        }
        
        if($area=="")
        {
        }
        else
        {
        $query.=" AND `property`.`address1` LIKE '%$area%' OR `property`.`address2` LIKE '%$area%' OR `property`.`city` LIKE '%$area%' OR `property`.`pincode` LIKE '%$area%' ";
        }
        
        $query.=" ORDER BY  `property`.`id` DESC";
        
        $fullquery=$this->db->query($query)->result();
        
		return $fullquery;
	}
    
	public function getpropertiesbycategory($category)
	{
		$query=$this->db->query("SELECT  `property`.`id`  AS `id` ,  `property`.`name`  AS `name` ,  `property`.`email`  AS `email` ,  `category`.`name`  AS `categoryname` ,  `builder`.`name`  AS `buildername` ,  `property`.`price`  AS `price` ,  `property`.`bhk`  AS `bhk` ,  `property`.`address1`  AS `address1` ,  `property`.`address2`  AS `address2` ,  `property`.`city`  AS `city` ,`property`.`isnew`  AS `isnew` ,  `property`.`builduparea`  AS `builduparea` ,  `property`.`carpetarea`  AS `carpetarea`,`property`.`floorplan2d`  AS `floorplan2d`   
FROM `property` 
LEFT OUTER JOIN `category` ON `category`.`id`=`property`.`category` 
LEFT OUTER JOIN `builder` ON `builder`.`id`=`property`.`builder`   
WHERE `property`.`category`='$category'   
ORDER BY  `id` DESC
LIMIT 0,10")->result();
		return $query;
	}
    
    public function getpropertybyid($id)
    {
    
		$query['property']=$this->db->query("SELECT * FROM `property` WHERE `id`='$id'")->row();

        $query['amenity']=$this->db->query("SELECT `propertyamenity`. `property`, `propertyamenity`.`amenity`,`amenity`.`name` AS `amenityname`,`property`.`name` AS `propertyname` 
FROM `propertyamenity` 
LEFT OUTER JOIN `amenity` ON `amenity`.`id`=`propertyamenity`.`amenity` 
LEFT OUTER JOIN `property` ON `property`.`id`=`propertyamenity`.`property` 
WHERE `propertyamenity`.`property`='$id'")->result();

$query['societyfacility']=$this->db->query("SELECT `propertysocietyfacility`. `property`,`propertysocietyfacility`. `societyfacility`,`societyfacility`.`name` AS `societyfacilityname`
FROM `propertysocietyfacility`
LEFT OUTER JOIN `societyfacility` ON `societyfacility`.`id`=`propertysocietyfacility`.`societyfacility` 
LEFT OUTER JOIN `property` ON `property`.`id`=`propertysocietyfacility`.`property` 
WHERE `propertysocietyfacility`.`property`='$id'")->result();
        
$query['images']=$this->db->query("SELECT `image`
FROM `propertyimage`
WHERE `property`='$id'")->result();
        
$query['geolocation']=$this->db->query("SELECT `propertygeolocation`. `property`,`propertygeolocation`. `lat`, `propertygeolocation`.`long` 
FROM `propertygeolocation` 
LEFT OUTER JOIN `property` ON `property`.`id`=`propertygeolocation`.`property`
WHERE `property`='$id'")->result();
   
		return $query;
    }
     
	public function getnewproperty()
	{
		$query=$this->db->query("SELECT  `property`.`id`  AS `id` ,  `property`.`name`  AS `name` ,  `property`.`email`  AS `email` ,  `category`.`name`  AS `categoryname` ,  `builder`.`name`  AS `buildername` ,  `property`.`price`  AS `price` ,  `property`.`bhk`  AS `bhk` ,  `property`.`address1`  AS `address1` ,  `property`.`address2`  AS `address2` ,  `property`.`city`  AS `city` ,`property`.`isnew`  AS `isnew` ,  `property`.`builduparea`  AS `builduparea` ,  `property`.`carpetarea`  AS `carpetarea`,`property`.`floorplan2d`  AS `floorplan2d`   
FROM `property` 
LEFT OUTER JOIN `category` ON `category`.`id`=`property`.`category` 
LEFT OUTER JOIN `builder` ON `builder`.`id`=`property`.`builder`   
WHERE `property`.`isnew`=1     
ORDER BY  `id` DESC
LIMIT 0,10")->result();
		return $query;
	}  
    
}
?>