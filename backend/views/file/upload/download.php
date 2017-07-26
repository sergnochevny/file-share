<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    {%
        if ((file.update === undefined) || !file.update) {
            var selector = '[data-key='+file.id+']',
                row_updated = $(selector);
            row_updated.remove();
        }
    %}
    <tr class="fade" data-key="{%= file.id %}">
        <td class="sorting">
            <div class="file">
                <div class="file-thumbnail file-thumbnail-{%=file.type%}"></div>
            </div>
        </td>
        <td>
            {%= file.name %}
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td class="hidden-sm hidden-xs" width="80">
            <span>{%= file.date %}</span>
        </td>
        <td class="hidden-sm hidden-xs" width="100">
            {%=o.formatFileSize(file.size)%}
        </td>
        <td width="{%= file.width %}">
            {% if (file.archiveUrl) { %}
                <a class="btn btn-purple btn-xs" href="{%=file.archiveUrl%}" title="Archive" aria-label="Archive" data-confirm="Confirm archiving" data-method="post" data-pjax="1">
                    {%=file.archiveLabel%}
                </a>
            {% } %}
            {% if (file.deleteUrl) { %}
                <a class="btn btn-danger btn-xs" href="{%=file.deleteUrl%}" title="Delete" aria-label="Delete" data-confirm="Confirm removal" data-method="post" data-pjax="1">
                    Delete
                </a>
            {% } %}
            {% if (file.downloadUrl) { %}
                <a class="btn btn-warning btn-xs" href="{%=file.downloadUrl%}" title="Download" data-download="" aria-label="Download" data-pjax="0">
                    Download
                </a>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
