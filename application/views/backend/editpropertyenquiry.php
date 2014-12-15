<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Property Geo Location Details
			</header>
			
			<div class="panel-body">
				<form class="form-horizontal row-fluid" method="post" action="<?php echo site_url('site/editpropertyenquirysubmit');?>" enctype= "multipart/form-data">
				
				<div class="form-group" style="display:none">
				  <label class="col-sm-2 control-label" for="normal-field">property</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="property" value="<?php echo set_value('property',$before->property);?>">
					
				  </div>
				</div>
				<div class="form-group" style="display:none">
				  <label class="col-sm-2 control-label" for="normal-field">propertyenquiry</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="propertyenquiryid" value="<?php echo set_value('propertyenquiryid',$before->id);?>">
					
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">User</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('user',$user,set_value('user',$before->user),'id="userid" onchange="operatorcategories()" class="chzn-select form-control" 	data-placeholder="Choose a user..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Message</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="message" value="<?php echo set_value('message',$before->message);?>">
					
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Contact</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contact" value="<?php echo set_value('contact',$before->contact);?>">
					
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email',$before->email);?>">
					
				  </div>
				</div>
				
					<div class="form-group">
						<label class="col-sm-2 control-label">&nbsp;</label>
						<div class="col-sm-4">	
							<button type="submit" class="btn btn-info">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</section>
    </div>
</div>
