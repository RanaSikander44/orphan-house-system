$(document).ready(function () {
    $('#select-school , #select-nanny').on('change', function () {
        let school_id = $('#select-school').val();
        let nanny_id = $('#select-nanny').val();

        let data = {
            _token: window.routes.csrfToken,  // Using the global csrfToken
            nanny_id: nanny_id ? nanny_id : 'null',
            school_id: school_id ? school_id : 'null'
        };

        $.post({
            url: window.routes.filterActivity,  // Using the global filterActivity route
            data: data,
            success: function (response) {
                $('#child_id').empty();

                if (response && response.length > 0) {
                    response.forEach(function (child) {
                        $('#child_id').append(
                            $('<option>', {
                                value: child.id,
                                text: child.first_name + ' ' + child.last_name + ' (' + child.age + ' years old)'
                            })
                        );
                    });
                } else {
                    $('#child_id').append('<option disabled>No children found</option>');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });
    });
});

$('#clear-filters').on('click', function () {
    $('#select-school').val('').trigger('change');
    $('#select-nanny').val('').trigger('change');

    $.post({
        url: window.routes.filterActivity,  // Using the global filterActivity route
        data: {
            nanny_id: 'null',
            school_id: 'null',
            _token: window.routes.csrfToken,  // Using the global csrfToken
        },
        success: function (response) {
            $('#child_id').empty();
            $('#child_id').append('<option value="">-- Select Child --</option>');

            if (response && response.length > 0) {
                response.forEach(function (child) {
                    $('#child_id').append(
                        $('<option>', {
                            value: child.id,
                            text: child.first_name + ' ' + child.last_name + ' (' + child.age + ' years old)'
                        })
                    );
                });
            } else {
                $('#child_id').append('<option disabled>No children found</option>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred while resetting the filters.');
        }
    });
});
