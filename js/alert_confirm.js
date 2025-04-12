
document.addEventListener('DOMContentLoaded', () => {
    const openModalButtons = document.querySelectorAll('.js-confirm-trigger');
    const confirmYesButtons = document.querySelectorAll('.confirm-yes');

    openModalButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const target = button.dataset.target;
            const modal = document.getElementById(target);
            const confirmYesButton = modal.querySelector('.confirm-yes');

            confirmYesButton.dataset.href = button.href;
            modal.classList.add('is-active');
        });
    });

    confirmYesButtons.forEach(button => {
        button.addEventListener('click', () => {
            const href = button.dataset.href;
            window.location.href = href;
        });
    });
});

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('is-active');
}