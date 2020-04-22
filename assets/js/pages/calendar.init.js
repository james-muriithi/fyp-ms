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
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month'
            },
            defaultView: 'month',
            eventDurationEditable: false,
            editable: true,
            exclusive: true,
            allDay: true,
            eventRender: function(event, element, view) {
                let endDate = new Date(event.end._d).toLocaleDateString()
                if (Math.abs(new Date(endDate) - new Date().setHours(0,0,0,0))/60/60/24/1000 <= 3){
                    element.addClass('bg-danger')
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
