const navBar = document.querySelector("nav");
const overlay = document.querySelector(".overlay");
const btnMenu = document.querySelector('#btn-menu');


btnMenu.addEventListener('click' , ()=>{
    btnMenu.classList.toggle('logo');
    btnMenu.classList.toggle('hidden-btn');
    navBar.classList.toggle("open");
})
    
overlay.addEventListener("click", () => {
    btnMenu.classList.toggle('logo');
    btnMenu.classList.toggle('hidden-btn');
    navBar.classList.remove("open");
});


const btnPrint = document.querySelector('#btn-print');

btnPrint.addEventListener('click' , () => {
    window.print();
})