let page_all = document.querySelector(".page-all");
let page_l1 = document.querySelector(".page-l1");
let page_l2 = document.querySelector(".page-l2");
let page_l3 = document.querySelector(".page-l3");
let page_m1 = document.querySelector(".page-m1");
let page_m2 = document.querySelector(".page-m2");

let level = document.querySelector("#level");
let title = document.querySelector(".policy-title");

let dataAll = document.querySelectorAll('#All p');
let dataL1 = document.querySelectorAll('#L1 p');
let dataL2 = document.querySelectorAll('#L2 p');
let dataL3 = document.querySelectorAll('#L3 p');
let dataM1 = document.querySelectorAll('#M1 p');
let dataM2 = document.querySelectorAll('#M2 p');


let containerInput = document.querySelector('#input');
let containerForward = document.querySelector('#forward');
let containerOutput = document.querySelector('#output');


page_all.addEventListener('click', () => {
    page_all.classList.add('page-actif');
    page_l1.classList.remove('page-actif');
    page_l2.classList.remove('page-actif');
    page_l3.classList.remove('page-actif');
    page_m1.classList.remove('page-actif');
    page_m2.classList.remove('page-actif');

    level.setAttribute("value", "all");
    title.innerText = "The Policy All";

    const data = dataAll;

    containerInput.innerHTML = "";
    containerForward.innerHTML = "";
    containerOutput.innerHTML = "";


    const tabRule = ["ACCEPT" , "DROP" , "REJECT"];


    for(let rule of tabRule){
        containerInput.innerHTML += rule === data[0].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;      
        containerForward.innerHTML += rule === data[1].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
        containerOutput.innerHTML += rule === data[2].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
    }
    

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

    const data = dataL1;


    containerInput.innerHTML = "";
    containerForward.innerHTML = "";
    containerOutput.innerHTML = "";

    const tabRule = ["ACCEPT" , "DROP" , "REJECT"];


    for(let rule of tabRule){
        containerInput.innerHTML += rule === data[0].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;      
        containerForward.innerHTML += rule === data[1].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
        containerOutput.innerHTML += rule === data[2].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
    }
    
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

    const data = dataL2;

    containerInput.innerHTML = "";
    containerForward.innerHTML = "";
    containerOutput.innerHTML = "";


    const tabRule = ["ACCEPT" , "DROP" , "REJECT"];
    

    for(let rule of tabRule){
        containerInput.innerHTML += rule === data[0].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;      
        containerForward.innerHTML += rule === data[1].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
        containerOutput.innerHTML += rule === data[2].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
    }
    
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

    const data = dataL3;


    containerInput.innerHTML = "";
    containerForward.innerHTML = "";
    containerOutput.innerHTML = "";


    const tabRule = ["ACCEPT" , "DROP" , "REJECT"];
    

    for(let rule of tabRule){
        containerInput.innerHTML += rule === data[0].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;      
        containerForward.innerHTML += rule === data[1].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
        containerOutput.innerHTML += rule === data[2].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
    }
    


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

    const data = dataM1;

    
    containerInput.innerHTML = "";
    containerForward.innerHTML = "";
    containerOutput.innerHTML = "";


    const tabRule = ["ACCEPT" , "DROP" , "REJECT"];
    

    for(let rule of tabRule){
        containerInput.innerHTML += rule === data[0].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;      
        containerForward.innerHTML += rule === data[1].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
        containerOutput.innerHTML += rule === data[2].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
    }
    

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


    const data = dataM2;

    containerInput.innerHTML = "";
    containerForward.innerHTML = "";
    containerOutput.innerHTML = "";


    const tabRule = ["ACCEPT" , "DROP" , "REJECT"];
    

    for(let rule of tabRule){
        containerInput.innerHTML += rule === data[0].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;      
        containerForward.innerHTML += rule === data[1].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
        containerOutput.innerHTML += rule === data[2].innerText ? `<option value=${rule} selected>${rule}</option>` : `<option value=${rule}>${rule}</option>`;
    }
    
});