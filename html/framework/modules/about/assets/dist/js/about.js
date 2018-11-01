/*$(function () {
    var video = document.getElementById('mainVideo');
    if (video) {        
        $('.video-btn').click(function () {
            $(this).toggleClass('play');
            if ($(this).hasClass('play')) {
                video.play();
            } else {
                video.pause();
            }
            return false;
        });
    }
    
});

function onYouTubePlayerAPIReady() {
    player = new YT.Player('Youtube', {
        events: {'onReady': onPlayerReady}
    });
}
function onPlayerReady(event) {
    document.getElementById("video-play").addEventListener("click", function () {
        player.playVideo();
    });
    document.getElementById("video-stop").addEventListener("click", function () {
        player.pauseVideo();
    });
}
$(document).ready(function () {

    $('.video-btn').on('click', function (ev) {
        var wrap = $('.wrap-media-video');
        wrap.toggleClass('play');
        ev.preventDefault();
    });
});
*/
function onYouTubePlayerAPIReady() {
    player = new YT.Player('Youtube', {
        events: {'onReady': onPlayerReady}
    });
}

function onPlayerReady(event) {
    document.getElementById("video-play").addEventListener("click", function () {
        player.playVideo();
    });
}

$(document).ready(function () {
    $('#video-play').on('click', function (ev) {
        var wrap = $('.wrap-media-video');
        wrap.toggleClass('play');
        ev.preventDefault();
    });
});