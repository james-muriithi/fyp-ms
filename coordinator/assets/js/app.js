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

    $('#btn-assign').on('click', function(event) {
        // clear select
        select.set([])
        //
        let tr = $(this).closest('tr'),
            empId = $.trim(tr.find('td:nth-child(1)').text()),
            lecName = tr.find('td:nth-child(2)').text()
        $('.lec-name').text(lecName)

    });

    $('#assign-form').on('submit', function(event) {
        event.preventDefault();
        if (select.selected().length < 1) {
            // alert("Please select atleast one student");
            Swal.fire({ 
            	title: "Sorry!",
            	text: "Please select atleast one student!",
            	type: "warning",
    	      	confirmButtonColor: "#02a499", 
    	      })
        } else {

        }
    });

});