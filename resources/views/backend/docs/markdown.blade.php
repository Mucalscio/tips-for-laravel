
<div class="modal fade bs-example-modal-lg" id="markdown" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">添加接口</h4>
            </div>
            <div class="modal-body">
                <div class="editor">
                    <textarea id='markdown_editor'># 这个有问题吗</textarea>
                </div>
            </div>
            <div class="modal-footer" style="text-align: right;">
                <button type="button" class="btn btn-default" onclick="close_markdown()">取消</button>
                <button type="button" class="btn btn-primary" id="upload_markdown">确定</button>
            </div>
        </div>
    </div>
</div>

<script>
    function close_markdown() {
        $("#markdown").modal('hide');
    }
    $("#upload_markdown").click(function () {
        alert("提交");
    });
</script>
