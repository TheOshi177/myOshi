const audioPlayer = document.getElementById('audioPlayer');
const songsList = document.getElementById('songsList');

songsList.querySelectorAll('li').forEach(item => {
    item.addEventListener('click', () => {
        const src = item.getAttribute('data-src');
        audioPlayer.src = src;
        audioPlayer.play();
    });
});
