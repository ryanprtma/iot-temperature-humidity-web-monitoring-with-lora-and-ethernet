// const header = document.getElementsByTagName("header");
const navbar = document.getElementById("navbar");
const jumbotron = document.getElementById("jumbotron")
const w = window.innerWidth;

const p = (w)=>{
    if (w<=567) {
        navbar.style.display = "none"
        jumbotron.style.display = "none"
    } else {
        true
    }
}

p(w)