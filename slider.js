let i = 1;

function slideup() {
    i++;
    if (i == 2) {
        document.getElementById('slider').innerHTML = "<button onclick='slidedown()'><</button><img src='./img/2.webp' alt='slide2'><button onclick='slideup()'>></button>";
    } else if (i == 3) {
        document.getElementById('slider').innerHTML = "<button onclick='slidedown()'><</button><img src='./img/3.jpg' alt='slide3'><button onclick='slideup()'>></button>";
    } else if (i == 4) {
        document.getElementById('slider').innerHTML = "<button onclick='slidedown()'><</button><img src='./img/4.webp' alt='slide4'><button onclick='slideup()'>></button>";
    } else {
        i = 1;
        document.getElementById('slider').innerHTML = "<button onclick='slidedown()'><</button><img src='./img/1.webp' alt='slide1'><button onclick='slideup()'>></button>";
    }
}

function slidedown() {
    i--;
    if (i == 3) {
        document.getElementById('slider').innerHTML = "<button onclick='slidedown()'><</button><img src='./img/3.jpg' alt='slide3'><button onclick='slideup()'>></button>";
    } else if (i == 2) {
        document.getElementById('slider').innerHTML = "<button onclick='slidedown()'><</button><img src='./img/2.webp' alt='slide2'><button onclick='slideup()'>></button>";
    } else if (i == 1) {
        document.getElementById('slider').innerHTML = "<button onclick='slidedown()'><</button><img src='./img/1.webp' alt='slide1'><button onclick='slideup()'>></button>";
    } else {
        i = 4;
        document.getElementById('slider').innerHTML = "<button onclick='slidedown()'><</button><img src='./img/4.webp' alt='slide4'><button onclick='slideup()'>></button>";
    }
}

setInterval(function () {
    slideup();
}, 3000);
