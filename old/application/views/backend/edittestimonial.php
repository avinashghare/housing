	    <section class="panel">
		    <header class="panel-heading">
				 Testimonial Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/edittestimonialsubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
				
				<div class=" form-group">
				  <label class="col-sm-2 control-label">Select User</label>
				  <div class="col-sm-4">
					<?php 	 echo form_dropdown('user',$user,set_value('user',$before->user),'id="userid" class="chzn-select form-control" 	data-placeholder="Choose a User..."');
					?>
				  </div>
				</div>
				<div class=" form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Testimonial</label>
                            <div class="col-sm-8">
                                <textarea name="testimonial" id="" cols="20" rows="10" class="form-control tinymce"><?php echo set_value( 'testimonial',$before->testimonial);?></textarea>
                            </div>
                        </div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewtestimonial'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>