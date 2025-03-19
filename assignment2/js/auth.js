const passwordInput  = document.getElementById('password');
const confirmInput   = document.getElementById('confirm_password');
const form           = document.getElementById('regForm');
const reqLength      = document.getElementById('req-length');
const reqUpper       = document.getElementById('req-upper');
const reqLower       = document.getElementById('req-lower');
const reqDigit       = document.getElementById('req-digit');
const reqSpecial     = document.getElementById('req-special');
const confirmMsg     = document.getElementById('confirmMsg');
const reqContainer   = document.getElementById('password-requirements');

// Regex patterns
const upperCasePattern   = /[A-Z]/;
const lowerCasePattern   = /[a-z]/;
const digitPattern       = /[0-9]/;
const specialCharPattern = /[!@#$%^&*()_+\-=\[\]{};:'"\\|,.<>\/?！＠＃＄％＾＆＊（）＿＋－＝［］｛｝；：‘’“”＼｜，．＜＞／？]/;
// /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/
function checkPassword() {
    const pwdValue = passwordInput.value;

    // 1. Length
    if (pwdValue.length >= 8) {
        reqLength.classList.add('valid');
        reqLength.classList.remove('invalid');
    } else {
        reqLength.classList.add('invalid');
        reqLength.classList.remove('valid');
    }

    // 2. Uppercase
    if (upperCasePattern.test(pwdValue)) {
        reqUpper.classList.add('valid');
        reqUpper.classList.remove('invalid');
    } else {
        reqUpper.classList.add('invalid');
        reqUpper.classList.remove('valid');
    }

    // 3. Lowercase
    if (lowerCasePattern.test(pwdValue)) {
        reqLower.classList.add('valid');
        reqLower.classList.remove('invalid');
    } else {
        reqLower.classList.add('invalid');
        reqLower.classList.remove('valid');
    }

    // 4. Digit
    if (digitPattern.test(pwdValue)) {
        reqDigit.classList.add('valid');
        reqDigit.classList.remove('invalid');
    } else {
        reqDigit.classList.add('invalid');
        reqDigit.classList.remove('valid');
    }

    // 5. Special char
    if (specialCharPattern.test(pwdValue)) {
        reqSpecial.classList.add('valid');
        reqSpecial.classList.remove('invalid');
    } else {
        reqSpecial.classList.add('invalid');
        reqSpecial.classList.remove('valid');
    }
}

function checkConfirmPassword() {
    const pwdValue  = passwordInput.value;
    const confirm   = confirmInput.value;

    if (pwdValue && confirm) {
        if (pwdValue === confirm) {
            confirmMsg.textContent = "Passwords match!";
            confirmMsg.classList.remove('hidden', 'error');
            confirmMsg.classList.add('success');
        } else {
            confirmMsg.textContent = "Passwords do not match!";
            confirmMsg.classList.remove('hidden', 'success');
            confirmMsg.classList.add('error');
        }
    } else {
        confirmMsg.textContent = "";
        confirmMsg.classList.add('hidden');
    }
}

// Show requirements container on focus
passwordInput.addEventListener('focus', () => {
    reqContainer.classList.remove('hidden');
});

// hide the container on blur if no value
passwordInput.addEventListener('blur', () => {
    if (passwordInput.value.trim() === "") {
        reqContainer.classList.add('hidden');
    }
});

// Live checks for requirements and confirmation
passwordInput.addEventListener('input', () => {
    checkPassword();
    checkConfirmPassword();
});
confirmInput.addEventListener('input', checkConfirmPassword);

// Final check before submission
form.addEventListener('submit', (e) => {
    const pwdValue = passwordInput.value;

    // Check each requirement again
    const validLength   = (pwdValue.length >= 8);
    const validUpper    = upperCasePattern.test(pwdValue);
    const validLower    = lowerCasePattern.test(pwdValue);
    const validDigit    = digitPattern.test(pwdValue);
    const validSpecial  = specialCharPattern.test(pwdValue);

    if (!validLength || !validUpper || !validLower || !validDigit || !validSpecial) {
        e.preventDefault();
        alert("Please ensure your password meets all requirements before submitting.");
        return;
    }

    if (pwdValue !== confirmInput.value) {
        e.preventDefault();
        alert("Passwords do not match.");
        return;
    }
});
