import Swal from 'sweetalert2'

$(document).on('click', '.confirm', function (e) {
    e.preventDefault()
    e.stopPropagation()
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        animation: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = $(this).attr('data-url')
        }
    })
})
