$(document).on('click', '#showPassword', function() {
    let passwordElements = $('input[name*="password"]');
    passwordElements.each(function(index, element) {
        $(element).attr('type', $(element).attr('type') === 'password' ? 'text' : 'password')
    })
})
