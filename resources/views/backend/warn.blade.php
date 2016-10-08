<div class="modal fade bs-example-modal-sm" id="warn" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="warn_title">错误</h4>
            </div>
            <div id="warn_content" class="modal-body">
                提示语
            </div>
        </div>
    </div>
</div>

<script>
    function warn(title, content) {
        $('#warn_title').html(title);
        $('#warn_content').html(content);
        $('#warn').modal('show');
    }

    <?php
        $warn = session('warn');
        if(!empty($warn)){
            echo "warn('".$warn['title']."','".$warn['content']."');";
        }
    ?>
</script>