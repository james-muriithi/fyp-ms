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

    $('.btn-view').on('click', function(event){
        event.preventDefault();
        let tr = $(this).closest('tr'),
            lecName = tr.find('td:nth-child(1)').text();
        empId = $.trim(tr.data('lec'))
        $('#viewModal .lec-name').text(lecName)
        console.log(lecName)
        $.ajax({
            type: 'get',
            data: {supervisor: empId},
            headers:{
                'Content-Type': 'application/json'
            },
            url: '../api/project/',
            success: data =>{
                try{
                    data = JSON.parse(data)
                    const selectedArr = data['assignedArr']

                    // let newTrs = []
                    $('table.view-table tbody').empty();
                    selectedArr.forEach(proj => {
                        let status = proj['status'],
                            className = 'badge-warning';
                        if (status == 'complete'){
                            className = 'badge-success'
                        }else if(status == 'rejected'){
                            className = 'badge-danger'
                        }

                        let newTr = `<tr>
                                        <td>${proj['title']}</td>
                                        <td>${proj['category']}</td>
                                        <td>${proj['reg_no']}</td>
                                        <td>
                                        ${proj['full_name']}
                                        </td>
                                        <td><span class="badge ${className}">${status}</span></td>
                                       </tr>`
                        $('table.view-table tbody').append(newTr);
                    })
                }catch (e) {
                    console.log(e)
                }
            },
            error : data =>{
                console.log(data)
            }
        })
    })

    $('.btn-view-uploads').on('click', function(event){
        event.preventDefault();
        let tr = $(this).closest('tr'),
            catName = tr.find('td:nth-child(1)').text(),
            category = $.trim(tr.data('id'))
        $('#viewModal .lec-name').text(catName)
        $.ajax({
            type: 'get',
            data: {category},
            headers:{
                'Content-Type': 'application/json'
            },
            url: '../api/project/',
            success: data =>{
                try{
                    data = JSON.parse(data)

                    // let newTrs = []
                    $('table.view-table tbody').empty();
                    data.forEach(proj => {
                        let badge = 'badge-warning',
                            approved = 'Pending';
                        if (proj['approved'] == 1){
                            badge = 'badge-success'
                            approved = 'Approved';
                        }else if (proj['approved'] == 2){
                            badge = 'badge-danger'
                            approved = 'Rejected';
                        }
                        let newTr = `<tr>
                                        <td>
                                        <a href="#" class="text-underline">${proj['name']}</a>
                                        </td>
                                        <td>${proj['upload_time']}</td>
                                        <td>${proj['reg_no']}</td>
                                        <td>
                                        ${proj['full_name']}
                                        </td>
                                        <td>
                                        <span class="badge ${badge}">${approved}</span>
                                        </td>
                                       </tr>`
                        $('table.view-table tbody').append(newTr);
                    })
                }catch (e) {
                    console.log(e)
                }
            },
            error : data =>{
                console.log(data)
            }
        })
    })

    $('.btn-view-p-uploads').on('click', function(event){
        event.preventDefault();
        let tr = $(this).closest('tr'),
            catName = tr.find('td:nth-child(2)').text(),
            pid = tr.find('td:nth-child(1)').text()
        $('#viewModal .project_name').text(catName)
        $.ajax({
            type: 'get',
            data: {project_id: pid},
            headers:{
                'Content-Type': 'application/json'
            },
            url: '../api/project/',
            success: data =>{
                console.log(data)
                try{
                    data = JSON.parse(data)

                    // let newTrs = []
                    $('table.view-table tbody').empty();
                    data.forEach(proj => {
                        let badge = 'badge-warning',
                            approved = 'Pending';
                        if (proj['approved'] == 1){
                            badge = 'badge-success'
                            approved = 'Approved';
                        }else if (proj['approved'] == 2){
                            badge = 'badge-danger'
                            approved = 'Rejected';
                        }
                        let newTr = `<tr>
                                        <td>
                                        <a href="#" class="text-underline">${proj['name']}</a>
                                        </td>
                                        <td>${proj['upload_time']}</td>
                                        <td>${proj['deadline']}</td>
                                        <td>
                                        <span class="badge ${badge}">${approved}</span>
                                        </td>
                                       </tr>`
                        $('table.view-table tbody').append(newTr);
                    })
                }catch (e) {
                    console.log(e)
                }
            },
            error : data =>{
                console.log(data)
            }
        })
    })

    $('#assign-form').on('submit', function(event) {
        event.preventDefault();
        if (select.selected().length < 0) {
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
                        hideMethod: "fadeOut",
                        onHidden: function () {
                            location.reload();
                        }
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