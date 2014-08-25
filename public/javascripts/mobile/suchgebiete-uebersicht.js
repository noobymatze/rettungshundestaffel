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
                ['click', 'touch'].forEach(function(event) {
                    span.addEventListener(event, openTelephone(span.dataset.href));
                });
            });
}(window, window.document);