document.addEventListener('DOMContentLoaded', (event) => {
    const sendButton = document.getElementById('send');
    const reSendButton = document.getElementById('reSend');

    sendButton.addEventListener('click', (e) => {
        e.preventDefault();
        const email = localStorage.getItem('email');
        let formData = {
            token: parseInt(document.getElementById("code").value, 10),
            email: email
        };
        fetch('api/verify-user', {
            method: 'POST',
            body: JSON.stringify(formData)
        })
            .then(response => {
                if (response.ok) {
                    localStorage.clear()
                    alert('You email has been verified, go to login page');
                    window.location.href = '/login';
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

    reSendButton.addEventListener('click', (e) => {
        e.preventDefault();
        const email = localStorage.getItem('email');
        let formData = {
            email: email
        };
        fetch('api/resent-verify-code', {
            method: 'POST',
            body: JSON.stringify(formData)
        })
            .then(response => {
                if (response.ok) {
                    alert('Verification code has been sent to your email');
                } else {
                    switch (response.status) {
                        case 404:
                            alert('User not found');
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
});