$(document).on('keyup', '.search_filter', function () {
    let searchQuery = $(this).val();
    let targets = $(this).attr('data-target');
    let index = 0;
    $(targets).each(function (i, element) {
        let text = $(element).children().text()
        if (text.includes(searchQuery)) {
            index++
            $(element).show()
        } else {
            $(element).hide()
        }
    });
    $('.search-no-results').remove()
    if (index === 0) {
        $(this).after('<h5 class="search-no-results mt-1">Geen resultaten</h5>')
    }
})
