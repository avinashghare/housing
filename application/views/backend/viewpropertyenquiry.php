<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createpropertyenquiry?id=').$this->input->get('id'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Property Enquiry Details 
            </header>
			<table class="table table-striped table-hover  fpTable lcnp" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Id</th>
					<th>Property</th>
					<th>Message</th>
					<th>User</th>
					<th>Email</th>
					<th>Contact</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<td><?php echo $row->id;?></td>
						<td><?php echo $row->propertyname;?></td>
						<td><?php echo $row->message;?></td>
						<td><?php echo $row->username;?></td>
						<td><?php echo $row->email;?></td>
						<td><?php echo $row->contact;?></td>
						
						<td>
							<a href="<?php echo site_url('site/editpropertyenquiry?id=').$row->property.'&propertyenquiryid='.$row->id;?>" class="btn btn-primary btn-xs">
								<i class="icon-pencil"></i>
							</a>
							<a href="<?php echo site_url('site/deletepropertyenquiry?id=').$row->property.'&propertyenquiryid='.$row->id; ?>" class="btn btn-danger btn-xs">
								<i class="icon-trash "></i>
							</a> 
							
						</td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
        </div>
	</div>



