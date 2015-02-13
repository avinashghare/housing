<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewserviceprovider'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Service Provider Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createserviceprovidersubmit');?>" enctype= "multipart/form-data">
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="name" value="<?php echo set_value('name');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">contact</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="contact" value="<?php echo set_value('contact');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Area</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('area',$area,set_value('area'),'id="areaid" class="chzn-select form-control" 	data-placeholder="Choose a area..."');
					?>
				  </div>
				</div>
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Area</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="area" value="<?php echo set_value('area');?>">
				  </div>
				</div>
-->
				<div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Rate</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="rate" value="<?php echo set_value('rate');?>">
				  </div>
				</div>
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select Service Type</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('servicetype',$servicetype,set_value('servicetype'),'id="servicetypeid" class="chzn-select form-control" 	data-placeholder="Choose a servicetype..."');
					?>
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Working Days</label>
				  <div class="col-sm-4">
					<?php
						
						echo form_dropdown('day[]',$day,set_value('day'),'id="select2" class="chzn-select form-control" 	data-placeholder="Choose a Society Facility..." multiple');
					?>
				  </div>
				</div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewserviceprovider'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>