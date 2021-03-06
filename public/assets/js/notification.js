function notification({
    title = '',
    message = '',
    type = '',
    duration = 3000
}) {
    const main = document.getElementById('toast');
        if (main) {
            const toast = document.createElement('div');
            const disappear = (duration + 1000).toFixed(2)
            const autoRemoveId = setTimeout(function() {
                main.removeChild(toast);
            }, disappear)

            toast.onclick = e => {
                if (e.target.closest('.toast__close')) {
                    main.removeChild(toast);
                    clearTimeout(autoRemoveId);
                }
            }

            const icons = {
                success: 'fal fa-check',
                info: 'fal fa-info',
                warning: 'fal fa-exclamation',
                error: 'fal fa-exclamation-triangle'
            };

            const icon = icons[type];
            const delay = (duration / 1000).toFixed(2);
            toast.classList.add('toast', `toast--${type}`);
            toast.style.animation = `animation: slideInLeft ease 0.3s, fadeOut linear 1s ${delay}s forwards;`;
            toast.innerHTML = `
                <div class="toast__icon">
                    <i class="${icon}"></i>
                </div>
                <div class="toast__body">
                    <h3 class="toast__title">${title}</h3>
                    <p class="toast__msg">${message}</p>
                </div>
                <div class="toast__close">
                    <i class="fas fa-times"></i>
                </div>
            `;
            main.appendChild(toast);    
        }
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    }