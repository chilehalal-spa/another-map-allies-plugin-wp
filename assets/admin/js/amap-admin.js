jQuery(document).ready(function($) {
    const inputLat = $('#amap_lat');
    const inputLng = $('#amap_lng');
    const countrySelect = $('#amap_country_selector');
    const flagUrlInput = $('#amap_flag_url');
    const imgInput = $('#amap_image_id');
    const imgPreview = $('#amap_image_preview');
    const removeBtn = $('#amap_remove_btn');

    countrySelect.on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const val = selectedOption.val();
        if(!val) return;

        const coords = val.split(',');
        inputLat.val(coords[0]);
        inputLng.val(coords[1]);

        const countryCode = selectedOption.data('country');
        if (countryCode) {
            const flagUrl = 'https://flagcdn.com/w160/' + countryCode + '.png';
            imgInput.val(''); 
            flagUrlInput.val(flagUrl);
            imgPreview.html('<img src="' + flagUrl + '" style="max-width:100%; max-height:100%;">');
            removeBtn.show();
        }
    });

    let frame;
    $('#amap_upload_btn').on('click', function(e) {
        e.preventDefault();
        if (frame) { frame.open(); return; }
        frame = wp.media({ title: 'Seleccionar Logo', button: { text: 'Usar imagen' }, multiple: false });
        frame.on('select', function() {
            const attachment = frame.state().get('selection').first().toJSON();
            imgInput.val(attachment.id);
            flagUrlInput.val('');
            imgPreview.html('<img src="' + (attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url) + '" style="max-width:100%; max-height:100%;">');
            removeBtn.show();
        });
        frame.open();
    });

    removeBtn.on('click', function() {
        imgInput.val('');
        flagUrlInput.val('');
        imgPreview.html('<span style="color:#aaa;">Sin Imagen</span>');
        $(this).hide();
    });
});