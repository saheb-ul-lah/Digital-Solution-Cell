// Function to show toast message
function showToast(message, type) {
    const toast = document.getElementById('toast');
    toast.className = 'toast show ' + type; // Add class 'show' and type (success/error)
    toast.innerHTML = message;

    // Hide the toast after 2 seconds
    setTimeout(function () {
        toast.className = 'toast'; // Remove 'show' class after 2 seconds
    }, 2000);
}

document.getElementById('internshipForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const form = event.target;
    const formData = new FormData(form);

    // Send the form data to the server
    fetch(form.action, {
        method: form.method,
        body: formData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text(); // Assuming the server returns text
    })
    .then(data => {
        // Show success toast
        showToast('Application submitted successfully!', 'success');
        form.reset(); // Reset form after submission
    })
    .catch(error => {
        // Show error toast
        showToast('There was a problem submitting your application. Please try again later.', 'error');
    });
});
