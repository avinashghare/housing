<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
//		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('contact','contact','trim');
		$this->form_validation->set_rules('address','address','trim');
//		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data['category']=$this->category_model->getcategorydropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
//            $status=$this->input->post('status');
            $contact=$this->input->post('contact');
            $address=$this->input->post('address');
//            $json=$this->input->post('json');
//            $category=$this->input->post('category');
            
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
            
			if($this->user_model->create($name,$email,$password,$accesslevel,$contact,$address,$image)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");
        
		$data['title']='View Users';
		$this->load->view('template',$data);
	} 
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`contact`";
        $elements[3]->sort="1";
        $elements[3]->header="Contact";
        $elements[3]->alias="contact";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`user`.`timestamp`";
        $elements[4]->sort="1";
        $elements[4]->header="Timestamp";
        $elements[4]->alias="timestamp";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`address`";
        $elements[5]->sort="1";
        $elements[5]->header="address";
        $elements[5]->alias="address";
       
        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";
       
//        $elements[7]=new stdClass();
//        $elements[7]->field="`statuses`.`name`";
//        $elements[7]->sort="1";
//        $elements[7]->header="Status";
//        $elements[7]->alias="status";
       
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` ");
        
		$this->load->view("json",$data);
	} 
    
    
	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
//		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('contact','contact','trim');
		$this->form_validation->set_rules('address','address','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
//            $status=$this->input->get_post('status');
            $contact=$this->input->get_post('contact');
            $address=$this->input->get_post('address');
//            $category=$this->input->get_post('category');
            
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
            if($image=="")
            {
                $image=$this->user_model->getuserimagebyid($id);
                $image=$image->image;
            }
            
            
			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$contact,$address,$image)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    
    //societyfacility
    function viewsocietyfacility()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewsocietyfacility';
        $data['base_url'] = site_url("site/viewsocietyfacilityjson");
        
		$data['title']='View Society Facility';
		$this->load->view('template',$data);
	} 
    function viewsocietyfacilityjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`societyfacility`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`societyfacility`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `societyfacility`");
        
		$this->load->view("json",$data);
	} 
    
    public function createsocietyfacility()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createsocietyfacility';
		$data[ 'title' ] = 'Create Society Facility';
		$this->load->view( 'template', $data );	
	}
	function createsocietyfacilitysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createsocietyfacility';
            $data[ 'title' ] = 'Create  Society Facility';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
			if($this->societyfacility_model->create($name)==0)
			$data['alerterror']="New Society Facility could not be created.";
			else
			$data['alertsuccess']="Society Facility created Successfully.";
			$data['redirect']="site/viewsocietyfacility";
			$this->load->view("redirect",$data);
		}
	}
    
	function editsocietyfacility()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editsocietyfacility';
		$data['title']='Edit Society Facility';
		$data['before']=$this->societyfacility_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editsocietyfacilitysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editsocietyfacility';
            $data['before']=$this->societyfacility_model->beforeedit($this->input->get('id'));
			$data['title']='Edit Society Facility';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
			if($this->societyfacility_model->edit($id,$name)==0)
			$data['alerterror']="Society Facility Editing was unsuccesful";
			else
			$data['alertsuccess']="Society Facility edited Successfully.";
			
			$data['redirect']="site/viewsocietyfacility";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletesocietyfacility()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->societyfacility_model->deletesocietyfacility($this->input->get('id'));
		$data['alertsuccess']="Society Facility Deleted Successfully";
		$data['redirect']="site/viewsocietyfacility";
		$this->load->view("redirect",$data);
	}
    
    //amenity
    function viewamenity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewamenity';
        $data['base_url'] = site_url("site/viewamenityjson");
        
		$data['title']='View Amenity';
		$this->load->view('template',$data);
	} 
    function viewamenityjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`amenity`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`amenity`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`amenity`.`image`";
        $elements[2]->sort="1";
        $elements[2]->header="Image";
        $elements[2]->alias="image";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `amenity`");
        
		$this->load->view("json",$data);
	} 
    
    public function createamenity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createamenity';
		$data[ 'title' ] = 'Create Amenity';
		$this->load->view( 'template', $data );	
	}
	function createamenitysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createamenity';
            $data[ 'title' ] = 'Create Amenity';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
			if($this->amenity_model->create($name,$image)==0)
			$data['alerterror']="New Amenity could not be created.";
			else
			$data['alertsuccess']="Amenity created Successfully.";
			$data['redirect']="site/viewamenity";
			$this->load->view("redirect",$data);
		}
	}
    
	function editamenity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editamenity';
		$data['title']='Edit Amenity';
		$data['before']=$this->amenity_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editamenitysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editamenity';
            $data['before']=$this->amenity_model->beforeedit($this->input->get('id'));
			$data['title']='Edit Amenity';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
            if($image=="")
            {
                $image=$this->amenity_model->getamenityimagebyid($id);
                $image=$image->image;
            }
            
			if($this->amenity_model->edit($id,$name,$image)==0)
			$data['alerterror']="Amenity Editing was unsuccesful";
			else
			$data['alertsuccess']="Amenity edited Successfully.";
			
			$data['redirect']="site/viewamenity";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteamenity()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->amenity_model->deleteamenity($this->input->get('id'));
		$data['alertsuccess']="Amenity Deleted Successfully";
		$data['redirect']="site/viewamenity";
		$this->load->view("redirect",$data);
	}
    
    
    //builder
    function viewbuilder()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewbuilder';
        $data['base_url'] = site_url("site/viewbuilderjson");
        
		$data['title']='View builder';
		$this->load->view('template',$data);
	} 
    function viewbuilderjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`builder`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`builder`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`builder`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`builder`.`contact`";
        $elements[3]->sort="1";
        $elements[3]->header="Contact";
        $elements[3]->alias="contact";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`builder`.`address`";
        $elements[4]->sort="1";
        $elements[4]->header="Address";
        $elements[4]->alias="address";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `builder`");
        
		$this->load->view("json",$data);
	} 
    
    public function createbuilder()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createbuilder';
		$data[ 'title' ] = 'Create builder';
		$this->load->view( 'template', $data );	
	}
	function createbuildersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('email','email','trim');
		$this->form_validation->set_rules('contact','contact','trim');
		$this->form_validation->set_rules('address','address','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createbuilder';
            $data[ 'title' ] = 'Create builder';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $contact=$this->input->post('contact');
            $address=$this->input->post('address');
            
			if($this->builder_model->create($name,$email,$contact,$address)==0)
			$data['alerterror']="New builder could not be created.";
			else
			$data['alertsuccess']="builder created Successfully.";
			$data['redirect']="site/viewbuilder";
			$this->load->view("redirect",$data);
		}
	}
    
	function editbuilder()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editbuilder';
		$data['title']='Edit builder';
		$data['before']=$this->builder_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editbuildersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('email','email','trim');
		$this->form_validation->set_rules('contact','contact','trim');
		$this->form_validation->set_rules('address','address','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editbuilder';
            $data['before']=$this->builder_model->beforeedit($this->input->get('id'));
			$data['title']='Edit builder';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->post('email');
            $contact=$this->input->post('contact');
            $address=$this->input->post('address');
            
			if($this->builder_model->edit($id,$name,$email,$contact,$address)==0)
			$data['alerterror']="builder Editing was unsuccesful";
			else
			$data['alertsuccess']="builder edited Successfully.";
			
			$data['redirect']="site/viewbuilder";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletebuilder()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->builder_model->deletebuilder($this->input->get('id'));
		$data['alertsuccess']="Builder Deleted Successfully";
		$data['redirect']="site/viewbuilder";
		$this->load->view("redirect",$data);
	}
    
    
    //leasetype
    function viewleasetype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewleasetype';
        $data['base_url'] = site_url("site/viewleasetypejson");
        
		$data['title']='View leasetype';
		$this->load->view('template',$data);
	} 
    function viewleasetypejson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`leasetype`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`leasetype`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `leasetype`");
        
		$this->load->view("json",$data);
	} 
    
    public function createleasetype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createleasetype';
		$data[ 'title' ] = 'Create leasetype';
		$this->load->view( 'template', $data );	
	}
	function createleasetypesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createleasetype';
            $data[ 'title' ] = 'Create leasetype';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            
			if($this->leasetype_model->create($name)==0)
			$data['alerterror']="New Lease Type could not be created.";
			else
			$data['alertsuccess']="Lease Type created Successfully.";
			$data['redirect']="site/viewleasetype";
			$this->load->view("redirect",$data);
		}
	}
    
	function editleasetype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editleasetype';
		$data['title']='Edit Lease Type';
		$data['before']=$this->leasetype_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editleasetypesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editleasetype';
            $data['before']=$this->leasetype_model->beforeedit($this->input->get('id'));
			$data['title']='Edit Lease Type';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            
			if($this->leasetype_model->edit($id,$name)==0)
			$data['alerterror']="Lease Type Editing was unsuccesful";
			else
			$data['alertsuccess']="Lease Type edited Successfully.";
			
			$data['redirect']="site/viewleasetype";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteleasetype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->leasetype_model->deleteleasetype($this->input->get('id'));
		$data['alertsuccess']="Lease Type Deleted Successfully";
		$data['redirect']="site/viewleasetype";
		$this->load->view("redirect",$data);
	}
    
    
    //propertytype
    function viewpropertytype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewpropertytype';
        $data['base_url'] = site_url("site/viewpropertytypejson");
        
		$data['title']='View Property Type';
		$this->load->view('template',$data);
	} 
    function viewpropertytypejson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`propertytype`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`propertytype`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `propertytype`");
        
		$this->load->view("json",$data);
	} 
    
    public function createpropertytype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createpropertytype';
		$data[ 'title' ] = 'Create Property Type';
		$this->load->view( 'template', $data );	
	}
	function createpropertytypesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createpropertytype';
            $data[ 'title' ] = 'Create  Property Type';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
			if($this->propertytype_model->create($name)==0)
			$data['alerterror']="New Property Type could not be created.";
			else
			$data['alertsuccess']="Property Type created Successfully.";
			$data['redirect']="site/viewpropertytype";
			$this->load->view("redirect",$data);
		}
	}
    
	function editpropertytype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editpropertytype';
		$data['title']='Edit Property Type';
		$data['before']=$this->propertytype_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editpropertytypesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editpropertytype';
            $data['before']=$this->propertytype_model->beforeedit($this->input->get('id'));
			$data['title']='Edit Property Type';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
			if($this->propertytype_model->edit($id,$name)==0)
			$data['alerterror']="Property Type Editing was unsuccesful";
			else
			$data['alertsuccess']="Property Type edited Successfully.";
			
			$data['redirect']="site/viewpropertytype";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletepropertytype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->propertytype_model->deletepropertytype($this->input->get('id'));
		$data['alertsuccess']="Property Type Deleted Successfully";
		$data['redirect']="site/viewpropertytype";
		$this->load->view("redirect",$data);
	}
    
    
     
    //property
    function viewproperty()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewproperty';
        $data['base_url'] = site_url("site/viewpropertyjson");
        
		$data['title']='View property';
		$this->load->view('template',$data);
	} 
    function viewpropertyjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`property`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`property`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`property`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="email";
        $elements[2]->alias="email";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`category`.`name`";
        $elements[3]->sort="1";
        $elements[3]->header="Category";
        $elements[3]->alias="categoryname";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`builder`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Builder";
        $elements[4]->alias="buildername";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`property`.`price`";
        $elements[5]->sort="1";
        $elements[5]->header="Price";
        $elements[5]->alias="price";
        
        $elements[6]=new stdClass();
        $elements[6]->field="`property`.`bhk`";
        $elements[6]->sort="1";
        $elements[6]->header="BHK";
        $elements[6]->alias="bhk";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `property` LEFT OUTER JOIN `category` ON `category`.`id`=`property`.`category` LEFT OUTER JOIN `builder` ON `builder`.`id`=`property`.`builder`");
        
		$this->load->view("json",$data);
	} 
    
    public function createproperty()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $json=array();
        
        $json[0]=new stdClass();
        $json[0]->placeholder="";
        $json[0]->value="";
        $json[0]->label="State";
        $json[0]->type="text";
        $json[0]->options="";
        $json[0]->classes="";
        
        $json[1]=new stdClass();
        $json[1]->placeholder="";
        $json[1]->value="";
        $json[1]->label="Floors";
        $json[1]->type="text";
        $json[1]->options="";
        $json[1]->classes="";
        
        $json[2]=new stdClass();
        $json[2]->placeholder="";
        $json[2]->value="";
        $json[2]->label="Rent per Month";
        $json[2]->type="text";
        $json[2]->options="";
        $json[2]->classes="";
        
        $json[3]=new stdClass();
        $json[3]->placeholder="";
        $json[3]->value="";
        $json[3]->label="Price Per Sq. Ft.";
        $json[3]->type="text";
        $json[3]->options="";
        $json[3]->classes="";
        
        $json[4]=new stdClass();
        $json[4]->placeholder="";
        $json[4]->value="";
        $json[4]->label="Rent Per Sq. Ft.";
        $json[4]->type="text";
        $json[4]->options="";
        $json[4]->classes="";
        
        $json[5]=new stdClass();
        $json[5]->placeholder="";
        $json[5]->value="";
        $json[5]->label="Lifts";
        $json[5]->type="text";
        $json[5]->options="";
        $json[5]->classes="";
        
        $json[6]=new stdClass();
        $json[6]->placeholder="";
        $json[6]->value="";
        $json[6]->label="Airports";
        $json[6]->type="text";
        $json[6]->options="";
        $json[6]->classes="";
        
        $json[7]=new stdClass();
        $json[7]->placeholder="";
        $json[7]->value="";
        $json[7]->label="Train Stations";
        $json[7]->type="text";
        $json[7]->options="";
        $json[7]->classes="";
        
        $json[8]=new stdClass();
        $json[8]->placeholder="";
        $json[8]->value="";
        $json[8]->label="Bus Stations";
        $json[8]->type="text";
        $json[8]->options="";
        $json[8]->classes="";
        
        $json[9]=new stdClass();
        $json[9]->placeholder="";
        $json[9]->value="";
        $json[9]->label="Restaurants";
        $json[9]->type="text";
        $json[9]->options="";
        $json[9]->classes="";
        
        $json[10]=new stdClass();
        $json[10]->placeholder="";
        $json[10]->value="";
        $json[10]->label="Movie Theaters";
        $json[10]->type="text";
        $json[10]->options="";
        $json[10]->classes="";
        
        $json[11]=new stdClass();
        $json[11]->placeholder="";
        $json[11]->value="";
        $json[11]->label="Bars Or Night Clubs";
        $json[11]->type="text";
        $json[11]->options="";
        $json[11]->classes="";
        
        $json[12]=new stdClass();
        $json[12]->placeholder="";
        $json[12]->value="";
        $json[12]->label="Departmental Stores Or Grocery";
        $json[12]->type="text";
        $json[12]->options="";
        $json[12]->classes="";
        
        $json[13]=new stdClass();
        $json[13]->placeholder="";
        $json[13]->value="";
        $json[13]->label="Pharmacies";
        $json[13]->type="text";
        $json[13]->options="";
        $json[13]->classes="";
        
        $json[14]=new stdClass();
        $json[14]->placeholder="";
        $json[14]->value="";
        $json[14]->label="Shopping Mall";
        $json[14]->type="text";
        $json[14]->options="";
        $json[14]->classes="";
        
        $json[15]=new stdClass();
        $json[15]->placeholder="";
        $json[15]->value="";
        $json[15]->label="Bank Or ATMs";
        $json[15]->type="text";
        $json[15]->options="";
        $json[15]->classes="";
        
        $json[16]=new stdClass();
        $json[16]->placeholder="";
        $json[16]->value="";
        $json[16]->label="Hospitals";
        $json[16]->type="text";
        $json[16]->options="";
        $json[16]->classes="";
        
        $json[17]=new stdClass();
        $json[17]->placeholder="";
        $json[17]->value="";
        $json[17]->label="Schools";
        $json[17]->type="text";
        $json[17]->options="";
        $json[17]->classes="";
        
        $json[18]=new stdClass();
        $json[18]->placeholder="";
        $json[18]->value="";
        $json[18]->label="Parks";
        $json[18]->type="text";
        $json[18]->options="";
        $json[18]->classes="";
        
        $data["fieldjson"]=$json;
        
        $data['societyfacility']=$this->societyfacility_model->getsocietyfacilitydropdown();
        $data['amenity']=$this->amenity_model->getamenitydropdown();
        $data['age']=$this->amenity_model->getagedropdown();
        $data['category']=$this->property_model->getcategorydropdown();
        $data['luxury']=$this->property_model->getluxurydropdown();
        $data['builder']=$this->builder_model->getbuilderdropdown();
        $data['listingowner']=$this->user_model->getlistingownerdropdown();
        $data['listedby']=$this->property_model->getlistedbydropdown();
        $data['furnishing']=$this->property_model->getfurnishingdropdown();
        $data['leasetype']=$this->leasetype_model->getleasetypedropdown();
        $data['propertytype']=$this->propertytype_model->getpropertytypedropdown();
        $data['status']=$this->property_model->getstatusdropdown();
        $data['negotiable']=$this->property_model->getnegotiabledropdown();
        $data['bathroom']=$this->property_model->getbathroomdropdown();
        $data['bhk']=$this->property_model->getbhkdropdown();
        $data['iscommercial']=$this->property_model->getiscommercialdropdown();
        $data['verified']=$this->property_model->getverifieddropdown();
        $data['isnew']=$this->property_model->getisnewdropdown();
		$data[ 'page' ] = 'createproperty';
		$data[ 'title' ] = 'Create property';
		$this->load->view( 'template', $data );	
	}
	function createpropertysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('price','price','trim');
		$this->form_validation->set_rules('category','category','trim');
		$this->form_validation->set_rules('builder','builder','trim');
		$this->form_validation->set_rules('listingowner','listingowner','trim');
		$this->form_validation->set_rules('leasetype','leasetype','trim');
		$this->form_validation->set_rules('propertytype','propertytype','trim');
		$this->form_validation->set_rules('bathroom','bathroom','trim');
		$this->form_validation->set_rules('negotiable','negotiable','trim');
		$this->form_validation->set_rules('bhk','bhk','trim');
		$this->form_validation->set_rules('address1','address1','trim');
		$this->form_validation->set_rules('address2','address2','trim');
		$this->form_validation->set_rules('locality','locality','trim');
		$this->form_validation->set_rules('city','city','trim');
		$this->form_validation->set_rules('pincode','pincode','trim');
		$this->form_validation->set_rules('builduparea','builduparea','trim');
		$this->form_validation->set_rules('carpetarea','carpetarea','trim');
		$this->form_validation->set_rules('facing','facing','trim');
		$this->form_validation->set_rules('powerbackup','powerbackup','trim');
		$this->form_validation->set_rules('verified','verified','trim');
		$this->form_validation->set_rules('status','status','trim');
		$this->form_validation->set_rules('reportmessage','reportmessage','trim');
		$this->form_validation->set_rules('commitecode','commitecode','trim');
		$this->form_validation->set_rules('localityscore','localityscore','trim');
		$this->form_validation->set_rules('societyscore','societyscore','trim');
		$this->form_validation->set_rules('possesion','possesion','trim');
		$this->form_validation->set_rules('aerialview','aerialview','trim');
		$this->form_validation->set_rules('insights','insights','trim');
		$this->form_validation->set_rules('pricetrends','pricetrends','trim');
		$this->form_validation->set_rules('yearofestablishment','yearofestablishment','trim');
		$this->form_validation->set_rules('totalproject','totalproject','trim');
		$this->form_validation->set_rules('associatemembership','associatemembership','trim');
		$this->form_validation->set_rules('interior','interior','trim');
		$this->form_validation->set_rules('threedfloorplan','3Dfloorplan','trim');
		$this->form_validation->set_rules('iscommercial','iscommercial','trim');
		$this->form_validation->set_rules('securitydeposite','securitydeposite','trim');
		$this->form_validation->set_rules('isnew','isnew','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['societyfacility']=$this->societyfacility_model->getsocietyfacilitydropdown();
            $data['amenity']=$this->amenity_model->getamenitydropdown();
            $data['age']=$this->amenity_model->getagedropdown();
            $data['category']=$this->property_model->getcategorydropdown();
            $data['builder']=$this->builder_model->getbuilderdropdown();
            $data['listingowner']=$this->user_model->getlistingownerdropdown();
            $data['listedby']=$this->property_model->getlistedbydropdown();
            $data['furnishing']=$this->property_model->getfurnishingdropdown();
            $data['luxury']=$this->property_model->getluxurydropdown();
            $data['leasetype']=$this->leasetype_model->getleasetypedropdown();
            $data['propertytype']=$this->propertytype_model->getpropertytypedropdown();
            $data['status']=$this->property_model->getstatusdropdown();
            $data['negotiable']=$this->property_model->getnegotiabledropdown();
            $data['bathroom']=$this->property_model->getbathroomdropdown();
            $data['bhk']=$this->property_model->getbhkdropdown();
            $data['iscommercial']=$this->property_model->getiscommercialdropdown();
            $data['verified']=$this->property_model->getverifieddropdown();
            $data[ 'page' ] = 'createproperty';
            $data[ 'title' ] = 'Create property';
            $this->load->view( 'template', $data );	
		}
		else
		{
            
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $category=$this->input->post('category');
            $builder=$this->input->post('builder');
            $listingowner=$this->input->post('listingowner');
            $price=$this->input->post('price');
            $leasetype=$this->input->post('leasetype');
            $listedby=$this->input->post('listedby');
            $furnishing=$this->input->post('furnishing');
            $propertytype=$this->input->post('propertytype');
            $bathroom=$this->input->post('bathroom');
            $negotiable=$this->input->post('negotiable');
            $bhk=$this->input->post('bhk');
            $address1=$this->input->post('address1');
            $address2=$this->input->post('address2');
            $locality=$this->input->post('locality');
            $city=$this->input->post('city');
            $pincode=$this->input->post('pincode');
            $builduparea=$this->input->post('builduparea');
            $carpetarea=$this->input->post('carpetarea');
            $facing=$this->input->post('facing');
            $powerbackup=$this->input->post('powerbackup');
            $verified=$this->input->post('verified');
            $status=$this->input->post('status');
            $reportmessage=$this->input->post('reportmessage');
            $commitescore=$this->input->post('commitescore');
            $localityscore=$this->input->post('localityscore');
            $societyscore=$this->input->post('societyscore');
            $possesion=$this->input->post('possesion');
            $aerialview=$this->input->post('aerialview');
            $insights=$this->input->post('insights');
            $pricetrends=$this->input->post('pricetrends');
            $yearofestablishment=$this->input->post('yearofestablishment');
            $totalproject=$this->input->post('totalproject');
            $associatemembership=$this->input->post('associatemembership');
            $interior=$this->input->post('interior');
            $threedfloorplan=$this->input->post('threedfloorplan');
//            $twodfloorplan=$this->input->post('twodfloorplan');
            $iscommercial=$this->input->post('iscommercial');
            $securitydeposite=$this->input->post('securitydeposite');
            $societyfacility=$this->input->post('societyfacility');
            $amenity=$this->input->post('amenity');
            $isnew=$this->input->post('isnew');
            
//            $age,$luxury,$residential,$kitchen,$developmentnego,$preferencialnego,$parkingnego,$maintainancenego,$clubhousenego,$floorrisenego,$othernego,$rentnego,$depositenego,$json
            
            $age=$this->input->post('age');
            $luxury=$this->input->post('luxury');
            $residential=$this->input->post('residential');
            $kitchen=$this->input->post('kitchen');
            $developmentnego=$this->input->post('developmentnego');
            $preferencialnego=$this->input->post('preferencialnego');
            $parkingnego=$this->input->post('parkingnego');
            $maintainancenego=$this->input->post('maintainancenego');
            $clubhousenego=$this->input->post('clubhousenego');
            $floorrisenego=$this->input->post('floorrisenego');
            $othernego=$this->input->post('othernego');
            $rentnego=$this->input->post('rentnego');
            $depositenego=$this->input->post('depositenego');
            $json=$this->input->post('json');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
			if($this->property_model->create($name,$email,$category,$builder,$listingowner,$price,$leasetype,$listedby,$furnishing,$propertytype,$bathroom,$negotiable,$bhk,$address1,$address2,$locality,$city,$pincode,$builduparea,$carpetarea,$facing,$powerbackup,$verified,$status,$reportmessage,$commitescore,$localityscore,$societyscore,$possesion,$aerialview,$insights,$pricetrends,$yearofestablishment,$totalproject,$associatemembership,$interior,$threedfloorplan,$iscommercial,$image,$securitydeposite,$societyfacility,$amenity,$isnew,$age,$luxury,$residential,$kitchen,$developmentnego,$preferencialnego,$parkingnego,$maintainancenego,$clubhousenego,$floorrisenego,$othernego,$rentnego,$depositenego,$json)==0)
			$data['alerterror']="New property could not be created.";
			else
			$data['alertsuccess']="property created Successfully.";
			$data['redirect']="site/viewproperty";
			$this->load->view("redirect",$data);
		}
	}
    
	function editproperty()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['societyfacility']=$this->societyfacility_model->getsocietyfacilitydropdown();
        $data['amenity']=$this->amenity_model->getamenitydropdown();
        $data['age']=$this->amenity_model->getagedropdown();
        $data['category']=$this->property_model->getcategorydropdown();
        $data['luxury']=$this->property_model->getluxurydropdown();
        $data['builder']=$this->builder_model->getbuilderdropdown();
        $data['listingowner']=$this->user_model->getlistingownerdropdown();
        $data['listedby']=$this->property_model->getlistedbydropdown();
        $data['furnishing']=$this->property_model->getfurnishingdropdown();
        $data['leasetype']=$this->leasetype_model->getleasetypedropdown();
        $data['propertytype']=$this->propertytype_model->getpropertytypedropdown();
        $data['status']=$this->property_model->getstatusdropdown();
        $data['negotiable']=$this->property_model->getnegotiabledropdown();
        $data['bathroom']=$this->property_model->getbathroomdropdown();
        $data['bhk']=$this->property_model->getbhkdropdown();
        $data['iscommercial']=$this->property_model->getiscommercialdropdown();
        $data['verified']=$this->property_model->getverifieddropdown();
        $data['isnew']=$this->property_model->getisnewdropdown();
		$data['before']=$this->property_model->beforeedit($this->input->get('id'));
        $data['selectedsocietyfacility']=$this->property_model->getsocietyfacilitybyproperty($this->input->get_post('id'));
        $data['selectedamenity']=$this->property_model->getamenitybyproperty($this->input->get_post('id'));
		$data['page']='editproperty';
		$data['page2']='block/propertyblock';
		$data['title']='Edit property';
		$this->load->view('templatewith2',$data);
	}
	function editpropertysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('price','price','trim');
		$this->form_validation->set_rules('category','category','trim');
		$this->form_validation->set_rules('builder','builder','trim');
		$this->form_validation->set_rules('listingowner','listingowner','trim');
		$this->form_validation->set_rules('leasetype','leasetype','trim');
		$this->form_validation->set_rules('propertytype','propertytype','trim');
		$this->form_validation->set_rules('bathroom','bathroom','trim');
		$this->form_validation->set_rules('negotiable','negotiable','trim');
		$this->form_validation->set_rules('bhk','bhk','trim');
		$this->form_validation->set_rules('address1','address1','trim');
		$this->form_validation->set_rules('address2','address2','trim');
		$this->form_validation->set_rules('locality','locality','trim');
		$this->form_validation->set_rules('city','city','trim');
		$this->form_validation->set_rules('pincode','pincode','trim');
		$this->form_validation->set_rules('builduparea','builduparea','trim');
		$this->form_validation->set_rules('carpetarea','carpetarea','trim');
		$this->form_validation->set_rules('facing','facing','trim');
		$this->form_validation->set_rules('powerbackup','powerbackup','trim');
		$this->form_validation->set_rules('verified','verified','trim');
		$this->form_validation->set_rules('status','status','trim');
		$this->form_validation->set_rules('reportmessage','reportmessage','trim');
		$this->form_validation->set_rules('commitecode','commitecode','trim');
		$this->form_validation->set_rules('localityscore','localityscore','trim');
		$this->form_validation->set_rules('societyscore','societyscore','trim');
		$this->form_validation->set_rules('possesion','possesion','trim');
		$this->form_validation->set_rules('aerialview','aerialview','trim');
		$this->form_validation->set_rules('insights','insights','trim');
		$this->form_validation->set_rules('pricetrends','pricetrends','trim');
		$this->form_validation->set_rules('yearofestablishment','yearofestablishment','trim');
		$this->form_validation->set_rules('totalproject','totalproject','trim');
		$this->form_validation->set_rules('associatemembership','associatemembership','trim');
		$this->form_validation->set_rules('interior','interior','trim');
		$this->form_validation->set_rules('threedfloorplan','3Dfloorplan','trim');
		$this->form_validation->set_rules('iscommercial','iscommercial','trim');
		$this->form_validation->set_rules('securitydeposite','securitydeposite','trim');
		$this->form_validation->set_rules('isnew','isnew','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editproperty';
            $data['luxury']=$this->property_model->getluxurydropdown();
            $data['age']=$this->amenity_model->getagedropdown();
            $data['category']=$this->property_model->getcategorydropdown();
            $data['builder']=$this->builder_model->getbuilderdropdown();
            $data['listingowner']=$this->user_model->getlistingownerdropdown();
            $data['listedby']=$this->property_model->getlistedbydropdown();
            $data['furnishing']=$this->property_model->getfurnishingdropdown();
            $data['leasetype']=$this->leasetype_model->getleasetypedropdown();
            $data['propertytype']=$this->propertytype_model->getpropertytypedropdown();
            $data['status']=$this->property_model->getstatusdropdown();
            $data['negotiable']=$this->property_model->getnegotiabledropdown();
            $data['bathroom']=$this->property_model->getbathroomdropdown();
            $data['bhk']=$this->property_model->getbhkdropdown();
            $data['iscommercial']=$this->property_model->getiscommercialdropdown();
            $data['verified']=$this->property_model->getverifieddropdown();
            $data['before']=$this->property_model->beforeedit($this->input->get('id'));
            $data['isnew']=$this->property_model->getisnewdropdown();
            $data['selectedsocietyfacility']=$this->property_model->getsocietyfacilitybyproperty($this->input->get_post('id'));
            $data['selectedamenity']=$this->property_model->getamenitybyproperty($this->input->get_post('id'));
			$data['title']='Edit property';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $category=$this->input->post('category');
            $builder=$this->input->post('builder');
            $listingowner=$this->input->post('listingowner');
            $price=$this->input->post('price');
            $leasetype=$this->input->post('leasetype');
            $listedby=$this->input->post('listedby');
            $furnishing=$this->input->post('furnishing');
            $propertytype=$this->input->post('propertytype');
            $bathroom=$this->input->post('bathroom');
            $negotiable=$this->input->post('negotiable');
            $bhk=$this->input->post('bhk');
            $address1=$this->input->post('address1');
            $address2=$this->input->post('address2');
            $locality=$this->input->post('locality');
            $city=$this->input->post('city');
            $pincode=$this->input->post('pincode');
            $builduparea=$this->input->post('builduparea');
            $carpetarea=$this->input->post('carpetarea');
            $facing=$this->input->post('facing');
            $powerbackup=$this->input->post('powerbackup');
            $verified=$this->input->post('verified');
            $status=$this->input->post('status');
            $reportmessage=$this->input->post('reportmessage');
            $commitescore=$this->input->post('commitescore');
            $localityscore=$this->input->post('localityscore');
            $societyscore=$this->input->post('societyscore');
            $possesion=$this->input->post('possesion');
            $aerialview=$this->input->post('aerialview');
            $insights=$this->input->post('insights');
            $pricetrends=$this->input->post('pricetrends');
            $yearofestablishment=$this->input->post('yearofestablishment');
            $totalproject=$this->input->post('totalproject');
            $associatemembership=$this->input->post('associatemembership');
            $interior=$this->input->post('interior');
            $threedfloorplan=$this->input->post('threedfloorplan');
//            $twodfloorplan=$this->input->post('twodfloorplan');
            $iscommercial=$this->input->post('iscommercial');
            $securitydeposite=$this->input->post('securitydeposite');
            $societyfacility=$this->input->post('societyfacility');
            $isnew=$this->input->post('isnew');
            $amenity=$this->input->post('amenity');
            
            
            $age=$this->input->post('age');
            $luxury=$this->input->post('luxury');
            $residential=$this->input->post('residential');
            $kitchen=$this->input->post('kitchen');
            $developmentnego=$this->input->post('developmentnego');
            $preferencialnego=$this->input->post('preferencialnego');
            $parkingnego=$this->input->post('parkingnego');
            $maintainancenego=$this->input->post('maintainancenego');
            $clubhousenego=$this->input->post('clubhousenego');
            $floorrisenego=$this->input->post('floorrisenego');
            $othernego=$this->input->post('othernego');
            $rentnego=$this->input->post('rentnego');
            $depositenego=$this->input->post('depositenego');
            $json=$this->input->post('json');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
            if($image=="")
            {
                $image=$this->property_model->getpropertyimagebyid($id);
                $image=$image->floorplan2d;
            }
            
			if($this->property_model->edit($id,$name,$email,$category,$builder,$listingowner,$price,$leasetype,$listedby,$furnishing,$propertytype,$bathroom,$negotiable,$bhk,$address1,$address2,$locality,$city,$pincode,$builduparea,$carpetarea,$facing,$powerbackup,$verified,$status,$reportmessage,$commitescore,$localityscore,$societyscore,$possesion,$aerialview,$insights,$pricetrends,$yearofestablishment,$totalproject,$associatemembership,$interior,$threedfloorplan,$iscommercial,$image,$securitydeposite,$societyfacility,$amenity,$isnew,$age,$luxury,$residential,$kitchen,$developmentnego,$preferencialnego,$parkingnego,$maintainancenego,$clubhousenego,$floorrisenego,$othernego,$rentnego,$depositenego,$json)==0)
			$data['alerterror']="property Editing was unsuccesful";
			else
			$data['alertsuccess']="property edited Successfully.";
			
			$data['redirect']="site/viewproperty";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteproperty()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->property_model->deleteproperty($this->input->get('id'));
		$data['alertsuccess']="property Deleted Successfully";
		$data['redirect']="site/viewproperty";
		$this->load->view("redirect",$data);
	}
    
    
    //propertyimage
    
    function viewpropertyimage()
	{
		$access = array("1");
		$this->checkaccess($access);
        $propertyid=$this->input->get('id');
		$data['before']=$this->property_model->beforeedit($propertyid);
		$data['table']=$this->propertyimage_model->viewpropertyimagebyproperty($propertyid);
		$data['page']='viewpropertyimage';
		$data['page2']='block/propertyblock';
        $data['title']='View property Image';
		$this->load->view('templatewith2',$data);
	}
    
    
    
    public function createpropertyimage()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createpropertyimage';
		$data[ 'title' ] = 'Create propertyimage';
		$data[ 'propertyid' ] = $this->input->get('id');
//        $data['property']=$this->propertyimage_model->getpropertydropdown();
		$this->load->view( 'template', $data );	
	}
    function createpropertyimagesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('property','property','trim|required');

		if($this->form_validation->run() == FALSE)	
		{
            
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createpropertyimage';
            $data[ 'title' ] = 'Create propertyimage';
            $data[ 'propertyid' ] = $this->input->get_post('id');
//            $data['property']=$this->propertyimage_model->getpropertydropdown();
            $this->load->view( 'template', $data );	
		}
		else
		{
			$property=$this->input->post('property');
           
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
            
            if($this->propertyimage_model->create($property,$image)==0)
               $data['alerterror']="New propertyimage could not be created.";
            else
               $data['alertsuccess']="propertyimage created Successfully.";
			
			$data['redirect']="site/viewpropertyimage?id=".$property;
			$this->load->view("redirect",$data);
		}
	}
    
    function editpropertyimage()
	{
		$access = array("1");
		$this->checkaccess($access);
        $propertyid=$this->input->get('id');
        $data['propertyid']=$propertyid;
        $propertyimageid=$this->input->get('propertyimageid');
		$data['before']=$this->propertyimage_model->beforeedit($this->input->get('propertyimageid'));
        $data['property']=$this->propertyimage_model->getpropertydropdown();
		$data['page']='editpropertyimage';
		$data['title']='Edit propertyimage';
		$this->load->view('template',$data);
	}
	function editpropertyimagesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
        
		$this->form_validation->set_rules('property','property','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $propertyid=$this->input->post('property');
            $propertyimageid=$this->input->post('propertyimageid');
            $data['propertyid']=$propertyid;
			$data['before']=$this->propertyimage_model->beforeedit($this->input->post('propertyimageid'));
            $data['property']=$this->propertyimage_model->getpropertydropdown();
//			$data['page2']='block/eventblock';
			$data['page']='editpropertyimage';
			$data['title']='Edit propertyimage';
			$this->load->view('template',$data);
		}
		else
		{
            
			$id=$this->input->post('propertyimageid');
            $property=$this->input->post('property');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            if($image=="")
            {
                $image=$this->propertyimage_model->getpropertyimagebyid($id);
                $image=$image->image;
            }
            
			if($this->propertyimage_model->edit($id,$property,$image)==0)
			$data['alerterror']="propertyimage Editing was unsuccesful";
			else
			$data['alertsuccess']="propertyimage edited Successfully.";
			
			$data['redirect']="site/viewpropertyimage?id=".$property;
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletepropertyimage()
	{
		$access = array("1");
		$this->checkaccess($access);
        $propertyid=$this->input->get('id');
        $propertyimageid=$this->input->get('propertyimageid');
		$this->propertyimage_model->deletepropertyimage($this->input->get('propertyimageid'));
		$data['alertsuccess']="propertyimage Deleted Successfully";
		$data['redirect']="site/viewpropertyimage?id=".$propertyid;
		$this->load->view("redirect",$data);
	}
    
    //propertygeolocation
    
    function viewpropertygeolocation()
	{
		$access = array("1");
		$this->checkaccess($access);
        $propertyid=$this->input->get('id');
		$data['before']=$this->property_model->beforeedit($propertyid);
		$data['table']=$this->propertygeolocation_model->viewpropertygeolocationbyproperty($propertyid);
		$data['page']='viewpropertygeolocation';
		$data['page2']='block/propertyblock';
        $data['title']='View property Image';
		$this->load->view('templatewith2',$data);
	}
    
    
    
    public function createpropertygeolocation()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createpropertygeolocation';
		$data[ 'title' ] = 'Create propertygeolocation';
		$data[ 'propertyid' ] = $this->input->get('id');
		$this->load->view( 'template', $data );	
	}
    function createpropertygeolocationsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('property','property','trim|required');
		$this->form_validation->set_rules('lat','lat','trim|required');
		$this->form_validation->set_rules('long','long','trim|required');

		if($this->form_validation->run() == FALSE)	
		{
            
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createpropertygeolocation';
            $data[ 'title' ] = 'Create propertygeolocation';
            $data[ 'propertyid' ] = $this->input->get_post('id');
            $this->load->view( 'template', $data );	
		}
		else
		{
			$property=$this->input->post('property');
			$lat=$this->input->post('lat');
			$long=$this->input->post('long');
           
            
            if($this->propertygeolocation_model->create($property,$lat,$long)==0)
               $data['alerterror']="New propertygeolocation could not be created.";
            else
               $data['alertsuccess']="propertygeolocation created Successfully.";
			
			$data['redirect']="site/viewpropertygeolocation?id=".$property;
			$this->load->view("redirect",$data);
		}
	}
    
    function editpropertygeolocation()
	{
		$access = array("1");
		$this->checkaccess($access);
        $propertyid=$this->input->get('id');
        $data['propertyid']=$propertyid;
        $propertygeolocationid=$this->input->get('propertygeolocationid');
		$data['before']=$this->propertygeolocation_model->beforeedit($this->input->get('propertygeolocationid'));
        $data['property']=$this->propertygeolocation_model->getpropertydropdown();
		$data['page']='editpropertygeolocation';
		$data['title']='Edit propertygeolocation';
		$this->load->view('template',$data);
	}
	function editpropertygeolocationsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
        
		$this->form_validation->set_rules('property','property','trim|required');
		$this->form_validation->set_rules('lat','lat','trim|required');
		$this->form_validation->set_rules('long','long','trim|required');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $propertyid=$this->input->post('property');
            $propertygeolocationid=$this->input->post('propertygeolocationid');
            $data['propertyid']=$propertyid;
			$data['before']=$this->propertygeolocation_model->beforeedit($this->input->post('propertygeolocationid'));
            $data['property']=$this->propertygeolocation_model->getpropertydropdown();
			$data['page']='editpropertygeolocation';
			$data['title']='Edit propertygeolocation';
			$this->load->view('template',$data);
		}
		else
		{
            
			$id=$this->input->post('propertygeolocationid');
            $property=$this->input->post('property');
            $lat=$this->input->post('lat');
            $long=$this->input->post('long');
            
			if($this->propertygeolocation_model->edit($id,$property,$lat,$long)==0)
			$data['alerterror']="propertygeolocation Editing was unsuccesful";
			else
			$data['alertsuccess']="propertygeolocation edited Successfully.";
			
			$data['redirect']="site/viewpropertygeolocation?id=".$property;
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletepropertygeolocation()
	{
		$access = array("1");
		$this->checkaccess($access);
        $propertyid=$this->input->get('id');
        $propertygeolocationid=$this->input->get('propertygeolocationid');
		$this->propertygeolocation_model->deletepropertygeolocation($this->input->get('propertygeolocationid'));
		$data['alertsuccess']="propertygeolocation Deleted Successfully";
		$data['redirect']="site/viewpropertygeolocation?id=".$propertyid;
		$this->load->view("redirect",$data);
	}
    
    //propertyenquiry
    
    function viewpropertyenquiry()
	{
		$access = array("1");
		$this->checkaccess($access);
        $propertyid=$this->input->get('id');
		$data['before']=$this->property_model->beforeedit($propertyid);
		$data['table']=$this->propertyenquiry_model->viewpropertyenquirybyproperty($propertyid);
		$data['page']='viewpropertyenquiry';
		$data['page2']='block/propertyblock';
        $data['title']='View property Image';
		$this->load->view('templatewith2',$data);
	}
    
    
    
    public function createpropertyenquiry()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createpropertyenquiry';
		$data[ 'title' ] = 'Create propertyenquiry';
		$data['user']=$this->user_model->getuserdropdown();
		$data[ 'propertyid' ] = $this->input->get('id');
		$this->load->view( 'template', $data );	
	}
    function createpropertyenquirysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('property','property','trim|required');
		$this->form_validation->set_rules('message','message','trim');
		$this->form_validation->set_rules('user','user','trim');
		$this->form_validation->set_rules('contact','contact','trim');
		$this->form_validation->set_rules('email','email','trim');

		if($this->form_validation->run() == FALSE)	
		{
            
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createpropertyenquiry';
            $data[ 'title' ] = 'Create propertyenquiry';
            $data['user']=$this->user_model->getuserdropdown();
            $data[ 'propertyid' ] = $this->input->get_post('id');
            $this->load->view( 'template', $data );	
		}
		else
		{
			$property=$this->input->post('property');
			$message=$this->input->post('message');
			$user=$this->input->post('user');
			$contact=$this->input->post('contact');
			$email=$this->input->post('email');
           
            
            if($this->propertyenquiry_model->create($property,$message,$user,$contact,$email)==0)
               $data['alerterror']="New propertyenquiry could not be created.";
            else
               $data['alertsuccess']="propertyenquiry created Successfully.";
			
			$data['redirect']="site/viewpropertyenquiry?id=".$property;
			$this->load->view("redirect",$data);
		}
	}
    
    function editpropertyenquiry()
	{
		$access = array("1");
		$this->checkaccess($access);
        $propertyid=$this->input->get('id');
        $data['propertyid']=$propertyid;
        $propertyenquiryid=$this->input->get('propertyenquiryid');
		$data['user']=$this->user_model->getuserdropdown();
		$data['before']=$this->propertyenquiry_model->beforeedit($this->input->get('propertyenquiryid'));
        $data['property']=$this->propertyenquiry_model->getpropertydropdown();
		$data['page']='editpropertyenquiry';
		$data['title']='Edit propertyenquiry';
		$this->load->view('template',$data);
	}
	function editpropertyenquirysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
        
		$this->form_validation->set_rules('property','property','trim|required');
		$this->form_validation->set_rules('message','message','trim');
		$this->form_validation->set_rules('user','user','trim');
		$this->form_validation->set_rules('contact','contact','trim');
		$this->form_validation->set_rules('email','email','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $propertyid=$this->input->post('property');
            $propertyenquiryid=$this->input->post('propertyenquiryid');
            $data['propertyid']=$propertyid;
            $data['user']=$this->user_model->getuserdropdown();
			$data['before']=$this->propertyenquiry_model->beforeedit($this->input->post('propertyenquiryid'));
            $data['property']=$this->propertyenquiry_model->getpropertydropdown();
			$data['page']='editpropertyenquiry';
			$data['title']='Edit propertyenquiry';
			$this->load->view('template',$data);
		}
		else
		{
            
			$id=$this->input->post('propertyenquiryid');
            $property=$this->input->post('property');
			$message=$this->input->post('message');
			$user=$this->input->post('user');
			$contact=$this->input->post('contact');
			$email=$this->input->post('email');
            
			if($this->propertyenquiry_model->edit($id,$property,$message,$user,$contact,$email)==0)
			$data['alerterror']="propertyenquiry Editing was unsuccesful";
			else
			$data['alertsuccess']="propertyenquiry edited Successfully.";
			
			$data['redirect']="site/viewpropertyenquiry?id=".$property;
			$this->load->view("redirect",$data);
			
		}
	}
    
	function deletepropertyenquiry()
	{
		$access = array("1");
		$this->checkaccess($access);
        $propertyid=$this->input->get('id');
        $propertyenquiryid=$this->input->get('propertyenquiryid');
		$this->propertyenquiry_model->deletepropertyenquiry($this->input->get('propertyenquiryid'));
		$data['alertsuccess']="propertyenquiry Deleted Successfully";
		$data['redirect']="site/viewpropertyenquiry?id=".$propertyid;
		$this->load->view("redirect",$data);
	}
    
    //amenity
    function viewtestimonial()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewtestimonial';
        $data['base_url'] = site_url("site/viewtestimonialjson");
        
		$data['title']='View testimonial';
		$this->load->view('template',$data);
	} 
    function viewtestimonialjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`testimonial`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
//        $elements[1]=new stdClass();
//        $elements[1]->field="`testimonial`.`name`";
//        $elements[1]->sort="1";
//        $elements[1]->header="Name";
//        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`testimonial`.`user`";
        $elements[2]->sort="1";
        $elements[2]->header="User";
        $elements[2]->alias="user";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`testimonial`.`testimonial`";
        $elements[3]->sort="1";
        $elements[3]->header="testimonial";
        $elements[3]->alias="testimonial";
        
        
        $elements[4]=new stdClass();
        $elements[4]->field="`user`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="Username";
        $elements[4]->alias="username";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `testimonial` LEFT OUTER JOIN `user` ON `testimonial`.`user`=`user`.`id`");
        
		$this->load->view("json",$data);
	} 
    
    public function createtestimonial()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createtestimonial';
		$data[ 'title' ] = 'Create testimonial';
		$data[ 'user' ] = $this->user_model->getuserdropdown();
		$this->load->view( 'template', $data );	
	}
	function createtestimonialsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('user','User','trim|required');
		$this->form_validation->set_rules('testimonial','Testimonial','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createtestimonial';
            $data[ 'title' ] = 'Create testimonial';
            $data[ 'user' ] = $this->user_model->getuserdropdown();
            $this->load->view( 'template', $data );	
		}
		else
		{
            $user=$this->input->post('user');
            $testimonial=$this->input->post('testimonial');
            
			if($this->testimonial_model->create($user,$testimonial)==0)
			$data['alerterror']="New testimonial could not be created.";
			else
			$data['alertsuccess']="testimonial created Successfully.";
			$data['redirect']="site/viewtestimonial";
			$this->load->view("redirect",$data);
		}
	}
    
	function edittestimonial()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='edittestimonial';
		$data['title']='Edit testimonial';
		$data[ 'user' ] = $this->user_model->getuserdropdown();
		$data['before']=$this->testimonial_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function edittestimonialsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('user','User','trim|required');
		$this->form_validation->set_rules('testimonial','Testimonial','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='edittestimonial';
            $data[ 'user' ] = $this->user_model->getuserdropdown();
            $data['before']=$this->testimonial_model->beforeedit($this->input->get('id'));
			$data['title']='Edit testimonial';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $user=$this->input->get_post('user');
            $testimonial=$this->input->get_post('testimonial');
            
			if($this->testimonial_model->edit($id,$user,$testimonial)==0)
			$data['alerterror']="testimonial Editing was unsuccesful";
			else
			$data['alertsuccess']="testimonial edited Successfully.";
			
			$data['redirect']="site/viewtestimonial";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletetestimonial()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->testimonial_model->deletetestimonial($this->input->get('id'));
		$data['alertsuccess']="testimonial Deleted Successfully";
		$data['redirect']="site/viewtestimonial";
		$this->load->view("redirect",$data);
	}
    
    //config
    function viewconfig()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewconfig';
        $data['base_url'] = site_url("site/viewconfigjson");
        
		$data['title']='View config';
		$this->load->view('template',$data);
	} 
    function viewconfigjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`config`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`config`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`config`.`text`";
        $elements[2]->sort="1";
        $elements[2]->header="Text";
        $elements[2]->alias="text";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `config` ");
        
		$this->load->view("json",$data);
	} 
    
    public function createconfig()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createconfig';
		$data[ 'title' ] = 'Create config';
		$this->load->view( 'template', $data );	
	}
	function createconfigsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','name','trim|required');
		$this->form_validation->set_rules('text','text','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createconfig';
            $data[ 'title' ] = 'Create config';
            $data[ 'user' ] = $this->user_model->getuserdropdown();
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $text=$this->input->post('text');
            
			if($this->config_model->create($name,$text)==0)
			$data['alerterror']="New config could not be created.";
			else
			$data['alertsuccess']="config created Successfully.";
			$data['redirect']="site/viewconfig";
			$this->load->view("redirect",$data);
		}
	}
    
	function editconfig()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editconfig';
		$data['title']='Edit config';
		$data['before']=$this->config_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editconfigsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','name','trim|required');
		$this->form_validation->set_rules('text','text','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editconfig';
            $data['before']=$this->config_model->beforeedit($this->input->get('id'));
			$data['title']='Edit config';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $text=$this->input->get_post('text');
            
			if($this->config_model->edit($id,$name,$text)==0)
			$data['alerterror']="config Editing was unsuccesful";
			else
			$data['alertsuccess']="config edited Successfully.";
			
			$data['redirect']="site/viewconfig";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteconfig()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->config_model->deleteconfig($this->input->get('id'));
		$data['alertsuccess']="config Deleted Successfully";
		$data['redirect']="site/viewconfig";
		$this->load->view("redirect",$data);
	}
    //video
    function viewvideo()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewvideo';
        $data['base_url'] = site_url("site/viewvideojson");
        
		$data['title']='View video';
		$this->load->view('template',$data);
	} 
    function viewvideojson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`video`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`video`.`title`";
        $elements[1]->sort="1";
        $elements[1]->header="Title";
        $elements[1]->alias="title";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`video`.`video`";
        $elements[2]->sort="1";
        $elements[2]->header="video";
        $elements[2]->alias="video";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `video` ");
        
		$this->load->view("json",$data);
	} 
    
    public function createvideo()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createvideo';
		$data[ 'title' ] = 'Create video';
		$this->load->view( 'template', $data );	
	}
	function createvideosubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('title','title','trim|required');
		$this->form_validation->set_rules('video','video','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createvideo';
            $data[ 'title' ] = 'Create video';
            $data[ 'user' ] = $this->user_model->getuserdropdown();
            $this->load->view( 'template', $data );	
		}
		else
		{
            $title=$this->input->post('title');
            $video=$this->input->post('video');
            
			if($this->video_model->create($title,$video)==0)
			$data['alerterror']="New video could not be created.";
			else
			$data['alertsuccess']="video created Successfully.";
			$data['redirect']="site/viewvideo";
			$this->load->view("redirect",$data);
		}
	}
    
	function editvideo()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editvideo';
		$data['title']='Edit video';
		$data['before']=$this->video_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editvideosubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('title','title','trim|required');
		$this->form_validation->set_rules('video','video','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editvideo';
            $data['before']=$this->video_model->beforeedit($this->input->get('id'));
			$data['title']='Edit video';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $title=$this->input->get_post('title');
            $video=$this->input->get_post('video');
            
			if($this->video_model->edit($id,$title,$video)==0)
			$data['alerterror']="video Editing was unsuccesful";
			else
			$data['alertsuccess']="video edited Successfully.";
			
			$data['redirect']="site/viewvideo";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletevideo()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->video_model->deletevideo($this->input->get('id'));
		$data['alertsuccess']="video Deleted Successfully";
		$data['redirect']="site/viewvideo";
		$this->load->view("redirect",$data);
	}
    
    //servicetype
    function viewservicetype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewservicetype';
        $data['base_url'] = site_url("site/viewservicetypejson");
        
		$data['title']='View servicetype';
		$this->load->view('template',$data);
	} 
    function viewservicetypejson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`servicetype`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`servicetype`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `servicetype`");
        
		$this->load->view("json",$data);
	} 
    
    public function createservicetype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createservicetype';
		$data[ 'title' ] = 'Create servicetype';
		$this->load->view( 'template', $data );	
	}
	function createservicetypesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createservicetype';
            $data[ 'title' ] = 'Create servicetype';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            
			if($this->servicetype_model->create($name)==0)
			$data['alerterror']="New servicetype could not be created.";
			else
			$data['alertsuccess']="servicetype created Successfully.";
			$data['redirect']="site/viewservicetype";
			$this->load->view("redirect",$data);
		}
	}
    
	function editservicetype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editservicetype';
		$data['title']='Edit servicetype';
		$data['before']=$this->servicetype_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editservicetypesubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editservicetype';
            $data['before']=$this->servicetype_model->beforeedit($this->input->get('id'));
			$data['title']='Edit servicetype';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            
			if($this->servicetype_model->edit($id,$name)==0)
			$data['alerterror']="servicetype Editing was unsuccesful";
			else
			$data['alertsuccess']="servicetype edited Successfully.";
			
			$data['redirect']="site/viewservicetype";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteservicetype()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->servicetype_model->deleteservicetype($this->input->get('id'));
		$data['alertsuccess']="servicetype Deleted Successfully";
		$data['redirect']="site/viewservicetype";
		$this->load->view("redirect",$data);
	}
    //serviceprovider
    function viewserviceprovider()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewserviceprovider';
        $data['base_url'] = site_url("site/viewserviceproviderjson");
        
		$data['title']='View serviceprovider';
		$this->load->view('template',$data);
	} 
    function viewserviceproviderjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`serviceprovider`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`serviceprovider`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`area`.`name`";
        $elements[2]->sort="1";
        $elements[2]->header="Area";
        $elements[2]->alias="area";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`serviceprovider`.`rate`";
        $elements[3]->sort="1";
        $elements[3]->header="Rate";
        $elements[3]->alias="rate";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`servicetype`.`name`";
        $elements[4]->sort="1";
        $elements[4]->header="servicetypename";
        $elements[4]->alias="servicetypename";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`serviceprovider`.`contact`";
        $elements[5]->sort="1";
        $elements[5]->header="contact";
        $elements[5]->alias="contact";
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `serviceprovider` LEFT OUTER JOIN `servicetype` ON `servicetype`.`id`=`serviceprovider`.`servicetype` LEFT OUTER JOIN `area` ON `area`.`id`=`serviceprovider`.`area`");
        
		$this->load->view("json",$data);
	} 

    
//    public function createserviceprovider()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
//        $data['servicetype']=$this->servicetype_model->getservicetypedropdown();
//        $data['area']=$this->area_model->getareadropdown();
//        $data['day']=$this->servicetype_model->getdaydropdown();
//		$data[ 'page' ] = 'createserviceprovider';
//		$data[ 'title' ] = 'Create serviceprovider';
//		$this->load->view( 'template', $data );	
//	}
//	function createserviceprovidersubmit()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
//		$this->form_validation->set_rules('name','Name','trim|required');
//		$this->form_validation->set_rules('contact','contact','trim');
//		$this->form_validation->set_rules('area','area','trim');
//		$this->form_validation->set_rules('rate','rate','trim');
//		$this->form_validation->set_rules('servicetype','servicetype','trim');
//		if($this->form_validation->run() == FALSE)	
//		{
//			$data['alerterror'] = validation_errors();
//            $data['servicetype']=$this->servicetype_model->getservicetypedropdown();
//            $data['area']=$this->area_model->getareadropdown();
//            $data['day']=$this->servicetype_model->getdaydropdown();
//            $data[ 'page' ] = 'createserviceprovider';
//            $data[ 'title' ] = 'Create serviceprovider';
//            $this->load->view( 'template', $data );	
//		}
//		else
//		{
//            $name=$this->input->post('name');
//            $contact=$this->input->post('contact');
//            $area=$this->input->post('area');
//            $rate=$this->input->post('rate');
//            $servicetype=$this->input->post('servicetype');
//            $day=$this->input->post('day');
//            
//			if($this->serviceprovider_model->create($name,$contact,$area,$rate,$servicetype,$day)==0)
//			$data['alerterror']="New serviceprovider could not be created.";
//			else
//			$data['alertsuccess']="serviceprovider created Successfully.";
//			$data['redirect']="site/viewserviceprovider";
//			$this->load->view("redirect",$data);
//		}
//	}
    
//	function editserviceprovider()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
//        $data['servicetype']=$this->servicetype_model->getservicetypedropdown();
//        $data['day']=$this->servicetype_model->getdaydropdown();
//        $data['area']=$this->area_model->getareadropdown();
//        $data['selectedday']=$this->serviceprovider_model->getdaybyserviceprovider($this->input->get_post('id'));
//		$data['page']='editserviceprovider';
//		$data['title']='Edit serviceprovider';
//		$data['before']=$this->serviceprovider_model->beforeedit($this->input->get('id'));
//		$this->load->view('template',$data);
//	}
//	function editserviceprovidersubmit()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
//		
//		$this->form_validation->set_rules('name','Name','trim|required');
//		$this->form_validation->set_rules('contact','contact','trim');
//		$this->form_validation->set_rules('area','area','trim');
//		$this->form_validation->set_rules('rate','rate','trim');
//		$this->form_validation->set_rules('servicetype','servicetype','trim');
//        
//		if($this->form_validation->run() == FALSE)	
//		{
//			$data['alerterror'] = validation_errors();
//			$data['page']='editserviceprovider';
//            $data['servicetype']=$this->servicetype_model->getservicetypedropdown();
//            $data['day']=$this->servicetype_model->getdaydropdown();
//            $data['area']=$this->area_model->getareadropdown();
//            $data['selectedday']=$this->serviceprovider_model->getdaybyserviceprovider($this->input->get_post('id'));
//            $data['before']=$this->serviceprovider_model->beforeedit($this->input->get_post('id'));
//			$data['title']='Edit serviceprovider';
//			$this->load->view('template',$data);
//		}
//		else
//		{
//            
//            $id=$this->input->get_post('id');
//            $name=$this->input->post('name');
//            $contact=$this->input->post('contact');
//            $area=$this->input->post('area');
//            $rate=$this->input->post('rate');
//            $servicetype=$this->input->post('servicetype');
//            $day=$this->input->post('day');
//            
//			if($this->serviceprovider_model->edit($id,$name,$contact,$area,$rate,$servicetype,$day)==0)
//			$data['alerterror']="serviceprovider Editing was unsuccesful";
//			else
//			$data['alertsuccess']="serviceprovider edited Successfully.";
//			
//			$data['redirect']="site/viewserviceprovider";
//			//$data['other']="template=$template";
//			$this->load->view("redirect",$data);
//			
//		}
//	}
	
//	function deleteserviceprovider()
//	{
//		$access = array("1");
//		$this->checkaccess($access);
//		$this->serviceprovider_model->deleteserviceprovider($this->input->get('id'));
//		$data['alertsuccess']="serviceprovider Deleted Successfully";
//		$data['redirect']="site/viewserviceprovider";
//		$this->load->view("redirect",$data);
//	}
    

    
    public function createserviceprovider()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['servicetype']=$this->servicetype_model->getservicetypedropdown();
        $data['area']=$this->area_model->getareadropdown();
        $data['day']=$this->servicetype_model->getdaydropdown();
		$data[ 'page' ] = 'createserviceprovider';
		$data[ 'title' ] = 'Create serviceprovider';
		$this->load->view( 'template', $data );	
	}
	function createserviceprovidersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('contact','contact','trim');
		$this->form_validation->set_rules('area','area','trim');
		$this->form_validation->set_rules('rate','rate','trim');
		$this->form_validation->set_rules('servicetype','servicetype','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data['servicetype']=$this->servicetype_model->getservicetypedropdown();
            $data['area']=$this->area_model->getareadropdown();
            $data['day']=$this->servicetype_model->getdaydropdown();
            $data[ 'page' ] = 'createserviceprovider';
            $data[ 'title' ] = 'Create serviceprovider';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $contact=$this->input->post('contact');
            $area=$this->input->post('area');
            $rate=$this->input->post('rate');
            $servicetype=$this->input->post('servicetype');
            $day=$this->input->post('day');
            
			if($this->serviceprovider_model->create($name,$contact,$area,$rate,$servicetype,$day)==0)
			$data['alerterror']="New serviceprovider could not be created.";
			else
			$data['alertsuccess']="serviceprovider created Successfully.";
			$data['redirect']="site/viewserviceprovider";
			$this->load->view("redirect",$data);
		}
	}
    
	function editserviceprovider()
	{
		$access = array("1");
		$this->checkaccess($access);
        $data['servicetype']=$this->servicetype_model->getservicetypedropdown();
        $data['day']=$this->servicetype_model->getdaydropdown();
        $data['area']=$this->area_model->getareadropdown();
        $data['selectedday']=$this->serviceprovider_model->getdaybyserviceprovider($this->input->get_post('id'));
		$data['page']='editserviceprovider';
		$data['title']='Edit serviceprovider';
		$data['before']=$this->serviceprovider_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editserviceprovidersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('contact','contact','trim');
		$this->form_validation->set_rules('area','area','trim');
		$this->form_validation->set_rules('rate','rate','trim');
		$this->form_validation->set_rules('servicetype','servicetype','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editserviceprovider';
            $data['servicetype']=$this->servicetype_model->getservicetypedropdown();
            $data['day']=$this->servicetype_model->getdaydropdown();
            $data['area']=$this->area_model->getareadropdown();
            $data['selectedday']=$this->serviceprovider_model->getdaybyserviceprovider($this->input->get_post('id'));
            $data['before']=$this->serviceprovider_model->beforeedit($this->input->get_post('id'));
			$data['title']='Edit serviceprovider';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->post('name');
            $contact=$this->input->post('contact');
            $area=$this->input->post('area');
            $rate=$this->input->post('rate');
            $servicetype=$this->input->post('servicetype');
            $day=$this->input->post('day');
            
			if($this->serviceprovider_model->edit($id,$name,$contact,$area,$rate,$servicetype,$day)==0)
			$data['alerterror']="serviceprovider Editing was unsuccesful";
			else
			$data['alertsuccess']="serviceprovider edited Successfully.";
			
			$data['redirect']="site/viewserviceprovider";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteserviceprovider()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->serviceprovider_model->deleteserviceprovider($this->input->get('id'));
		$data['alertsuccess']="serviceprovider Deleted Successfully";
		$data['redirect']="site/viewserviceprovider";
		$this->load->view("redirect",$data);
	}
    
    //area
    function viewarea()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewarea';
        $data['base_url'] = site_url("site/viewareajson");
        
		$data['title']='View area';
		$this->load->view('template',$data);
	} 
    function viewareajson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`area`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`area`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `area`");
        
		$this->load->view("json",$data);
	} 
    
    public function createarea()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createarea';
		$data[ 'title' ] = 'Create area';
		$this->load->view( 'template', $data );	
	}
	function createareasubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createarea';
            $data[ 'title' ] = 'Create area';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            
			if($this->area_model->create($name)==0)
			$data['alerterror']="New area could not be created.";
			else
			$data['alertsuccess']="area created Successfully.";
			$data['redirect']="site/viewarea";
			$this->load->view("redirect",$data);
		}
	}
    
	function editarea()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editarea';
		$data['title']='Edit area';
		$data['before']=$this->area_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editareasubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('name','Name','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editarea';
            $data['before']=$this->area_model->beforeedit($this->input->get('id'));
			$data['title']='Edit area';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            
			if($this->area_model->edit($id,$name)==0)
			$data['alerterror']="area Editing was unsuccesful";
			else
			$data['alertsuccess']="area edited Successfully.";
			
			$data['redirect']="site/viewarea";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletearea()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->area_model->deletearea($this->input->get('id'));
		$data['alertsuccess']="area Deleted Successfully";
		$data['redirect']="site/viewarea";
		$this->load->view("redirect",$data);
	}
    
    
    //news
    function viewnews()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewnews';
        $data['base_url'] = site_url("site/viewnewsjson");
        
		$data['title']='View news';
		$this->load->view('template',$data);
	} 
    function viewnewsjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`news`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`news`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`news`.`text`";
        $elements[2]->sort="1";
        $elements[2]->header="text";
        $elements[2]->alias="text";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`news`.`image`";
        $elements[3]->sort="1";
        $elements[3]->header="image";
        $elements[3]->alias="image";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`news`.`date`";
        $elements[4]->sort="1";
        $elements[4]->header="date";
        $elements[4]->alias="date";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`news`.`timestamp`";
        $elements[5]->sort="1";
        $elements[5]->header="timestamp";
        $elements[5]->alias="timestamp";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `news`");
        
		$this->load->view("json",$data);
	} 
    
    public function createnews()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createnews';
		$data[ 'title' ] = 'Create news';
		$this->load->view( 'template', $data );	
	}
	function createnewssubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('text','text','trim');
		$this->form_validation->set_rules('date','date_parse','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createnews';
            $data[ 'title' ] = 'Create news';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $text=$this->input->post('text');
            $date=$this->input->post('date');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
			if($this->news_model->create($name,$text,$date,$image)==0)
			$data['alerterror']="New news could not be created.";
			else
			$data['alertsuccess']="news created Successfully.";
			$data['redirect']="site/viewnews";
			$this->load->view("redirect",$data);
		}
	}
    
	function editnews()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editnews';
		$data['title']='Edit news';
		$data['before']=$this->news_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editnewssubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('text','text','trim');
		$this->form_validation->set_rules('date','date_parse','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editnews';
            $data['before']=$this->news_model->beforeedit($this->input->get('id'));
			$data['title']='Edit news';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->post('name');
            $text=$this->input->post('text');
            $date=$this->input->post('date');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
            if($image=="")
            {
                $image=$this->news_model->getnewsimagebyid($id);
                $image=$image->image;
            }
            
			if($this->news_model->edit($id,$name,$text,$date,$image)==0)
			$data['alerterror']="news Editing was unsuccesful";
			else
			$data['alertsuccess']="news edited Successfully.";
			
			$data['redirect']="site/viewnews";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletenews()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->news_model->deletenews($this->input->get('id'));
		$data['alertsuccess']="news Deleted Successfully";
		$data['redirect']="site/viewnews";
		$this->load->view("redirect",$data);
	}
    
    //blog
    function viewblog()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewblog';
        $data['base_url'] = site_url("site/viewblogjson");
        
		$data['title']='View blog';
		$this->load->view('template',$data);
	} 
    function viewblogjson()
	{
		$access = array("1");
		$this->checkaccess($access);
        
        
        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`blog`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";
        
        
        $elements[1]=new stdClass();
        $elements[1]->field="`blog`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";
        
        $elements[2]=new stdClass();
        $elements[2]->field="`blog`.`text`";
        $elements[2]->sort="1";
        $elements[2]->header="text";
        $elements[2]->alias="text";
        
        $elements[3]=new stdClass();
        $elements[3]->field="`blog`.`image`";
        $elements[3]->sort="1";
        $elements[3]->header="image";
        $elements[3]->alias="image";
        
        $elements[4]=new stdClass();
        $elements[4]->field="`blog`.`date`";
        $elements[4]->sort="1";
        $elements[4]->header="date";
        $elements[4]->alias="date";
        
        $elements[5]=new stdClass();
        $elements[5]->field="`blog`.`timestamp`";
        $elements[5]->sort="1";
        $elements[5]->header="timestamp";
        $elements[5]->alias="timestamp";
        
        
        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }
        
        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }
       
        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `blog`");
        
		$this->load->view("json",$data);
	} 
    
    public function createblog()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createblog';
		$data[ 'title' ] = 'Create blog';
		$this->load->view( 'template', $data );	
	}
	function createblogsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('text','text','trim');
		$this->form_validation->set_rules('date','date_parse','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
            $data[ 'page' ] = 'createblog';
            $data[ 'title' ] = 'Create blog';
            $this->load->view( 'template', $data );	
		}
		else
		{
            $name=$this->input->post('name');
            $text=$this->input->post('text');
            $date=$this->input->post('date');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
			if($this->blog_model->create($name,$text,$date,$image)==0)
			$data['alerterror']="New blog could not be created.";
			else
			$data['alertsuccess']="blog created Successfully.";
			$data['redirect']="site/viewblog";
			$this->load->view("redirect",$data);
		}
	}
    
	function editblog()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='editblog';
		$data['title']='Edit blog';
		$data['before']=$this->blog_model->beforeedit($this->input->get('id'));
		$this->load->view('template',$data);
	}
	function editblogsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('text','text','trim');
		$this->form_validation->set_rules('date','date_parse','trim');
        
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='editblog';
            $data['before']=$this->blog_model->beforeedit($this->input->get('id'));
			$data['title']='Edit blog';
			$this->load->view('template',$data);
		}
		else
		{
            
            $id=$this->input->get_post('id');
            $name=$this->input->post('name');
            $text=$this->input->post('text');
            $date=$this->input->post('date');
            
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];
                
                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r); 
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                }  
                else
                {
                    $image=$this->image_lib->dest_image;
                }
                
			}
            
            if($image=="")
            {
                $image=$this->blog_model->getblogimagebyid($id);
                $image=$image->image;
            }
            
			if($this->blog_model->edit($id,$name,$text,$date,$image)==0)
			$data['alerterror']="blog Editing was unsuccesful";
			else
			$data['alertsuccess']="blog edited Successfully.";
			
			$data['redirect']="site/viewblog";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteblog()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->blog_model->deleteblog($this->input->get('id'));
		$data['alertsuccess']="blog Deleted Successfully";
		$data['redirect']="site/viewblog";
		$this->load->view("redirect",$data);
	}
    
    
}
?>