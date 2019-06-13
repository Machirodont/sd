(function ($) {
    "use strict";
    window.onload = function () {
        $(".head-phone-number").on("mousedown", function () {
            $.ajax({
                url: "/site/counter/",
                method: "POST",
                data: {
                    cid: $(".head-phone-number").data("cid"),
                    scrData: screen.width+":"+screen.height
                 }
            });
        })
    }
})(jQuery);