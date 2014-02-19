$(document).ready(function(){
            
    var startTime = null;
    var endTime = null;
    var interval;
    
    // in seconds
    var pauseTime = 0;
    var workTime = 0;
    var seconds = 0;
    
    var ua = navigator.userAgent,
    clickevent = (ua.match(/iPad/i) || ua.match(/iPhone/i) || ua.match(/Android/i)) ? "touchstart" : "click";
    
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
    
    $(document).on(clickevent, '#start-button', function(e) {
        if($(this).hasClass('stopped')) {
            startClock();
            $(this).removeClass('stopped').addClass('started');
            $(this).removeClass('icon-control-play').addClass('icon-check');
            $('#pause-button').removeClass('disabled');
        } else if($(this).hasClass('started')) {
            stopClock();
            setStopDate();
            resultTime();
            finish();
            $(this).removeClass('started').addClass('stopped');
            $(this).removeClass('icon-check').addClass('icon-control-play');
            $('#pause-button').addClass('disabled');
            
        }
        e.preventDefault();
    });
    
    $(document).on(clickevent, '#pause-button', function(e) {
        if($(this).hasClass('disabled')) {
            e.preventDefault();
            return false;
        }
        if(!$(this).hasClass('paused')) {
            stopClock();
            $(this).removeClass('icon-control-pause').addClass('paused icon-control-play');
        } else {
            startClock();
            $(this).addClass('icon-control-pause').removeClass('paused icon-control-play');
        }
    });
    
    $(document).hammer().on('tap', '#add-task', function(e) {
        window.location.href = $('form').attr('action') + '&project_id=' + $('input#project_id').val();
        //console.log($('form').attr('action') + '&project_id=' + $('input#project_id').val());
        return false;
    });
    
});