document.getElementById('login').addEventListener('submit', function(event) {
    event.preventDefault();
    let formData = {
        username: document.getElementById("Name").value,
        password: document.getElementById("password").value
    };
    fetch('/api/login_check', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.token) {
                let token = data.token;
                document.cookie = `token=${token}; path=/`;
                alert('Login successful! Now u can Create, Update and Delete books');
                console.log(token);
                window.location.href = '/book';
            }else {
                alert('Login failed');
            }
        });
});