const form = document.getElementById("signup-form");
const demo = document.getElementById("demo");

demo.addEventListener('click', function() {
    // Your onclick event handler code here
    alert('Element clicked!');
});


form.addEventListener("submit", function (event) {

  // Perform validation
  let isValid = true;

  // Validate first name and last name (assuming they are required)
  const firstName = form.elements["firstName"].value.trim();
  const lastName = form.elements["lastName"].value.trim();
  if (firstName === "" || lastName === "") {
    isValid = false;
    alert("Please provide both first name and last name");
  }

  // Validate email
  const email = form.elements["email"].value.trim();
  if (!isValidEmail(email)) {
    isValid = false;
    alert("Please provide a valid email address");
  }

  // Validate mobile number
  const mobile = form.elements["mobile"].value.trim();
  if (!isValidMobileNumber(mobile)) {
    isValid = false;
    alert("Please provide a valid mobile number");
  }

  // Validate gender (assuming it's required)
  const gender = form.elements["gender"].value;
  if (gender === "") {
    isValid = false;
    alert("Please select a gender");
  }

  // Validate birthdate (assuming it's required)
  const birthdate = form.elements["birthdate"].value;
  if (birthdate === "") {
    isValid = false;
    alert("Please provide a birthdate");
  }

  // Validate password
  const password = form.elements["password"].value.trim();
  const passwordRepeat = form.elements["passwordRepeat"].value.trim();
  if (password === "" || passwordRepeat === "" || password !== passwordRepeat) {
    isValid = false;
    alert("Passwords do not match");
  }

  // Validate course and section (assuming they are optional)

  // If all validations pass, submit the form
  if (isValid) {
    form.submit();
  }
});

// Function to validate email format
function isValidEmail(email) {
  // Regular expression for basic email validation
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

// Function to validate mobile number format
function isValidMobileNumber(mobile) {
  // Regular expression for basic mobile number validation
  const mobileRegex = /^\d{11}$/;
  return mobileRegex.test(mobile);
}
