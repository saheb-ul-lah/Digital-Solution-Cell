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
        // Handle success, e.g., show a success message or redirect
        console.log('Success:', data);
        alert('Application submitted successfully!');
        form.reset(); // Reset form after submission
    })
    .catch(error => {
        // Handle error
        console.error('Error:', error);
        alert('There was a problem submitting your application. Please try again later.');
    });
});
