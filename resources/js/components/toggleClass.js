$(document).on('click', '.toggleclass', function() {
    if($(this).hasClass($(this).attr('toggle-class'))) {
        $(this).removeClass($(this).attr('toggle-class'))
    } else {
        $(this).addClass($(this).attr('toggle-class'))
    }
})
