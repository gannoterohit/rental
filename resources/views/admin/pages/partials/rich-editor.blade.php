@once
<style>
    .ck-editor__editable_inline { min-height: 420px; }
    .faq-item .ck-editor__editable_inline { min-height: 150px; }
    .ck.ck-toolbar { border-color:#dbe1ea !important; border-radius:10px 10px 0 0 !important; padding:6px !important; }
    .ck.ck-editor__main > .ck-editor__editable { border-color:#dbe1ea !important; border-radius:0 0 10px 10px !important; }
    .ck.ck-editor__editable.ck-focused { border-color:var(--primary) !important; box-shadow:0 0 0 3px rgba(var(--primary-rgb),.1) !important; }
    .page-editor-fullscreen { position:fixed !important; inset:0 !important; z-index:99999 !important; background:#fff !important; padding:16px !important; overflow:auto !important; }
    .page-editor-fullscreen .ck-editor__editable_inline { min-height:calc(100vh - 145px) !important; }
</style>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/super-build/ckeditor.js"></script>
<script>
window.richEditors = window.richEditors || new Map();
window.createRichEditor = function(element) {
    if (!element || window.richEditors.has(element)) return Promise.resolve(window.richEditors.get(element));
    if (typeof CKEDITOR === 'undefined' || !CKEDITOR.ClassicEditor) {
        return Promise.reject(new Error('CKEditor script not available'));
    }

    return CKEDITOR.ClassicEditor.create(element, {
        toolbar: {
            items: [
                'undo', 'redo', '|',
                'heading', 'style', '|',
                'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                'bold', 'italic', 'underline', 'strikethrough', 'removeFormat', '|',
                'alignment', 'bulletedList', 'numberedList', 'outdent', 'indent', '|',
                'link', 'insertImage', 'insertTable', 'blockQuote', 'horizontalLine', '|',
                'code', 'codeBlock', 'specialCharacters'
            ],
            shouldNotGroupWhenFull: false
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' }
            ]
        },
        fontSize: { options: [9, 11, 13, 'default', 17, 19, 21, 27, 35], supportAllValues: true },
        fontFamily: { supportAllValues: true },
        htmlSupport: { allow: [{ name: /.*/, attributes: true, classes: true, styles: true }] },
        link: {
            decorators: {
                openInNewTab: { mode: 'manual', label: 'Open in a new tab', attributes: { target: '_blank', rel: 'noopener noreferrer' } }
            }
        },
        image: {
            toolbar: ['imageTextAlternative', 'toggleImageCaption', '|', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|', 'linkImage']
        },
        simpleUpload: {
            uploadUrl: @json(route('admin.pages.upload-image')),
            headers: { 'X-CSRF-TOKEN': @json(csrf_token()) }
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
        },
        removePlugins: [
            'AIAssistant', 'CKBox', 'CKBoxImageEdit', 'CKFinder', 'EasyImage',
            'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges', 'RealTimeCollaborativeRevisionHistory',
            'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory',
            'Pagination', 'WProofreader', 'MathType', 'SlashCommand', 'Template',
            'DocumentOutline', 'FormatPainter', 'TableOfContents'
        ]
    }).then(editor => {
        window.richEditors.set(element, editor);
        return editor;
    }).catch(error => {
        console.error('Rich editor failed to initialize:', error);
        return Promise.reject(error);
    });
};
</script>
@endonce
