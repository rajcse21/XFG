Dropzone.autoDiscover = false;
jQuery(document).ready(function ($) {

    //Sortable Blocks
    if($(".bank-logos").length == 1){
    $(".bank-logos").sortable({
        items: "> .bank-logo",
        placeholder: "col-sm-3 card bg-light",
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            $.post('bank_logo/updateSortOrder', data, function (data) {
            });
        }
    });
    }

    $("div#my-awesome-dropzone").dropzone({
        url: 'bank_logo/file_upload',
        paramName: 'file',
        uploadMultiple: true,
        parallelUploads: 20,
        acceptedFiles: 'image/*',
        previewsContainer: false,
        maxFilesize: 1024,
        timeout: 300000,
        success: function (file, response) {
            $("div.dz-error").html('');
            if (response.status == 1) {
                window.location.reload();
            } else {
                $('div#dz-success').addClass('d-none');
                $('div#dz-error').removeClass('d-none');
                $('div#dz-error').html(response.message);
                //$("div.dz-error").html('<p style="color:red;font-size: 20px;font-weight: bold;">' + response.payload + '</p>');
            }
        },
        sending: function (file, response) {
            $('#dz-error').html('');
            $('#dz-error').addClass('d-none');
            $('#dz-success').html('');
            $('#dz-success').addClass('d-none');
            $("div#my-awesome-dropzone").block({
                message: '<i class="fas fa-spin fas fa-spinner" style="font-size:50px;"></i>Please Wait..',
                overlayCSS: {
                    padding: 0,
                    margin: 0,
                    textAlign: 'center',
                    backgroundColor: '#fff',
                    color: '#000',
                    opacity: 0.7
                },
                css: {
                    border: '0px',
                    //width: '0%',
                    backgroundColor: 'transparent',
                    width: '100%',
                    left: '0px'
                }
            });
        },
        queuecomplete: function () {
            $("div#my-awesome-dropzone").unblock();

            $("div.dz-progress").hide();
            $("div.progress-bar").css("width", "0%");
            $("div.progress-bar").attr("aria-valuenow", 0);
        },
        totaluploadprogress: function (totalBytesSent, totalBytes) {
            $("div.dz-error").html('');
            $("div.asset_error").html('');

            $("div.dz-progress").show();
            $("div.progress-bar").css("width", totalBytesSent + "%");
            $("div.progress-bar").attr("aria-valuenow", totalBytesSent);
            $("div.progress-bar").text(totalBytesSent.toFixed() + "% Complete");
        }
    });

    $('#news_date').datepicker();
    $('[data-toggle="tooltip"]').tooltip();

    if ($('.codeMirror').length > 0) {
        $(".codeMirror").each(function () {
            var editor = CodeMirror.fromTextArea($(this)[0], {
                styleActiveLine: true,
                lineNumbers: true,
                lineWrapping: true,
                smartIndent: true,
                indentWithTabs: true,
                selectionPointer: true
            });
            editor.refresh();
        });
    }
    function postData(data) {
        $("#dialog-modal").dialog({
            height: 140,
            modal: true
        });
        $.post('gallery/ajax/gallery/updateSortOrder', data, function (data) {
            $("#dialog-modal").dialog('close');
        });
    }
    if ($('#table_fields').length > 0) {
        $("#table_fields").tableDnD({
            onDrop: function (table, row) {
                var data = $.tableDnD.serialize();
                data = data + '&' + $('#csrf_token').val() + "=" + $('#csrf_hash').val();
                postData(data);
            }

        });
    }

});