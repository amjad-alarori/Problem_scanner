$(document).on('keyup', '.search_filter', function () {
    let searchQuery = $(this).val();
    let targets = $(this).attr('data-target');
    let index = 0;
    $(targets).each(function (i, element) {
        let text = $(element).children().text().toLowerCase();
        if (text.includes(searchQuery.toLowerCase())) {
            index++
            $(element).show()
        } else {
            $(element).hide()
        }
    });
    $('.search-no-results').remove()
    if (index === 0) {
        $(this).after('<h5 class="search-no-results mt-1">Geen resultaten</h5>')
        $(targets).each(function (i, element) {
            $(element).show()
        });
    }
})
