(function() {
    const button = document.querySelector('.menu-toogle')
    
    button.onclick = function(e) {
        console.log('co');
        const corpo = document.querySelector('body')
        corpo.classList.toggle('hide-sidebar')
    }
})()
