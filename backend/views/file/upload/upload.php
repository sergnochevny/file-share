<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            {% var match = file.type.split('/');
            if(match.length && (match[0] == 'image')){ %}
            <div class="file">
                <div class="preview"></div>
            </div>
            {%} else {
                var types = {
                    'doc' : 'doc',
                    'docx' : 'doc',
                    'xls' : 'xls',
                    'pdf' : 'pdf',
                    'zip' : 'zip',
                    'rar' : 'zip',
                    'att' : 'att',
                    'png' : 'pic',
                    'jpg' : 'pic',
                    'jpeg' : 'pic'
                }
                var type = types[match[1]];
                if(!type) type = 'att';
            %}
                <div class="file"><div class="file-thumbnail file-thumbnail-{%=type%}"></div></div>
            {% } %}
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped progress-xs active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                <div class="progress-bar progress-bar-indicating progress-bar-warning" style="width:0%;"></div>
            </div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button title="Start" class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                </button>
            {% } %}
            {% if (!i) { %}
                <button title="Cancel" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-remove-circle"></i>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>