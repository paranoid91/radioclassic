<div class="preview-btn">
    <a href="#" type="button" role="button" class="btn btn-info preview-button">Preview</a>
</div>
<script>
    $(document).ready(function(){
        $("a.preview-button").on("click", function(e){

            e.preventDefault();
            var title = $("#title").val();
            var body = tinyMCE.activeEditor.getContent();
            var img = ( typeof $("span.UploadImage0 img").attr("src") == "undefined" ? null : btoa($("span.UploadImage0 img").attr("src")) );

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{ action("Admin\HomeController@storeSess") }}",
                dataType: "json",
                data: { "title" : title, "body" : body, "img" : img },
                method: "post",
            }).done(function() {
                window.open( "{{ action("Admin\HomeController@previewPage") }}", "_blank");
            });
        });
    });
</script>