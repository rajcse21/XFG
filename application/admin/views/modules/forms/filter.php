<form action="forms/quote/index" method="get">
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-14">
			<div class="form-group">
				<label for="from_date">From Date</label>
				<input type="text" name="from_date" value="<?php echo set_value('from_date', isset($filter['from_date']) ? $filter['from_date'] : ''); ?>" class="date_field form-control">
			</div>		
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-14">
			<div class="form-group">
				<label for="form_name">To Date</label>
				<input type="text" name="to_date" value="<?php echo set_value('to_date', isset($filter['to_date']) ? $filter['to_date'] : ''); ?>" class="date_field form-control">
			</div>		
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-14">
			&nbsp;	
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-14">			
			<button type="submit" class="btn btn-default" style="margin-top: 22px;">Submit</button>
		</div>
	</div>
</form>