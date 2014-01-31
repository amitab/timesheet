$(document).ready(function(){
            
    var startTime = null;
    var endTime = null;
    var interval;
    
    // in seconds
    var pauseTime = 0;
    var workTime = 0;
    var seconds = 0;
    
    function minuteUp() {
        var minute = parseInt($('#minute').text());
        var res;
        if(minute >= 59) hourUp();
        minute = (minute + 1) % 60;
        if(minute < 10) {
            res = '0' + minute
        } else res = minute;
        $('#minute').text(res);
    }
    
    function hourUp() {
        var hour = parseInt($('#hour').text());
        var res;
        hour++;
        if(hour < 10) {
            res = '0' + hour
        } else res = hour;
        $('#hour').text(res)
    }
    
    function logger(x) {
        console.log(x);
    }
    
    function startClock() {
        if(startTime == null) {
            startTime = new Date(Date.now());
            logger(startTime);
        }
        interval = setInterval(function(){
            workTime = (workTime+1) % 60;
            if(workTime == 0)
                minuteUp();
        }, 1000);
    }
    
    function setStopDate() {
        if(endTime == null) {
            endTime = new Date(Date.now());
            logger(endTime);
        }
    }
    
    function resultTime() {
        var elapsed = Math.round((endTime.getTime() - startTime.getTime()) / 1000); 
        var minute = parseInt($('#minute').text());
        var hour = parseInt($('#hour').text());
        var time = minute * 60 + hour * 3600 + workTime;
        
        var pauseTime = Math.round(elapsed - time);
        
        logger('Elapsed : ' + elapsed);
        logger('Work Time : ' + time);
        logger('Pause Time : ' + pauseTime);
    }
    
    function stopClock() {
        clearInterval(interval);
    }
    
    function finish() {
        var minute = parseInt($('#minute').text());
        var hour = parseInt($('#hour').text());
        
        var time = minute * 60 + hour * 3600 + workTime;
        $('input#work_time').val(time);
        $('input#start_time').val(startTime.getFullYear() + '-' + startTime.getDate() + '-' + startTime.getMonth() + ' ' + startTime.getHours() + ':' + startTime.getMinutes() + ':' + startTime.getSeconds());
        $('input#end_time').val(endTime.getFullYear() + '-' + endTime.getDate() + '-' + endTime.getMonth() + ' ' + endTime.getHours() + ':' + endTime.getMinutes() + ':' + endTime.getSeconds());
        $('form').append('<input type="hidden" name="from_timer_page" value="1" />');
        $('form').submit();
    }
    
    $('#start-button').click(function(e) {
        if($(this).hasClass('stopped')) {
            startClock();
            $(this).removeClass('stopped').addClass('started');
            $(this).parent().removeClass('secondary').addClass('danger');
            $(this).text("Stop");
            $('#pause-button').parent().removeClass('disabled');
        } else if($(this).hasClass('started')) {
            stopClock();
            setStopDate();
            resultTime();
            finish();
            $(this).removeClass('started').addClass('stopped');
            $(this).parent().removeClass('danger').addClass('secondary');
            $(this).text("Start");
            $('#pause-button').parent().addClass('disabled');
            
            $('#pause-button').text("Pause");
            $('#pause-button').parent().addClass('warning');
            $('#pause-button').removeClass('paused primary');
            
        }
        e.preventDefault();
    });
    
    $('#pause-button').click(function(e) {
        if($(this).parent().hasClass('disabled')) {
            e.preventDefault();
            return false;
        }
        if(!$(this).hasClass('paused')) {
            stopClock();
            $(this).text("Resume");
            $(this).parent().removeClass('warning');
            $(this).parent().addClass('primary');
            $(this).addClass('paused');
        } else {
            startClock();
            $(this).text("Pause");
            $(this).parent().addClass('warning');
            $(this).parent().removeClass('primary');
            $(this).removeClass('paused');
        }
    });
    
    
    
});