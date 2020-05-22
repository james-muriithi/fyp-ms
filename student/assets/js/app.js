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
                data: JSON.stringify({assign : formData}),
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

    //search
    $("#search-friends").on("keyup", function() {
        var g = $(this).val().toLowerCase();
        $(".userlist-box .media-body .chat-header").each(function() {
            var s = $(this).text().toLowerCase();
            $(this).closest('.userlist-box')[s.indexOf(g) !== -1 ? 'show' : 'hide']();
        });
    });

    $('.displayChatbox').on('click', function() {
        $('.showChat').removeClass('slideOutRight');
        $('.showChat').addClass('animated slideInRight');
        $('.showChat').css('display', 'block')
    });

    //close
    $('.back_friendlist').on('click', function() {

        $('.showChat').toggleClass('slideInRight');
        $('.showChat').toggleClass('slideOutRight');
    });

    let sender,recipient, profile,username, myInterval = '';
//    user on click
    $('.userlist-box').on('click', function() {
        username = $(this).data('username');
        profile = $(this).data('profile');
        sender = $(this).data('empid');
        recipient = $(this).data('recipient');
        $('.main-friend-chat').html('');
        $('.showChat_inner .media-object').attr('src', profile);
        $('.showChat_inner .user-name').text(username);

        $.ajax({
            url: '../api/message/',
            method: 'GET',
            cache: false,
            data: {conversation: true, sender, recipient},
            success: function (data) {
                try{
                   const messages = data.success.message.messages;

                   appendConvo(messages)
                    markRead(sender, recipient)

                }catch (e) {
                    console.log(e)
                }
            },
            error: function (error) {
                console.log(error)
            }
        })

        $('.showChat_inner').removeClass('slideOutRight');
        $('.showChat_inner').addClass('animated slideInRight');
        $('.showChat_inner').css('display', 'block');
        scrollChat()
        $('#chat-message').focus();
        console.log(sender)
        myInterval = setInterval(function () {
            fetchNewMessages(sender, recipient)
        },5000)
    });
//    chat close
    $('.back_chatBox').on('click', function() {
        $('.showChat_inner').toggleClass('slideInRight');
        $('.showChat_inner').toggleClass('slideOutRight');
        clearInterval(myInterval);
    });
    //text area autosize
    $('#chat-message').on('keydown', function () {
        $(this). css( 'height','0px');
        let height = Math.min(20 * 5, $(this)[0].scrollHeight);
        $(this). css('height',  height + 'px');
    });

    $('#chat-form').on('submit', function (event) {
        event.preventDefault();
        $('#chat-message').focus();
        let newMessage = $('#chat-message').val().trim();
        if (newMessage){
            if (sendMessage(recipient, newMessage, sender)){
                appendMessage(newMessage);
            }
            $('#chat-message').val('');
        }
    })

    let a = $(window).height() - 80;
    $(".main-friend-list").slimScroll({ height: a, allowPageScroll: false,
        wheelStep: 8, color: '#5A5EB9', disableFadeOut: true });
    a = $(window).height() - 155;
    $(".main-friend-chat").slimScroll({
        height: a, allowPageScroll: false, wheelStep: 8, start: 'bottom',
        color: '#5A5EB9',  alwaysVisible: true
    });

    let appendConvo = (messages)=>{
        messages.forEach(message =>{
            let msg;
            if (message.sender == recipient){
                msg = `\
                           <div class="media chat-messages">
                        <div class="media-body chat-menu-reply">
                            <div class="">
                                <p class="chat-cont">${message.message}</p>
                            </div>
                            <p class="chat-time">${message.created_at}</p>
                        </div>
                    </div>
                           `
            } else{
                msg = `\
                       <div class="media chat-messages">
                        <div class="media-body chat-menu-content pl-3">
                            <div class="">
                                <p class="chat-cont">${message.message}</p>
                            </div>
                            <p class="chat-time">${message.created_at}</p>
                        </div>
                    </div>
                       `
            }
            $('.main-friend-chat').append(msg);
            scrollChat();
        })
    }

    let appendMessage = (message) => {
        const d = new Date()
        const hour = ("0" + d.getHours()).slice(-2)
        const minute = ("0" + d.getMinutes()).slice(-2)
        const time = `${hour}:${minute}`
        const msg = `\
                    <div class="media chat-messages">
                        <div class="media-body chat-menu-reply">
                            <div class="">
                                <p class="chat-cont">${message}</p>
                            </div>
                            <p class="chat-time">${time}</p>
                        </div>
                    </div> `
        $('.main-friend-chat').append(msg);
        scrollChat();
    }

    let sendMessage = (sender,message,  recipient) =>{
        return $.ajax({
            url: '../api/message/',
            method: 'POST',
            data: {new_message:  {message, sender, recipient}},
            success: function (data) {
                try{
                    const m = data.success.message;
                    return true;
                }catch (e) {
                    let m = 'Some unexpected error occurred';
                    console.log(e)
                    toastr.error(m, "Ooops!", {
                        showMethod: "slideDown",
                        hideMethod: "fadeOut"
                    });
                    return false;
                }
            },
            error: function (error) {
                let m = 'Some unexpected error occurred';
                try{
                    m = error['responseJSON']['error']['message'];
                }catch (e) {
                    console.error(m)
                }
                toastr.error(m, "Ooops!", {
                    showMethod: "slideDown",
                    hideMethod: "fadeOut"
                });
                return false;
            }
        })
    }

    let markRead = (sender, recipient) =>{
        $.ajax({
            url: '../api/message/',
            method: 'POST',
            data: {mark_as_read:  {sender, recipient}},
            success: function (data) {

            },
            error: function (error) {
                console.log(error)
            }
        })
    }

    let fetchNewMessages = (sender, recipient) =>{
        $.ajax({
            url: '../api/message/',
            method: 'GET',
            cache: false,
            data: {new_messages: true, sender, recipient},
            success: function (data) {
                try{
                    const messages = data.success.message.messages;
                    appendConvo(messages)
                    markRead(sender, recipient)

                }catch (e) {
                    console.log(e)
                }
            },
            error: function (error) {
                console.log(error)
            }
        })
    }

    let scrollChat = () => {
        $(".main-friend-chat").animate({ scrollTop: $(".main-friend-chat")[0].scrollHeight}, 1000);
    }

});