	    <section class="panel">
		    <header class="panel-heading">
				 Property Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editpropertysubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name',$before->name);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email',$before->email);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select category</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('category',$category,set_value('category',$before->category),'id="categoryid" class="chzn-select form-control" 	data-placeholder="Choose a category..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select builder</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('builder',$builder,set_value('builder',$before->builder),'id="builderid" class="chzn-select form-control" 	data-placeholder="Choose a builder..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select listingowner</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('listingowner',$listingowner,set_value('listingowner',$before->listingowner),'id="listingownerid" class="chzn-select form-control" 	data-placeholder="Choose a listingowner..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Price</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="price" value="<?php echo set_value('price',$before->price);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Leasetype</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('leasetype',$leasetype,set_value('leasetype',$before->leasetype),'id="leasetypeid" class="chzn-select form-control" 	data-placeholder="Choose a leasetype..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Listed by</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('listedby',$listedby,set_value('listedby',$before->listedby),'id="listedbyid" class="chzn-select form-control" 	data-placeholder="Choose a listedby..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Furnishing</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('furnishing',$furnishing,set_value('furnishing',$before->furnishing),'id="furnishingid" class="chzn-select form-control" 	data-placeholder="Choose a furnishing..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Propertytype</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('propertytype',$propertytype,set_value('propertytype',$before->propertytype),'id="propertytypeid" class="chzn-select form-control" 	data-placeholder="Choose a propertytype..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select bathroom</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('bathroom',$bathroom,set_value('bathroom',$before->bathroom),'id="bathroomid" class="chzn-select form-control" 	data-placeholder="Choose a bathroom..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select negotiable</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('negotiable',$negotiable,set_value('negotiable',$before->negotiable),'id="negotiableid" class="chzn-select form-control" 	data-placeholder="Choose a negotiable..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Security Deposite</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="securitydeposite" value="<?php echo set_value('securitydeposite',$before->securitydeposite);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select BHK</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('bhk',$bhk,set_value('bhk',$before->bhk),'id="bhkid" class="chzn-select form-control" 	data-placeholder="Choose a bhk..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Address1</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="address1" value="<?php echo set_value('address1',$before->address1);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Address2</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="address2" value="<?php echo set_value('address2',$before->address2);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Locality</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="locality" value="<?php echo set_value('locality',$before->locality);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">City</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="city" value="<?php echo set_value('city',$before->city);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Pincode</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="pincode" value="<?php echo set_value('pincode',$before->pincode);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Builduparea</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="builduparea" value="<?php echo set_value('builduparea',$before->builduparea);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Carpetarea</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="carpetarea" value="<?php echo set_value('carpetarea',$before->carpetarea);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Facing</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="facing" value="<?php echo set_value('facing',$before->facing);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Power Backup</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="powerbackup" value="<?php echo set_value('powerbackup',$before->powerbackup);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Verified</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('verified',$verified,set_value('verified',$before->verified),'id="verifiedid" class="chzn-select form-control" 	data-placeholder="Choose a verified..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Status</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('status',$status,set_value('status',$before->status),'id="statusid" class="chzn-select form-control" 	data-placeholder="Choose a status..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Report Message</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="reportmessage" value="<?php echo set_value('reportmessage',$before->reportmessage);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Commite Score</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="commitescore" value="<?php echo set_value('commitescore',$before->commitescore);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Locality Score</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="localityscore" value="<?php echo set_value('localityscore',$before->localityscore);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Society Score</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="societyscore" value="<?php echo set_value('societyscore',$before->societyscore);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Possesion</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="possesion" value="<?php echo set_value('possesion',$before->possesion);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Aerial View</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="aerialview" value="<?php echo set_value('aerialview',$before->aerialview);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Insights</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="insights" value="<?php echo set_value('insights',$before->insights);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Price Trends</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="pricetrends" value="<?php echo set_value('pricetrends',$before->pricetrends);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Year Of Establishment</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="yearofestablishment" value="<?php echo set_value('yearofestablishment',$before->yearofestablishment);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Total Projects</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="totalproject" value="<?php echo set_value('totalproject',$before->totalprojects);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Associate Membership</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="associatemembership" value="<?php echo set_value('associatemembership',$before->associatemembership);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Interior</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="interior" value="<?php echo set_value('interior',$before->interior);?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">3Dfloorplan</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="threedfloorplan" value="<?php echo set_value('threedfloorplan',$before->floorplan3d);?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">2D Floor Plan</label>
				  <div class="col-sm-4">
					<input type="file" id="normal-field" class="form-control" name="image" value="<?php echo set_value('image',$before->floorplan2d);?>">
					<?php if($before->floorplan2d == "")
						 { }
						 else
						 { ?>
							<img src="<?php echo base_url('uploads')."/".$before->floorplan2d; ?>" width="140px" height="140px">
						<?php }
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Iscommercial</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('iscommercial',$iscommercial,set_value('iscommercial',$before->iscommercial),'id="iscommercialid" class="chzn-select form-control" 	data-placeholder="Choose a iscommercial..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Society Facilities</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('societyfacility[]',$societyfacility,$selectedsocietyfacility,'id="select2" class="chzn-select form-control" 	data-placeholder="Choose a Society Facility..." multiple');
					?>
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Amenities</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('amenity[]',$amenity,$selectedamenity,'id="select3" class="chzn-select form-control" 	data-placeholder="Choose an Amenity..." multiple');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewproperty'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>