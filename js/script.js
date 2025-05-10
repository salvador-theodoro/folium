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