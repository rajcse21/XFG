<input name="<?php echo $key; ?>" type="text" class="form-control" id="<?php echo $key; ?>" value="<?php echo set_value("$key", $val); ?>"><?php /*if ($comment) { ?><?php echo $comment; ?><?php } */?>
<?php if ($comment) { ?><small id="emailHelp" class="form-text text-muted"><?php echo $comment; ?></small><?php } ?>	 
	 
