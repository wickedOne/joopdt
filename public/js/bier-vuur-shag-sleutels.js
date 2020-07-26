$(document).ready(function () {
    function onBierVuurShagSleutels(cb) {
        var input = '';
        var bier = '66736982';
        var vuur = '86858582';
        var shag = '83726571';
        var sleutels = '8376698584697683';

        document.addEventListener('keydown', function (e) {
            input += ('' + e.keyCode);

            if (input === bier || input === vuur || input === shag || input === sleutels) {
                return cb();
            }

            if (0 === bier.indexOf(input) || 0 === vuur.indexOf(input) || 0 === shag.indexOf(input) || 0 === sleutels.indexOf(input)) {
                return;
            }

            input = ('' + e.keyCode);
        });
    }

    onBierVuurShagSleutels(function () {
        $('.rainbow').css('height', '100%').addClass('rainbow-animate');
    });
});