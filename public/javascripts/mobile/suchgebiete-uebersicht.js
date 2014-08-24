!function(window, D) {
    var openTelephone = function(href) {
        return function(e) {
            window.open(href);
            e.preventDefault();
            return false;
        };
    };

    Array.prototype.slice.call(D.getElementsByClassName('icon-phone--small'))
            .forEach(function(span) {
                span.addEventListener('click', openTelephone(span.dataset.href), false);
                span.addEventListener('touch', openTelephone(span.dataset.href), false);
            });
}(window, window.document);