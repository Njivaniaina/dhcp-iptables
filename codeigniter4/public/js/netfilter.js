let page_all = document.querySelector(".page-all");
let page_l1 = document.querySelector(".page-l1");
let page_l2 = document.querySelector(".page-l2");
let page_l3 = document.querySelector(".page-l3");
let page_m1 = document.querySelector(".page-m1");
let page_m2 = document.querySelector(".page-m2");

let level = document.querySelector("#level");
let title = document.querySelector(".policy-title");

page_all.addEventListener('click', () => {
    page_all.classList.add('page-actif');
    page_l1.classList.remove('page-actif');
    page_l2.classList.remove('page-actif');
    page_l3.classList.remove('page-actif');
    page_m1.classList.remove('page-actif');
    page_m2.classList.remove('page-actif');

    level.setAttribute("value", "all");
    title.innerText = "The Policy";
});
page_l1.addEventListener('click', () => {
    page_all.classList.remove('page-actif');
    page_l1.classList.add('page-actif');
    page_l2.classList.remove('page-actif');
    page_l3.classList.remove('page-actif');
    page_m1.classList.remove('page-actif');
    page_m2.classList.remove('page-actif');

    level.setAttribute("value", "l1");
    title.innerText = "The Policy L1";
});
page_l2.addEventListener('click', () => {
    page_all.classList.remove('page-actif');
    page_l1.classList.remove('page-actif');
    page_l2.classList.add('page-actif');
    page_l3.classList.remove('page-actif');
    page_m1.classList.remove('page-actif');
    page_m2.classList.remove('page-actif');

    level.setAttribute("value", "l2");
    title.innerText = "The Policy L2";
});
page_l3.addEventListener('click', () => {
    page_all.classList.remove('page-actif');
    page_l1.classList.remove('page-actif');
    page_l2.classList.remove('page-actif');
    page_l3.classList.add('page-actif');
    page_m1.classList.remove('page-actif');
    page_m2.classList.remove('page-actif');

    level.setAttribute("value", "l3");
    title.innerText = "The Policy L3";
});
page_m1.addEventListener('click', () => {
    page_all.classList.remove('page-actif');
    page_l1.classList.remove('page-actif');
    page_l2.classList.remove('page-actif');
    page_l3.classList.remove('page-actif');
    page_m1.classList.add('page-actif');
    page_m2.classList.remove('page-actif');

    level.setAttribute("value", "m1");
    title.innerText = "The Policy M1";
});
page_m2.addEventListener('click', () => {
    page_all.classList.remove('page-actif');
    page_l1.classList.remove('page-actif');
    page_l2.classList.remove('page-actif');
    page_l3.classList.remove('page-actif');
    page_m1.classList.remove('page-actif');
    page_m2.classList.add('page-actif');

    level.setAttribute("value", "m2");
    title.innerText = "The Policy M2";
});