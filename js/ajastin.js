//Tarkka ajastin
class Ajastin {
    constructor () {
        this.isRunning = false;
        this.startTime = 0;
        this.overallTime = 0;
        this.times = [];
        this.timesMilli = [];
        this.addedTimes = 0
    }

    _getTimeElapsedSinceStart () {
        if (!this.startTime) {
            return 0;
        }

        return Date.now() - this.startTime;
    }

    start() {
        if (this.isRunning) {
            return console.error('Ajastin on jo päällä!');
        }

        this.isRunning = true;

        this.startTime = Date.now();
    }

    stop() {
        if (!this.isRunning) {
            return console.error('Ajastin on jo pysäytetty');
        }

        this.isRunning = false;

        this.overallTime = this.overallTime + this._getTimeElapsedSinceStart();

        console.log("Kaikki ajat saatu, ajastin pysäytetään.")
    }

    reset() {
        this.overallTime = 0;

        if (this.isRunning) {
            this.startTime = Date.now();
            return;
        }

        this.startTime = 0
    }

    getTime() {
        if (!this.startTime) {
            return 0;
        }

        if (this.isRunning) {
            return this.overallTime + this._getTimeElapsedSinceStart();
        }

        return this.overallTime;
    }

    getFinalTime() {
        let timeInMilliSeconds = this.getTime();
        const totalSeconds = Math.floor(timeInMilliSeconds / 1000);
        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        const milliseconds = timeInMilliSeconds % 1000;

        const formattedTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}.${String(milliseconds).padStart(3, '0')}`;
        return formattedTime;
    }

    addTime() {
        let timeInMilliSeconds = this.getTime();
        this.timesMilli.push(timeInMilliSeconds);
        if (this.times.length != 0) {
            timeInMilliSeconds = timeInMilliSeconds - this.timesMilli[this.addedTimes];
            const totalSeconds = Math.floor(timeInMilliSeconds / 1000);
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            const milliseconds = timeInMilliSeconds % 1000;

            const lapFormattedTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}.${String(milliseconds).padStart(3, '0')}`;
            this.times.push(lapFormattedTime);
            console.log(this.times);
            this.addedTimes = this.addedTimes + 1;

            if (this.times.length == 3){document.getElementById("kokonaisaika").value = this.getFinalTime();}

        } else {
            const totalSeconds = Math.floor(timeInMilliSeconds / 1000);
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            const milliseconds = timeInMilliSeconds % 1000;

            const lapFormattedTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}.${String(milliseconds).padStart(3, '0')}`;
            this.times.push(lapFormattedTime);
            console.log(this.times);
        }

        if (this.times.length == 3) {
            this.stop()
        }
        //Näytetään nykyiset ajat
        if (this.times[0]){document.getElementById("tehtava1aika").value = this.times[0];}
        if (this.times[1]){document.getElementById("tehtava2aika").value = this.times[1];}
        if (this.times[2]){document.getElementById("tehtava3aika").value = this.times[2];}
    }


}

const timer = new Ajastin();

document.getElementById("startBtn").addEventListener("click", () => timer.start());
document.getElementById("stopBtn").addEventListener("click", () => timer.stop());
document.getElementById("lapBtn").addEventListener("click", () => timer.addTime());
setInterval(() => {
    const timeInMilliSeconds = timer.getTime();
    const totalSeconds = Math.floor(timeInMilliSeconds / 1000);
    const minutes = Math.floor(totalSeconds / 60);
    const seconds = totalSeconds % 60;
    const milliseconds = timeInMilliSeconds % 1000;

    const formattedTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}.${String(milliseconds).padStart(3, '0')}`;
    document.getElementById('display').innerText = formattedTime;
}, 50);

//Automaattinen ajan aloitus
$(document).ready(function() {
    let timerStarted = false;
    function checkStartSignal() {
        if (timerStarted) {return}; // Ei aloiteta ajastinta, jos jo päällä

        $.ajax({
            url: 'inc/tarkista_ajan_aloitus.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.aika_aloitettu) {
                    timer.start();
                    timerStarted = true;
                    console.log("Ajastin käynnistetty!");
                }
            },
            error: function (xhr, status, error) {
                console.error("Aikoja ei viela aloitettu!", error);
            }
        });
    }

    setInterval(checkStartSignal, 500);
});