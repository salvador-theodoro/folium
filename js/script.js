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


//MENU DROPDOWN PROFILE
const profileButton = document.getElementById('profile-button');
const profileDropdown = document.getElementById('profile-dropdown-menu');

profileButton.addEventListener('click', (e) => {
    e.stopPropagation(); // evita que o clique feche imediatamente o menu
    profileDropdown.style.display = profileDropdown.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('click', () => {
    profileDropdown.style.display = 'none';
});


//MENU DROPDOWN NOTIFICATION
const notifcationButton = document.getElementById('notification-button');
const notificationDropdown = document.getElementById('notification-dropdown-menu');

notificationButton.addEventListener('click', (e) => {
    e.stopPropagation(); // evita que o clique feche imediatamente o menu
    notificationDropdown.style.display = notificationDropdown.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('click', () => {
    notificationDropdown.style.display = 'none';
});
