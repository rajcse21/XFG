

<textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" rows="5" class="form-control"><?php echo set_value("$key", $val); ?></textarea>
<?php if ($comment) { ?><small id="emailHelp" class="form-text text-muted"><?php echo $comment; ?></small><?php } ?>