try {

let changeBtns = document.querySelectorAll('[data-action="change"]'),
dataBlock = document.querySelector('[data-entity="personal-data"]'),
formBlock = document.querySelector('[data-entity="personal-change"]');
changeBtns.forEach((btn)=>{
    btn.addEventListener('click',(e)=>{
        dataBlock.classList.add('is-fade')
        formBlock.classList.remove('is-fade')
    })
})

} catch (e) {
    console.log(e)
}
