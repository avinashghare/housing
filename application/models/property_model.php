<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Property_model extends CI_Model
{
	public function create($name,$email,$contact,$line1,$line2,$line3,$city,$state,$pincode,$country,$landmark,$vat,$tin,$pan,$color1,$color2,$theme,$image,$user)
	{
		$data  = array(
			'name' => $name,
			'email' => $email,
            'contact' => $contact,
			'line1' => $line1,
			'line2' => $line2,
			'line3' => $line3,
			'city' => $city,
			'state' => $state,
			'pincode' => $pincode,
			'country' => $country,
			'landmark' => $landmark,
			'vat' => $vat,
			'tin' => $tin,
			'pan' => $pan,
			'color1' => $color1,
			'color2' => $color2,
			'theme' => $theme,
			'user' => $user,
			'logo' => $image
		);
		$query=$this->db->insert( 'property', $data );
		$id=$this->db->insert_id();
		
		if(!$query)
			return  0;
		else
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
	
	public function edit($id,$name,$email,$contact,$line1,$line2,$line3,$city,$state,$pincode,$country,$landmark,$vat,$tin,$pan,$color1,$color2,$theme,$image,$user)
	{
		$data  = array(
			'name' => $name,
			'email' => $email,
            'contact' => $contact,
			'line1' => $line1,
			'line2' => $line2,
			'line3' => $line3,
			'city' => $city,
			'state' => $state,
			'pincode' => $pincode,
			'country' => $country,
			'landmark' => $landmark,
			'vat' => $vat,
			'tin' => $tin,
			'pan' => $pan,
			'color1' => $color1,
			'color2' => $color2,
			'theme' => $theme,
			'user' => $user,
			'logo' => $image
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'property', $data );
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
		$query=$this->db->query("SELECT `logo` FROM `property` WHERE `id`='$id'")->row();
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
}
?>