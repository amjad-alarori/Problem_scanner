require('./bootstrap');
require('./components')
// function showPassword() {
//     var x = document.getElementById("password");
//     if (x.type === "password") {
//         x.type = "text";
//     } else {
//         x.type = "password";
//     }
// }

$(document).on('click', '#showPassword', function() {
    let passwordElements = $('input[name*="password"]');
    passwordElements.each(function(index, element) {
        $(element).attr('type', $(element).attr('type') === 'password' ? 'text' : 'password')
    })
})
