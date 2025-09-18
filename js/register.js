$(document).ready(function(){
    // Initialize country dropdown with flags
    $("#country").countrySelect({
        defaultCountry: "gh",  // Default to Ghana
        preferredCountries: ['gh', 'ng', 'us', 'gb'],
        responsiveDropdown: true
    });

    $('#register-form').submit(function(e){
        e.preventDefault();

        // Get form values
        var full_name = $('#full_name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var country = $('#country').countrySelect("getSelectedCountryData").name; // Get country name
        var city = $('#city').val();
        var contact = $('#contact').val();
        var role = $('input[name="role"]:checked').val() || 2;

        // Validation
        if(full_name == '' || email == '' || password == '' || !country || city == '' || contact == ''){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all fields!'
            });
            return;
        } else if(password.length < 8){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password must be at least 8 characters long'
            });
            return;
        } else if(!/^[a-zA-Z\s\-]{2,50}$/.test(city)){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter a valid city (letters and spaces only)'
            });
            return;
        }

        // AJAX request
        $.ajax({
            url: '../actions/register_user_action.php',
            type: 'POST',
            dataType: 'json',
            data: {
                full_name: full_name,
                email: email,
                password: password,
                country: country,
                city: city,
                contact: contact,
                role: role
            },
            success: function(response){
                if(response.status === 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    }).then((result) => {
                        if(result.isConfirmed && response.redirect){
                            window.location.href = response.redirect;
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error){
                console.error('Registration error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred! Please try again later.'
                });
            }
        });
    });
});