let timer;
let elapsedTime = 0;
let isRunning = false;
const display = document.getElementById('display');
const lapsContainer = document.getElementById('laps');

document.getElementById('startBtn').addEventListener('click', () => {
    if (!isRunning) {
        isRunning = true;
        timer = setInterval(() => {
            elapsedTime += 10;
            display.textContent = formatTime(elapsedTime);
        }, 10);
    }
});

document.getElementById('stopBtn').addEventListener('click', () => {
    clearInterval(timer);
    isRunning = false;
});

document.getElementById('resetBtn').addEventListener('click', () => {
    clearInterval(timer);
    elapsedTime = 0;
    isRunning = false;
    display.textContent = '00:00.00';
    lapsContainer.innerHTML = '';
});

document.getElementById('lapBtn').addEventListener('click', () => {
    const lapDiv = document.createElement('div');
    lapDiv.textContent = `Kierrosaika: ${formatTime(elapsedTime)}`;
    lapsContainer.appendChild(lapDiv);
});

function formatTime(milliseconds) {
    const totalSeconds = Math.floor(milliseconds / 1000);
    const mins = String(Math.floor(totalSeconds / 60)).padStart(2, '0'); // Minuutit
    const secs = String(totalSeconds % 60).padStart(2, '0'); // Sekunnit
    const ms = String(milliseconds % 1000).padStart(3, '0').slice(0, 2); // Sadasosat
    return `${mins}:${secs}.${ms}`;
}
