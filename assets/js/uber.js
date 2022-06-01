require('../styles/uberUns.scss');

const imgs = document.querySelectorAll('.cont-slides img');
const suivant = document.querySelector('.right');
const precedent = document.querySelector('.left');
const cercles = document.querySelectorAll('.cercle');
let index = 0;

suivant.addEventListener('click', slideSuivante);

function slideSuivante(){

    if(index < 2){

        imgs[index].classList.remove('active');
        index++;
        imgs[index].classList.add('active');

    }
    else if (index === 2) {

        imgs[index].classList.remove('active');
        index = 0;
        imgs[index].classList.add('active');

    }

    for(i = 0; i < cercles.length; i++){

        if(cercles[i].getAttribute('data-clic') - 1 === index){
            cercles[i].classList.add('active-cercle');
        } else {
            cercles[i].classList.remove('active-cercle');
        }

    }

}


precedent.addEventListener('click', slidePrecedente);

function slidePrecedente(){

    if(index > 0){

        imgs[index].classList.remove('active');
        index--;
        imgs[index].classList.add('active');

    }
    else if (index === 0) {

        imgs[index].classList.remove('active');
        index = 2;
        imgs[index].classList.add('active');

    }
    for(i = 0; i < cercles.length; i++){

        if(cercles[i].getAttribute('data-clic') - 1 === index){
            cercles[i].classList.add('active-cercle');
        } else {
            cercles[i].classList.remove('active-cercle');
        }

    }
}
document.addEventListener('keydown', keyPressed)

function keyPressed(e){

    if(e.keyCode === 37){
        slidePrecedente();
    }
    else if (e.keyCode === 39) {
        slideSuivante();
    }

}
