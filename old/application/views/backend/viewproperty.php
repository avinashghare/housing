<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createproperty'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Property Details
            </header>
			<div class="drawchintantable">
                <?php $this->chintantable->createsearch("Property List");?>
                <table class="table table-striped table-hover" id="" cellpadding="0" cellspacing="0" >
                <thead>
                    <tr>
                        <th data-field="id">Id</th>
                        <th data-field="name">Name</th>
                        <th data-field="email">Email</th>
                        <th data-field="categoryname">Category</th>
                        <th data-field="buildername">Builder</th>
                        <th data-field="price">Price</th>
                        <th data-field="bhk">BHK</th>
                        <th data-field="action"> Actions </th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
                </table>
                   <?php $this->chintantable->createpagination();?>
            </div>
		</section>
		<script>
            function drawtable(resultrow) {
                if(!resultrow.name)
                {
                    resultrow.name="";
                }
                if(!resultrow.email)
                {
                    resultrow.email="";
                }
                if(!resultrow.price)
                {
                    resultrow.price="";
                }
                if(!resultrow.bhk)
                {
                    resultrow.bhk="";
                }
                return "<tr><td>" + resultrow.id + "</td><td>" + resultrow.name + "</td><td>" + resultrow.email + "</td><td>" + resultrow.categoryname + "</td><td>" + resultrow.buildername + "</td><td>" + resultrow.price + "</td><td>" + resultrow.bhk + "</td><td><a class='btn btn-primary btn-xs' href='<?php echo site_url('site/editproperty?id=');?>"+resultrow.id +"'><i class='icon-pencil'></i></a><a class='btn btn-danger btn-xs' href='<?php echo site_url('site/deleteproperty?id='); ?>"+resultrow.id +"'><i class='icon-trash '></i></a></td><tr>";
            }
            generatejquery('<?php echo $base_url;?>');
        </script>
	</div>
</div>
