selector(".menu").addEventListener('click', function()
{
    console.log('click');
    this.classList.toggle('open');

    selector('header').classList.toggle('open');
    selector('.overlay').classList.toggle('open');
});

function selector(s) {
    return document.querySelector(s)
}

.dropdown-toggle.addEventListener(click, function()
{
    selector('.dropdown-toggle').classList.toggle('navhidden');
});

