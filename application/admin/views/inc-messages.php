<?php if (function_exists('validation_errors') && validation_errors() != '') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <b>Error(s)</b>:
        <ul>
            <?php echo validation_errors(); ?>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<?php if (isset($INFO) && ($INFO != '')) { ?>
    <div class="info_div">
        <b>Notice</b>:
        <ul>
            <?php echo $INFO; ?>
        </ul>
    </div>
<?php } ?>

<?php if (isset($SUCCESS) && ($SUCCESS != '')) { ?>
    <div class="message_div alert alert-success alert-dismissible fade show">
        <b>Success</b>:
        <ul>
            <?php echo $SUCCESS; ?>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

<?php if (isset($ERROR) && ($ERROR != '')) { ?>
    <div class="error_div">
        <b>Error</b>:
        <ul>
            <?php echo $ERROR; ?>
        </ul>
    </div>
<?php } ?>