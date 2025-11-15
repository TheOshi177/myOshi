document.addEventListener('DOMContentLoaded', () => {
    const audioPlayer = document.getElementById('audioPlayer');
    const songsList = Array.from(document.querySelectorAll('#songsList li'));
    const autoplayBtn = document.getElementById('autoplayBtn');
    const loopBtn = document.getElementById('loopBtn');

    let currentIndex = -1;
    let autoplay = false; // startowy stan Autoplay
    let loopPlaylist = true; // startowy stan Loop

    function playSong(index) {
        if (index < 0 || index >= songsList.length) return;
        currentIndex = index;
        const src = songsList[index].getAttribute('data-src');
        audioPlayer.src = src;
        audioPlayer.play();

        songsList.forEach(item => item.classList.remove('active'));
        songsList[index].classList.add('active');
    }

    songsList.forEach((item, index) => {
        item.addEventListener('click', () => playSong(index));
    });

    audioPlayer.addEventListener('ended', () => {
        let nextIndex = currentIndex + 1;
        if (nextIndex >= songsList.length) {
            if (loopPlaylist) nextIndex = 0;
            else return;
        }
        playSong(nextIndex);
    });

    // Obsługa przycisków
    autoplayBtn.addEventListener('click', () => {
        autoplay = !autoplay;
        autoplayBtn.textContent = `Autoplay: ${autoplay ? 'ON' : 'OFF'}`;
        if (autoplay && currentIndex === -1 && songsList.length > 0) {
            playSong(0);
        }
    });

    loopBtn.addEventListener('click', () => {
        loopPlaylist = !loopPlaylist;
        loopBtn.textContent = `Loop Playlist: ${loopPlaylist ? 'ON' : 'OFF'}`;
    });
});
