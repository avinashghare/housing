<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Property_model extends CI_Model
{
	public function create($name,$email,$category,$builder,$listingowner,$price,$leasetype,$listedby,$furnishing,$propertytype,$bathroom,$negotiable,$bhk,$address1,$address2,$locality,$city,$pincode,$builduparea,$carpetarea,$facing,$powerbackup,$verified,$status,$reportmessage,$commitescore,$localityscore,$societyscore,$possesion,$aerialview,$insights,$pricetrends,$yearofestablishment,$totalproject,$associatemembership,$interior,$threedfloorplan,$iscommercial,$image,$securitydeposite,$societyfacility,$amenity)
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
			'pricetrends' => $pricetrends,
			'yearofestablishment' => $yearofestablishment,
			'totalprojects' => $totalproject,
			'associatemembership' => $associatemembership,
			'interior' => $interior,
			'floorplan3d' => $threedfloorplan,
			'floorplan2d' => $image,
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
	
	public function edit($id,$name,$email,$category,$builder,$listingowner,$price,$leasetype,$listedby,$furnishing,$propertytype,$bathroom,$negotiable,$bhk,$address1,$address2,$locality,$city,$pincode,$builduparea,$carpetarea,$facing,$powerbackup,$verified,$status,$reportmessage,$commitescore,$localityscore,$societyscore,$possesion,$aerialview,$insights,$pricetrends,$yearofestablishment,$totalproject,$associatemembership,$interior,$threedfloorplan,$iscommercial,$image,$securitydeposite,$societyfacility,$amenity)
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
			'pricetrends' => $pricetrends,
			'yearofestablishment' => $yearofestablishment,
			'totalprojects' => $totalproject,
			'associatemembership' => $associatemembership,
			'interior' => $interior,
			'floorplan3d' => $threedfloorplan,
			'floorplan2d' => $image,
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
}
?>