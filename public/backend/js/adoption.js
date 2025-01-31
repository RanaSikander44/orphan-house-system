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
    function toggleButtons(tabId) {
        var totalTabs = $('.nav-pills .nav-item').length;
        var currentTabIndex = $('#menuTabs .nav-item').index($('#' + tabId).parent()) + 1;

        if (currentTabIndex === totalTabs) {
            $('#nextButton, #UpdateNextBtn').addClass('d-none');
            $('#adoptionFormBtn').removeClass('d-none');
        } else {
            $('#nextButton, #UpdateNextBtn').removeClass('d-none');
            $('#adoptionFormBtn').addClass('d-none');
        }
    }

    function validateFields(activePane) {
        var isValid = true;

        activePane.find('input[required], select[required], textarea[required]').each(function () {
            var $this = $(this);
            var value = $this.val().trim();

            if ($this.attr('type') === 'file') {
                if ($this.get(0).files.length === 0) {
                    isValid = false;
                    showError($this, "This file is required.");
                } else {
                    removeError($this);
                }
            } else if ($this.is('select')) {
                if ($this.val() === "" || $this.val() === null) {
                    isValid = false;
                    showError($this, "Please select an option.");
                } else {
                    removeError($this);
                }
            } else {
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

    function showError(element, message) {
        element.addClass('is-invalid');
        if (element.next('.invalid-feedback').length === 0) {
            element.after('<div class="invalid-feedback">' + message + '</div>');
        }
    }

    function removeError(element) {
        element.removeClass('is-invalid');
        element.next('.invalid-feedback').remove();
    }

    // 🛑 Stop forward tab switching if validation fails, but allow moving back
    $('.nav-pills .nav-link').on('show.bs.tab', function (e) {
        var activeTab = $('.nav-pills .nav-link.active');
        var activePane = $(activeTab.attr('href'));
        var currentIndex = $('.nav-pills .nav-link').index(activeTab);
        var targetIndex = $('.nav-pills .nav-link').index($(this));

        // Only validate if moving forward
        if (targetIndex > currentIndex && !validateFields(activePane)) {
            e.preventDefault(); // 🚨 Stops moving forward
            return false;
        }

        toggleButtons($(this).attr('id'));
    });

    // Next/Update Button Click - Move only if valid
    $('#nextButton, #UpdateNextBtn, #adoptionFormBtn').on('click', function (e) {
        var activeTab = $('.nav-pills .nav-link.active');
        var activePane = $(activeTab.attr('href'));

        if (!validateFields(activePane)) {
            e.preventDefault();
            return false;
        }

        var nextTab = activeTab.parent().next().find('.nav-link');

        if (nextTab.length) {
            nextTab.tab('show');  // ✅ Manually trigger Bootstrap tab switch
        }
    });

    $(document).on('input change', 'input[required], select[required], textarea[required]', function () {
        removeError($(this));
    });

    toggleButtons('homeTab');
});





// $('#homeTab').on('click', function () {
//     $('#nextButton').removeClass('d-none');
//     $('#UpdateNextBtn').removeClass('d-none');
//     $('#adoptionFormBtn').addClass('d-none');
// });
