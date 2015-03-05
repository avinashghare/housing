<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Property_model extends CI_Model
{
	public function create($name,$email,$category,$builder,$listingowner,$price,$leasetype,$listedby,$furnishing,$propertytype,$bathroom,$negotiable,$bhk,$address1,$address2,$locality,$city,$pincode,$builduparea,$carpetarea,$facing,$powerbackup,$verified,$status,$reportmessage,$commitescore,$localityscore,$societyscore,$possesion,$aerialview,$insights,$pricetrends,$yearofestablishment,$totalproject,$associatemembership,$interior,$threedfloorplan,$iscommercial,$image,$securitydeposite,$societyfacility,$amenity,$isnew,$age,$luxury,$residential,$kitchen,$developmentnego,$preferencialnego,$parkingnego,$maintainancenego,$clubhousenego,$floorrisenego,$othernego,$rentnego,$depositenego,$json)
	{
//        INSERT INTO `property`(`id`, `name`, `email`, `category`, `builder`, `listingowner`, `price`, `leasetype`, `listedby`, `furnishing`, `propertytype`, `timestamp`, `bathroom`, `negotiable`, `securitydeposite`, `bhk`, `address1`, `address2`, `locality`, `city`, `pincode`, `builduparea`, `carpetarea`, `facing`, `powerbackup`, `verified`, `status`, `reportmessage`, `commitescore`, `localityscore`, `societyscore`, `possesion`, `aerialview`, `insights`, `pricetrends`, `yearofestablishment`, `totalprojects`, `associatemembership`, `interior`, `3dfloorplan`, `2dfloorplan`, `iscommercial`)
		$data  = array(
			'name' => $name,
			'email' => $email,
            'category' => $category,
			'builder' => $builder,
			'listingowner' => $listingowner,
			'price' => $price,
			'leasetype' => $leasetype,
			'listedby' => $listedby,
			'furnishing' => $furnishing,
			'propertytype' => $propertytype,
			'bathroom' => $bathroom,
			'negotiable' => $negotiable,
			'securitydeposite' => $securitydeposite,
			'bhk' => $bhk,
			'address1' => $address1,
			'address2' => $address2,
			'locality' => $locality,
			'city' => $city,
			'pincode' => $pincode,
			'builduparea' => $builduparea,
			'carpetarea' => $carpetarea,
			'facing' => $facing,
			'powerbackup' => $powerbackup,
			'verified' => $verified,
			'status' => $status,
			'reportmessage' => $reportmessage,
			'commitescore' => $commitescore,
			'localityscore' => $localityscore,
			'societyscore' => $societyscore,
			'possesion' => $possesion,
			'aerialview' => $aerialview,
			'insights' => $insights,
			'isnew' => $isnew,
			'pricetrends' => $pricetrends,
			'yearofestablishment' => $yearofestablishment,
			'totalprojects' => $totalproject,
			'associatemembership' => $associatemembership,
			'interior' => $interior,
			'floorplan3d' => $threedfloorplan,
			'floorplan2d' => $image,
            'age' => $age,
            'luxury' => $luxury,
            'residential' => $residential,
            'kitchen' => $kitchen,
            'developmentnego' => $developmentnego,
            'preferencialnego' => $preferencialnego,
            'parkingnego' => $parkingnego,
            'maintainancenego' => $maintainancenego,
            'clubhousenego' => $clubhousenego,
            'floorrisenego' => $floorrisenego,
            'othernego' => $othernego,
            'rentnego' => $rentnego,
            'depositenego' => $depositenego,
            'json' => $json,
			'iscommercial' => $iscommercial
		);
		$query=$this->db->insert( 'property', $data );
		$propertyid=$this->db->insert_id();
        foreach($societyfacility AS $key=>$value)
        {
            $this->property_model->createpropertysocietyfacility($value,$propertyid);
        }
        foreach($amenity AS $key=>$value)
        {
            $this->property_model->createpropertyamenity($value,$propertyid);
        }
		
		if(!$query)
			return  0;
		else
			return  1;
	}
    
    public function createpropertysocietyfacility($value,$propertyid)
	{
		$data  = array(
			'societyfacility' => $value,
			'property' => $propertyid
		);
		$query=$this->db->insert( 'propertysocietyfacility', $data );
		return  1;
	}
    
    public function createpropertyamenity($value,$propertyid)
	{
		$data  = array(
			'amenity' => $value,
			'property' => $propertyid
		);
		$query=$this->db->insert( 'propertyamenity', $data );
		return  1;
	}
    
	function viewproperty()
	{
		$query="SELECT `property`.`id`, `property`.`user`, `property`.`name`, `property`.`email`, `property`.`contact`, `property`.`line1`, `property`.`line2`, `property`.`line3`, `property`.`city`,`property`. `state`, `property`.`pincode`, `property`.`country`, `property`.`landmark`, `property`.`vat`, `property`.`tin`, `property`.`pan`, `property`.`logo`,`property`. `color1`, `property`.`color2`, `property`.`theme` ,`user`.`firstname`,`user`.`lastname`,`theme`.`name` as `themename`
        FROM `property`
        LEFT OUTER JOIN `theme` ON `theme`.`id`=`property`.`theme`
        LEFT OUTER JOIN `user` ON `user`.`id`=`property`.`user`";
		$query=$this->db->query($query)->result();
		return $query;
	}
	
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query=$this->db->get( 'property' )->row();
		return $query;
	}
	
	public function edit($id,$name,$email,$category,$builder,$listingowner,$price,$leasetype,$listedby,$furnishing,$propertytype,$bathroom,$negotiable,$bhk,$address1,$address2,$locality,$city,$pincode,$builduparea,$carpetarea,$facing,$powerbackup,$verified,$status,$reportmessage,$commitescore,$localityscore,$societyscore,$possesion,$aerialview,$insights,$pricetrends,$yearofestablishment,$totalproject,$associatemembership,$interior,$threedfloorplan,$iscommercial,$image,$securitydeposite,$societyfacility,$amenity,$isnew,$age,$luxury,$residential,$kitchen,$developmentnego,$preferencialnego,$parkingnego,$maintainancenego,$clubhousenego,$floorrisenego,$othernego,$rentnego,$depositenego,$json)
	{
		$data  = array(
			'name' => $name,
			'email' => $email,
            'category' => $category,
			'builder' => $builder,
			'listingowner' => $listingowner,
			'price' => $price,
			'leasetype' => $leasetype,
			'listedby' => $listedby,
			'furnishing' => $furnishing,
			'propertytype' => $propertytype,
			'bathroom' => $bathroom,
			'negotiable' => $negotiable,
			'securitydeposite' => $securitydeposite,
			'bhk' => $bhk,
			'address1' => $address1,
			'address2' => $address2,
			'locality' => $locality,
			'city' => $city,
			'pincode' => $pincode,
			'builduparea' => $builduparea,
			'carpetarea' => $carpetarea,
			'facing' => $facing,
			'powerbackup' => $powerbackup,
			'verified' => $verified,
			'status' => $status,
			'reportmessage' => $reportmessage,
			'commitescore' => $commitescore,
			'localityscore' => $localityscore,
			'societyscore' => $societyscore,
			'possesion' => $possesion,
			'aerialview' => $aerialview,
			'insights' => $insights,
			'isnew' => $isnew,
			'pricetrends' => $pricetrends,
			'yearofestablishment' => $yearofestablishment,
			'totalprojects' => $totalproject,
			'associatemembership' => $associatemembership,
			'interior' => $interior,
			'floorplan3d' => $threedfloorplan,
			'floorplan2d' => $image,
            'age' => $age,
            'luxury' => $luxury,
            'residential' => $residential,
            'kitchen' => $kitchen,
            'developmentnego' => $developmentnego,
            'preferencialnego' => $preferencialnego,
            'parkingnego' => $parkingnego,
            'maintainancenego' => $maintainancenego,
            'clubhousenego' => $clubhousenego,
            'floorrisenego' => $floorrisenego,
            'othernego' => $othernego,
            'rentnego' => $rentnego,
            'depositenego' => $depositenego,
            'json' => $json,
			'iscommercial' => $iscommercial
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'property', $data );
        $querydelete=$this->db->query("DELETE FROM `propertysocietyfacility` WHERE `property`='$id'");
        $querydelete=$this->db->query("DELETE FROM `propertyamenity` WHERE `property`='$id'");
        foreach($societyfacility AS $key=>$value)
        {
            $this->property_model->createpropertysocietyfacility($value,$id);
        }
        foreach($amenity AS $key=>$value)
        {
            $this->property_model->createpropertyamenity($value,$id);
        }
		return 1;
	}
	function deleteproperty($id)
	{
		$query=$this->db->query("DELETE FROM `property` WHERE `id`='$id'");
//		$deletepropertyimages=$this->db->query("DELETE FROM `propertyimage` WHERE `property`='$id'");
//		$deletepropertyimages=$this->db->query("DELETE FROM `propertysocietyfacility` WHERE `property`='$id'");
//		$deletepropertyimages=$this->db->query("DELETE FROM `propertygeolocation` WHERE `property`='$id'");
//		$deletepropertyimages=$this->db->query("DELETE FROM `propertyenquiry` WHERE `property`='$id'");
//		$deletepropertyimages=$this->db->query("DELETE FROM `propertyamenity` WHERE `property`='$id'");
	}
    
    public function getpropertydropdown()
	{
		$query=$this->db->query("SELECT * FROM `property`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
	public function getpropertyimagebyid($id)
	{
		$query=$this->db->query("SELECT `floorplan2d` FROM `property` WHERE `id`='$id'")->row();
		return $query;
	}
    
    //for dropdown
    
    public function getcategorydropdown()
	{
		$query=$this->db->query("SELECT * FROM `category`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    
    public function getfurnishingdropdown()
	{
		$query=$this->db->query("SELECT * FROM `furnishing`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
     public function getlistedbydropdown()
	{
		$query=$this->db->query("SELECT * FROM `listedby`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
     public function getstatusdropdown()
	{
		$query=$this->db->query("SELECT * FROM `statuses`  ORDER BY `id` ASC")->result();
		$return=array(
		);
		foreach($query as $row)
		{
			$return[$row->id]=$row->name;
		}
		
		return $return;
	}
    public function getnegotiabledropdown()
	{
		$negotiable= array(
			 "True" => "True",
			 "False" => "False"
			);
		return $negotiable;
	}
    public function getisnewdropdown()
	{
		$isnew= array(
			 "0" => "No",
			 "1" => "Yes"
			);
		return $isnew;
	}
    public function getbathroomdropdown()
	{
		$bathroom= array(
			 "Any" => "Any",
			 "1+" => "1+",
			 "2+" => "2+",
			 "3+" => "3+",
			 "4+" => "4+"
			);
		return $bathroom;
	}
    public function getbhkdropdown()
	{
		$bhk= array(
			 "1RK" => "1RK",
			 "1BHK" => "1BHK",
			 "2BHK" => "2BHK",
			 "3BHK" => "3BHK",
			 "4BHK" => "4BHK",
			 "4BHK+" => "4BHK+"
			);
		return $bhk;
	}
    public function getiscommercialdropdown()
	{
		$iscommercial= array(
			 "True" => "True",
			 "False" => "False"
			);
		return $iscommercial;
	}
    public function getverifieddropdown()
	{
		$verified= array(
			 "Yes" => "Yes",
			 "No" => "No"
			);
		return $verified;
	}
    
    
    public function getluxurydropdown()
	{
		$luxury= array(
			 "Yes" => "Yes",
			 "No" => "No"
			);
		return $luxury;
	}
    
     public function getsocietyfacilitybyproperty($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`property`,`societyfacility` FROM `propertysocietyfacility`  WHERE `property`='$id'");
        if($query->num_rows() > 0)
        {
            $query=$query->result();
            foreach($query as $row)
            {
                $return[]=$row->societyfacility;
            }
        }
         return $return;
         
		
	}
     public function getamenitybyproperty($id)
	{
         $return=array();
		$query=$this->db->query("SELECT `id`,`property`,`amenity` FROM `propertyamenity`  WHERE `property`='$id'");
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
    
	public function addusershortlist($userid,$propertyid)
	{
        $query="SELECT * FROM `usershortlist` WHERE `user`='$userid' AND `property`='$propertyid'";
        $row=$this->db->query($query);
        if($row->num_rows() > 0)
        {
            return 1;
        }
        else
        {
            $data  = array(
                'user' => $userid,
                'property' => $propertyid
            );
            $queryadd=$this->db->insert( 'usershortlist', $data );
            if($queryadd)
            {
                return  1;
            }
            else
            {
                return 0;
            }
        }
	}
}
?>