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


$(document).ready(function () {
    // Function to toggle buttons based on the current tab's position
    function toggleButtons(tabId) {
        // Check if the current tab is the last one by using the ID of the tab
        var totalTabs = $('.nav-pills .nav-item').length;
        var currentTabIndex = $('#menuTabs .nav-item').index($('#' + tabId).parent()) + 1;

        // Check if it is the last tab
        if (currentTabIndex === totalTabs) {
            $('#nextButton').addClass('d-none');
            $('#UpdateNextBtn').addClass('d-none');
            $('#adoptionFormBtn').removeClass('d-none');
        } else {
            $('#nextButton').removeClass('d-none');
            $('#UpdateNextBtn').removeClass('d-none');
            $('#adoptionFormBtn').addClass('d-none');
        }
    }

    // Function to validate fields in the active tab pane
    function validateFields(activePane) {
        var isValid = true;

        activePane.find('input[required], select[required], textarea[required]').each(function () {
            var $this = $(this);
            var value = $this.val().trim();

            // Handle file inputs separately
            if ($this.attr('type') === 'file') {
                if ($this.get(0).files.length === 0) {
                    isValid = false;
                    showError($this, "This file is required.");
                } else {
                    removeError($this);
                }
            }
            // Handle select inputs separately
            else if ($this.is('select')) {
                if ($this.val() === "" || $this.val() === null) {
                    isValid = false;
                    showError($this, "Please select an option.");
                } else {
                    removeError($this);
                }
            }
            // Handle all other input types
            else {
                if (value === '') {
                    isValid = false;
                    showError($this, "This field is required.");
                } else {
                    removeError($this);
                }
            }
        });

        return isValid;
    }

    // Show validation error
    function showError(element, message) {
        element.addClass('is-invalid');
        if (element.next('.invalid-feedback').length === 0) {
            element.after('<div class="invalid-feedback">' + message + '</div>');
        }
    }

    // Remove validation error
    function removeError(element) {
        element.removeClass('is-invalid');
        element.next('.invalid-feedback').remove();
    }

    // Next and Update Button Click - Validate Before Moving
    $('#nextButton, #UpdateNextBtn ,#adoptionFormBtn , #adoptionFormBtn').on('click', function (e) {
        var activeTab = $('.nav-pills .nav-link.active');
        var activePane = $(activeTab.attr('href'));

        // Prevent moving forward if validation fails
        if (!validateFields(activePane)) {
            e.preventDefault();  // Stop default action
            return false;  // Exit function
        }

        var nextTab = activeTab.parent().next().find('.nav-link');
        var nextPane = $(nextTab.attr('href'));

        if (nextTab.length) {
            activeTab.removeClass('active');
            activePane.removeClass('show active');
            nextTab.addClass('active');
            nextPane.addClass('show active');
        }

        toggleButtons(nextTab.attr('id'));  // Update button visibility based on the next tab
    });

    // Handle tab click to update button visibility
    $('.nav-pills .nav-link').on('click', function () {
        var tabId = $(this).attr('id');
        toggleButtons(tabId);  // Toggle button visibility based on clicked tab
    });

    // Remove error messages when user starts typing or selecting
    $(document).on('input change', 'input[required], select[required], textarea[required]', function () {
        removeError($(this));
    });

    // Initialize button visibility based on the first tab when page loads
    toggleButtons('homeTab');  // You can pass any tab ID you want to initialize the buttons with
});



// $('#homeTab').on('click', function () {
//     $('#nextButton').removeClass('d-none');
//     $('#UpdateNextBtn').removeClass('d-none');
//     $('#adoptionFormBtn').addClass('d-none');
// });
