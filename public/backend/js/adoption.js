$('#DateOfBirth').on('change', function () {
    let dateOfBirth = $(this).val(); // Get the selected date of birth
    let minAge = parseInt($('#minAge').val(), 10); // Get the minimum age
    let maxAge = parseInt($('#maxAge').val(), 10); // Get the maximum age

    // Calculate the age based on the date of birth
    let today = new Date();
    let dob = new Date(dateOfBirth);
    let age = today.getFullYear() - dob.getFullYear();
    let monthDifference = today.getMonth() - dob.getMonth();

    // Adjust age if the birthday hasn't occurred yet this year
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
        age--;
    }

    // Validate the age
    if (age < minAge) {
        alert(`The age ${age} years is less than the minimum allowed age ${minAge} years.`);
        $(this).val(''); // Clear the input
    } else if (age > maxAge) {
        alert(`The age ${age} year is greater than the maximum allowed age ${maxAge} years.`);
        $(this).val(''); // Clear the input
    } else {
        $('#ChildAge').val(age);
    }
});
