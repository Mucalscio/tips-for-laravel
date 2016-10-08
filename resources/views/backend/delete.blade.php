<div class="modal fade bs-example-modal-sm" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">提示</h4>
            </div>
            <div class="modal-body">
                您确认要删除吗?此操作不可恢复!
            </div>
            <div class="modal-footer" style="text-align: right;">
                <button type="button" class="btn btn-default" id="delete_no">取消</button>
                <button type="button" class="btn btn-primary" id="delete_yes">确定</button>
            </div>
        </div>
    </div>
</div>

<script>
    function delete_confirm() {
        $('#delete_confirm').modal('show');
    }
    var delete_id = 0;
    $("#delete_no").click(function () {
        $('#delete_confirm').modal('hide');
    });
</script>