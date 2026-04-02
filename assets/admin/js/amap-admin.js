jQuery(document).ready(function($) {
    const pin = $('.amap-admin-pin');
    const inputTop = $('#amap_pin_top');
    const inputLeft = $('#amap_pin_left');
    const countrySelect = $('#amap_country_selector');
    
    let frame;
    const uploadBtn = $('#amap_upload_btn');
    const removeBtn = $('#amap_remove_btn');
    const imgInput = $('#amap_image_id');
    const imgPreview = $('#amap_image_preview');
    const flagUrlInput = $('#amap_flag_url');

    function updatePin() {
        pin.css({
            top: inputTop.val() + '%',
            left: inputLeft.val() + '%'
        });
    }

    inputTop.on('input', updatePin);
    inputLeft.on('input', updatePin);

    $('.amap-admin-preview').on('click', function(e) {
        const offset = $(this).offset();
        const width = $(this).width();
        const height = $(this).height();
        const x = e.pageX - offset.left;
        const y = e.pageY - offset.top;

        const pX = ((x / width) * 100).toFixed(1);
        const pY = ((y / height) * 100).toFixed(1);

        inputLeft.val(pX);
        inputTop.val(pY);
        updatePin();
        
        countrySelect.val('');
    });

    countrySelect.on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const val = selectedOption.val();
        
        if(!val) return;

        const coords = val.split(',');
        const lat = parseFloat(coords[0]);
        const lon = parseFloat(coords[1]);

        let pTop = (90 - lat) / 180 * 100;
        let pLeft = (lon + 180) / 360 * 100;

        pTop = Math.max(0, Math.min(100, pTop)).toFixed(1);
        pLeft = Math.max(0, Math.min(100, pLeft)).toFixed(1);

        inputTop.val(pTop);
        inputLeft.val(pLeft);
        updatePin();

        const countryCode = selectedOption.data('country');
        
        if (countryCode) {
            const flagUrl = 'https://flagcdn.com/w160/' + countryCode + '.png';
            
            imgInput.val(''); 
            flagUrlInput.val(flagUrl);
            
            imgPreview.html('<img src="' + flagUrl + '" style="max-width:100%; max-height:100%;">');
            removeBtn.show();
        }
    });

    uploadBtn.on('click', function(e) {
        e.preventDefault();
        if (frame) { frame.open(); return; }
        
        frame = wp.media({
            title: 'Seleccionar Logo del Aliado',
            button: { text: 'Usar esta imagen' },
            multiple: false
        });
        
        frame.on('select', function() {
            const attachment = frame.state().get('selection').first().toJSON();
            
            imgInput.val(attachment.id);
            flagUrlInput.val('');
            
            let url = attachment.url;
            if (attachment.sizes && attachment.sizes.thumbnail) {
                url = attachment.sizes.thumbnail.url;
            }
            
            imgPreview.html('<img src="' + url + '" style="max-width:100%; max-height:100%;">');
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