// Native5 Default Application Configuration
var app = (function (app, native5) {
    app.registry = new native5.core.ServiceRegistry();
    app.config = { 
        path:'timesheet',   // Change the path when developing locally - same as settings.yml
        method:'POST',
        mode:'ui'
    };
    
    $(document).ready(function() {
        
        var taskCount = 1;
        
        $(document).hammer().on('tap', '#add-task', function(e) {
            e.preventDefault();
            var data = '';
            data += '<section class="task" count="' + taskCount + '" new="true">';
            data += '<div class="title" style="text-align: center;margin-bottom: 10px;"><h5>Task</h5></div>'
            data += '<div class="append field">';
            data += '<input class="input" type="text" placeholder="Task completed" name="task_name" />';
            data += '<span class="adjoined"><i class="fa fa-check-circle"></i></span>';
            data += '</div>';
            data += '<div class="field">';
            data +=     '<label class="medium" for="start_date"><i class="fa fa-clock-o"></i>&nbsp;Start Time : </label>';
            data +=     '<input name="start_date" type="datetime-local" value="1996-12-19T16:39:57" readonly >';
            data += '</div>';
                    
            data += '<div class="field">';
            data +=     '<label class="medium" for="end_date"><i class="fa fa-clock-o"></i>&nbsp;End Time : </label>';
            data +=     '<input name="end_date" type="datetime-local" value="1996-12-19T16:39:57" >';
            data += '</div>';
            data += '<div class="field">';
            data += '<textarea class="input textarea" placeholder="Notes" name="description"></textarea>';
            data += '</div>';
            data += '<div class="corner-icon top-right remove-section"><i class="fa fa-times"></i></div>'
            data += '</section>';
            
            
            $('#page-wrap div.tasks').append(data);
            var scrollAmt = $('.task:last').offset().top - 100;
            jQuery("html, body").animate({
                scrollTop: scrollAmt
            }, 400);
            
            taskCount++;
        });
        
        function sendData(args, url) {
            var service =  new native5.core.Service(url, app.config);
        
            service.configureHandlers(
                function(data) {
                    if(data.message.everythingFine) { // success
                        
                    } else { // show warnings
                        $.each(data.message.warnings, function(key, value) {
                            $('.warnings').append(value);
                        });
                    }
                },
                function(err) {
                    console.log(err);
                }
            );
        
            service.invoke(args);
        }
        
        var timesheetid = parseInt($('#timesheetId').val());    // TIMESHEET ID(IF IT IS EDIT)
        var url = $('#timesheetId').attr('post-url');           // URL TO POST THE DATA
        
        $(document).on('click', '#save-sheet', function(e) {
            
            var args = [];
            if(timesheetid) {
                args.timesheetId = timesheetid;
            }
            
            $('section.add-timesheet').find('input, select').each(function(index) {
                
                if($(this).attr('name') == 'project') {
                    args.projectName = $(this).val();
                } else if($(this).attr('name') == 'start_date') {
                    args.startTime = $(this).val();
                } else if($(this).attr('name') == 'end_date') {
                    args.endTime = $(this).val();
                } else if($(this).attr('name') == 'location') {
                    args.location = $(this).val();
                } 
                
            });
            
            args.tasks = [];
            // save all edited\new tasks
            $('.tasks .task[new]').each(function(index) {
                
                var taskName;
                var startDate;
                var endDate;
                var notes;
                
                $(this).find('input, textarea').each(function(index) {
                    if($(this).attr('name') == 'task_name') {
                        taskName = $(this).val();
                    } else if($(this).attr('name') == 'start_date') {
                        startDate = $(this).val();
                    } else if($(this).attr('name') == 'end_date') {
                        endDate = $(this).val();
                    } else if($(this).attr('name') == 'description') {
                        notes = $(this).val();
                    } 
                });
                
                args.tasks.push({
                    'name' : taskName,
                    'start_date' : startDate,
                    'end_date' : endDate,
                    'notes' : notes
                });
            });
            
            console.log(args); // must send args to addsheet controller to update/create
            
        });
        
        $('.tasks').hammer().on('swipeleft', '.task', function(e) {
            
            alert("sup");
            e.gesture.preventDefault();
            
        });
        
    });
    
    return app;
})(app || {}, native5 || {});

