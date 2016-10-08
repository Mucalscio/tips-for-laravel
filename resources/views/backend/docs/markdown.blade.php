<style>
    .md-preview table{
        display: table;
        border: 1px solid #ddd;
        width: 70%;
        max-width: 100%;
        margin-bottom: 20px;
        background-color: transparent;
        border-spacing: 0;
        border-collapse: collapse;
    }
    .md-preview table > thead > tr > th,.md-preview table > tbody > tr > td{
        border-bottom-width: 2px;
        border: 1px solid #ddd;
        padding: 8px;
    }

    .md-preview{
        width: 97% !important;
        margin-left: auto;
        margin-right: auto;
    }

</style>
<link rel="stylesheet" href="/plugin/bootstrap-markdown/css/bootstrap-markdown.min.css">
<div class="modal fade bs-example-modal-lg" id="markdown" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">添加接口</h4>
            </div>
            <div class="modal-body">
                <div class="editor">
                    <textarea id='markdown_editor' name="content" rows="20">
                        # 这个有问题吗
                    </textarea>
                </div>
            </div>
            <div class="modal-footer" style="text-align: right;">
                <button type="button" class="btn btn-default" onclick="close_markdown()">取消</button>
                <button type="button" class="btn btn-primary" id="upload_markdown">确定</button>
            </div>
        </div>
    </div>
</div>

<script src="/plugin/bootstrap-markdown/js/to-markdown.js"></script>
<script src="/plugin/bootstrap-markdown/js/markdown.js"></script>
<script src="/plugin/bootstrap-markdown/js/marked.js"></script>
<script src="/plugin/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script src="/plugin/bootstrap-markdown/locale/bootstrap-markdown.zh.js"></script>
<script>
    function close_markdown() {
        $("#markdown").modal('hide');
    }
    $("#upload_markdown").click(function () {
        alert("提交");
    });
    $("#markdown_editor").markdown({
        iconlibrary:'glyph',
        language:'zh',
        onPreview: function(e) {
            var previewContent;

            if (e.isDirty()) {
                var originalContent = e.getContent();

                previewContent = marked(originalContent);
            } else {
                previewContent = "Default content"
            }

            return previewContent
        }
    })
</script>
