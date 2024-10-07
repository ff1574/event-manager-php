document.querySelector('a[href="#login-form"]').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelector('#login-form').scrollIntoView({ behavior: 'smooth' });
    history.pushState(null, null, ' ');
});