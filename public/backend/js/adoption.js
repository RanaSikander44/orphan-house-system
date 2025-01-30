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



// Adoption Next Button Functionality

function toggleButtons() {
    var activeTab = $('.nav-pills .nav-link.active');

    var isLastTab = activeTab.parent().is(':last-child');

    if (isLastTab) {
        $('#nextButton').addClass('d-none');
        $('#UpdateNextBtn').addClass('d-none');
        $('#adoptionFormBtn').removeClass('d-none');
    } else {
        $('#nextButton').removeClass('d-none');
        $('#adoptionFormBtn').addClass('d-none');
    }
}

$('#nextButton').on('click', function () {
    var activeTab = $('.nav-pills .nav-link.active');
    var activePane = $(activeTab.attr('href'));

    var nextTab = activeTab.parent().next().find('.nav-link');
    var nextPane = $(nextTab.attr('href'));

    if (nextTab.length) {
        activeTab.removeClass('active');
        if (activeTab.find('.fa-check-double').length) {
            activeTab.find('.fa-check-double').remove();
            activeTab.append('<i class="fa-solid fa-check-double"></i>');
        } else {
            activeTab.append('<i class="fa-solid fa-check-double"></i>');
        }
        activePane.removeClass('show active');

        nextTab.addClass('active');
        nextPane.addClass('show active');
    }

    toggleButtons();
});


$('#UpdateNextBtn').on('click', function () {
    var activeTab = $('.nav-pills .nav-link.active');
    var activePane = $(activeTab.attr('href'));

    var nextTab = activeTab.parent().next().find('.nav-link');
    var nextPane = $(nextTab.attr('href'));

    if (nextTab.length) {
        activeTab.removeClass('active');
        // if (activeTab.find('.fa-check-double').length) {
        //     activeTab.find('.fa-check-double').remove();
        //     activeTab.append('<i class="fa-solid fa-check-double"></i>');
        // } else {
        //     activeTab.append('<i class="fa-solid fa-check-double"></i>');
        // }
        activePane.removeClass('show active');

        nextTab.addClass('active');
        nextPane.addClass('show active');
    }

    toggleButtons();
});

$('.nav-pills .nav-link').on('click', function () {
    toggleButtons();
});

$(document).ready(function () {
    toggleButtons();
});

