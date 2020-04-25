(function () {
    const button = document.querySelector('.menu-toogle')

    button.onclick = function (e) {
        console.log('co');
        const corpo = document.querySelector('body')
        corpo.classList.toggle('hide-sidebar')
    }

    activateClock()
})()

function activateClock() {
    const activeClock = document.querySelector('[active-clock]')
    if (!activeClock) return

    function addOneSecond(hours, minutes, seconds) {
        let d = new Date
        d.setHours(parseInt(hours))
        d.setMinutes(parseInt(minutes))
        d.setSeconds(parseInt(seconds) + 1)
        const h = `${d.getHours()}`.padStart(2, 0);
        const m = `${d.getMinutes()}`.padStart(2, 0);
        const s = `${d.getSeconds()}`.padStart(2, 0);
        return `${h}:${m}:${s}`
    }
    
    setInterval(function () {
        const parts = activeClock.innerHTML.split(':');
        activeClock.innerHTML = addOneSecond(...parts)
    }, 1000);
}

