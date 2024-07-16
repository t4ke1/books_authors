document.getElementById('registration').addEventListener('submit', function(event) {
    event.preventDefault();
    let formData = {
        name: document.getElementById("Name").value,
        email: document.getElementById("email").value,
        password: document.getElementById("password").value
    };
    fetch('/api/create-user', {
        method: 'POST',
        body: JSON.stringify(formData)
    })
        .then(response => {
            if (response.ok) {
                localStorage.setItem('email', formData.email);
                alert('User created, verify code has been sent to your email');
                window.location.href = '/verify';
            } else {
                switch (response.status) {
                    case 409:
                        alert('User already exists');
                        break;
                    case 400:
                        alert('Bad request');
                        break;
                    default:
                        alert('Unknown error');
                        break;
                }
            }
        })
});