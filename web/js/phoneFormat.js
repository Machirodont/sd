(function ($) {
    "use strict";
    window.addEventListener('load', function () {
        let input = $("#phoneInput");
        input.on('input', () => {
            let raw = input.val();
            raw = raw.replaceAll(/[^0-9]+/g, '');
            if (raw.length > 10) {
                raw = raw.substr(0, 10);
            }
            $('button[type=submit]').attr({disabled: (raw.length !== 10)})
            input.val(raw);
        })
    });
})(jQuery);