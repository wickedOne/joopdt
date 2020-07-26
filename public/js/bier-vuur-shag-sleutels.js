$(document).ready(function () {
    function onBierVuurShagSleutels(cb) {
        var input = '';
        var key = '66868383';

        document.addEventListener('keydown', function (e) {
            input += ('' + e.keyCode);

            if (input === key) {
                return cb();
            }

            if (!key.indexOf(input)) {
                return;
            }

            input = ('' + e.keyCode);
        });
    }

    onBierVuurShagSleutels(function () {$('.rainbow').css('height', '100%').addClass('rainbow-animate');});
});