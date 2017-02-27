tinymce.init({
    selector: 'textarea',
    plugins: [
        "textcolor",
        "code",
        "hr",
        "image"
    ],
    media_use_script: true,
    toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image hr | forecolor backcolor",
    language: 'es'
});