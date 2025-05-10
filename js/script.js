const carousels = document.querySelectorAll('.carousel');

carousels.forEach(carousel => {

    const blockContainer = carousel.querySelector('.section-blocks-container');
    const leftBtn = carousel.querySelector('.scroll-button.left-button');
    const rightBtn = carousel.querySelector('.scroll-button.right-button');
    const scrollAmount = 800;

    leftBtn.addEventListener('click', () => {
        blockContainer.scrollLeft -= scrollAmount;
    });
    rightBtn.addEventListener('click', () => {
        blockContainer.scrollLeft += scrollAmount;
    });

})



const profileButton = document.getElementById('profile-button');
const dropdown = document.getElementById('profile-dropdown-menu');

profileButton.addEventListener('click', (e) => {
    e.stopPropagation(); // evita que o clique feche imediatamente o menu
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('click', () => {
    dropdown.style.display = 'none';
});