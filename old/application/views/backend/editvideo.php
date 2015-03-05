	    <section class="panel">
		    <header class="panel-heading">
				 video Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editvideosubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Title</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="title" value="<?php echo set_value('title',$before->title);?>">
				  </div>
				</div>
				<div class=" form-group">
                            <label class="col-sm-2 control-label" for="normal-field">Video Url</label>
                            <div class="col-sm-8">
                                <textarea name="video" id="" cols="20" rows="10" class="form-control tinymce"><?php echo set_value( 'video',$before->video);?></textarea>
                            </div>
                        </div>
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewvideo'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>