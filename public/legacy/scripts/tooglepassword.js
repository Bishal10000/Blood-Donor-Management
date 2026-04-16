
    function togglePassword(fieldId, icon) {
        const passwordField = document.getElementById(fieldId);
        if (!passwordField) {
            console.error("Password field not found");
            return;
        }
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
