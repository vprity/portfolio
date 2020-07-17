function preview_toggle()
{
    const e = document.getElementsByClassName('admin-preview__content')[0];

    e.classList.toggle('admin-preview__content--activated');
    e.classList.toggle('admin-preview__content--disabled');
}

function preview_upload(e)
{
    const e_preview = document.getElementsByClassName('admin-preview__image')[0];
    const e_btn_preview = document.getElementsByClassName('admin-preview')[0];

    e_preview.src = window.URL.createObjectURL(e.files[0]);

    if (e_btn_preview.classList.contains('admin-preview--disabled')) {
        e_btn_preview.classList.remove('admin-preview--disabled');
        e_btn_preview.classList.add('admin-preview--activated');
    }
}