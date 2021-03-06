<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewproperty'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Property Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createpropertysubmit');?>" enctype= "multipart/form-data">
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Email</label>
				  <div class="col-sm-4">
					<input type="email" id="normal-field" class="form-control" name="email" value="<?php echo set_value('email');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select category</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('category',$category,set_value('category'),'id="categoryid" class="chzn-select form-control" 	data-placeholder="Choose a category..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select builder</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('builder',$builder,set_value('builder'),'id="builderid" class="chzn-select form-control" 	data-placeholder="Choose a builder..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select listingowner</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('listingowner',$listingowner,set_value('listingowner'),'id="listingownerid" class="chzn-select form-control" 	data-placeholder="Choose a listingowner..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Price</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="price" value="<?php echo set_value('price');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Leasetype</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('leasetype',$leasetype,set_value('leasetype'),'id="leasetypeid" class="chzn-select form-control" 	data-placeholder="Choose a leasetype..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Listed by</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('listedby',$listedby,set_value('listedby'),'id="listedbyid" class="chzn-select form-control" 	data-placeholder="Choose a listedby..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Furnishing</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('furnishing',$furnishing,set_value('furnishing'),'id="furnishingid" class="chzn-select form-control" 	data-placeholder="Choose a furnishing..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Propertytype</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('propertytype',$propertytype,set_value('propertytype'),'id="propertytypeid" class="chzn-select form-control" 	data-placeholder="Choose a propertytype..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Is New</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('isnew',$isnew,set_value('isnew'),'id="isnewid" class="chzn-select form-control" 	data-placeholder="Choose a isnew..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select bathroom</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('bathroom',$bathroom,set_value('bathroom'),'id="bathroomid" class="chzn-select form-control" 	data-placeholder="Choose a bathroom..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select negotiable</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('negotiable',$negotiable,set_value('negotiable'),'id="negotiableid" class="chzn-select form-control" 	data-placeholder="Choose a negotiable..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Security Deposite</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="securitydeposite" value="<?php echo set_value('securitydeposite');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select BHK</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('bhk',$bhk,set_value('bhk'),'id="bhkid" class="chzn-select form-control" 	data-placeholder="Choose a bhk..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Address1</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="address1" value="<?php echo set_value('address1');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Address2</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="address2" value="<?php echo set_value('address2');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Locality</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="locality" value="<?php echo set_value('locality');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">City</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="city" value="<?php echo set_value('city');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Pincode</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="pincode" value="<?php echo set_value('pincode');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Builduparea</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="builduparea" value="<?php echo set_value('builduparea');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Carpetarea</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="carpetarea" value="<?php echo set_value('carpetarea');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Facing</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="facing" value="<?php echo set_value('facing');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Power Backup</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="powerbackup" value="<?php echo set_value('powerbackup');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Verified</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('verified',$verified,set_value('verified'),'id="verifiedid" class="chzn-select form-control" 	data-placeholder="Choose a verified..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Status</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('status',$status,set_value('status'),'id="statusid" class="chzn-select form-control" 	data-placeholder="Choose a status..."');
					?>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Report Message</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="reportmessage" value="<?php echo set_value('reportmessage');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Commite Score</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="commitescore" value="<?php echo set_value('commitescore');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Locality Score</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="localityscore" value="<?php echo set_value('localityscore');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Society Score</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="societyscore" value="<?php echo set_value('societyscore');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Possesion</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="possesion" value="<?php echo set_value('possesion');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Aerial View</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="aerialview" value="<?php echo set_value('aerialview');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Insights</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="insights" value="<?php echo set_value('insights');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Price Trends</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="pricetrends" value="<?php echo set_value('pricetrends');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Year Of Establishment</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="yearofestablishment" value="<?php echo set_value('yearofestablishment');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Total Projects</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="totalproject" value="<?php echo set_value('totalproject');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Associate Membership</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="associatemembership" value="<?php echo set_value('associatemembership');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Interior</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="interior" value="<?php echo set_value('interior');?>">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">3Dfloorplan</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="threedfloorplan" value="<?php echo set_value('threedfloorplan');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">2Dfloorplan</label>
				  <div class="col-sm-4">
					<input type="file" id="normal-field" class="form-control" name="image" value="<?php echo set_value('image');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Iscommercial</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('iscommercial',$iscommercial,set_value('iscommercial'),'id="iscommercialid" class="chzn-select form-control" 	data-placeholder="Choose a iscommercial..."');
					?>
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Society Facilities</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('societyfacility[]',$societyfacility,set_value('societyfacility'),'id="select2" class="chzn-select form-control" 	data-placeholder="Choose a Society Facility..." multiple');
					?>
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Amenities</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('amenity[]',$amenity,set_value('amenity'),'id="select3" class="chzn-select form-control" 	data-placeholder="Choose an Amenity..." multiple');
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
	</div>
</div>
