(function ($) {
    "use strict";
    window.onload = function () {
        $(".head-phone-number").on("click", function () {
            $.ajax({
                url: "/site/counter/",
                method: "POST",
                data: {cid: $(".head-phone-number").data("cid")}
            });
        })
    }
})(jQuery);