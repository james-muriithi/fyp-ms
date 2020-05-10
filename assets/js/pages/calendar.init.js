window.addEventListener('DOMContentLoaded', async function () {
    if (window.$){
        let categories = await fetch('../api/upload-category/')
            .then(res => res.json())
            .then(res => {
                let tempArr = []
                res.forEach((item) => {
                    item.deadline = new Date(item.deadline)
                    tempArr.push({
                        id: item.id,
                        title: item.name,
                        start: item.start_date,
                        end: item.deadline.setDate(item.deadline.getDate()+1),
                        allDay: true,
                        description: item.description
                    })
                })
                return tempArr
            })
        let cal = $('#calendar').fullCalendar({
            customButtons: {
                myCustomButton: {
                    text: 'Google Calendar',
                    click: function() {
                        if (categories.length > 0){
                            let cal = ics();
                            categories.forEach(category => {
                                let temp = new Date(category['end'])
                                let end = temp.setDate(temp.getDate()-1)
                                cal.addEvent(category['title'], category['description'], 'Pwani University', category['start'], end);
                            })
                            cal.download('Project Uploads')
                        }else{
                            toastr.error('There are no events yet.', "Oops!", {
                                showMethod: "slideDown",
                                hideMethod: "fadeOut"
                            });
                        }
                    }
                }
            },
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'myCustomButton'
            },
            defaultView: 'month',
            eventDurationEditable: false,
            editable: true,
            exclusive: true,
            allDay: true,
            eventRender: function(event, element, view) {
                let endDate = new Date(event.end._d).toLocaleDateString()
                let remainigDays = (new Date(endDate) - new Date().setHours(0,0,0,0))/60/60/24/1000 - 1
                if (remainigDays <= 3){
                    element.addClass('bg-danger')
                }
                if (remainigDays < 0){
                    element.find('.fc-title').text(`${event.title} - Past Due Date`)
                }
            },
            eventMouseover: function(event, jsEvent){
                $(this).popover({
                    title: event.title,
                    placement: 'top',
                    trigger: 'hover focus',
                    content: event.description,
                    container: '#calendar'
                }).popover('show')
            },
            events: categories
        });
    }
})
