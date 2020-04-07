$(document).ready(function() {
    /************** Handles counterup plugin wrapper ****************/
    let handleCounterup = function() {
        if (!$().counterUp) {
            return;
        }

        $("[data-counter='counterup']").counterUp({
            delay: 10,
            time: 1000
        });
    };
    handleCounterup()

    let select = new SlimSelect({
        select: '#students',
        closeOnSelect: false,
        hideSelectedOption: true
    });
    let empId = '';
    $('.btn-assign').on('click', function(event) {
        // clear select
        select.set([])
        //
        let tr = $(this).closest('tr'),
            lecName = tr.find('td:nth-child(2)').text();
        empId = $.trim(tr.find('td:nth-child(1)').text())
        $('.lec-name').text(lecName)

    });

    $('#assign-form').on('submit', function(event) {
        event.preventDefault();
        if (select.selected().length < 1) {
            toastr.error("Please select at least one Project", "Sorry", {
                showMethod: "slideDown",
                hideMethod: "fadeOut"
            });
        } else {
            $form = $(event.target);
            let formData = {}
            formData['emp_id'] = empId;
            formData['projects'] = select.selected()

            $.ajax({
                url: '../api/project/',
                data: JSON.stringify({assign : {...formData}}),
                method: 'PATCH',
                dataType: 'json',
                processData: false,
                contentType: 'application/merge-patch+json',
                success: function (data) {
                    toastr.success(data.success.message, "Bravoo!", {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    });
                    // clear select
                    select.set([])
                    //close modal
                    $('#myModal').modal('hide');
                },
                error: function (data) {
                    let message = 'Some unexpected error occurred';
                    try{
                        message = data['responseJSON']['error']['message'];
                    }catch (e) {
                        console.error(message)
                    }
                    toastr.error(message, "Ooops!", {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    });

                    // clear select
                    select.set([])
                    //close modal
                    $('#myModal').modal('hide');
                }

            });
        }
    });

});