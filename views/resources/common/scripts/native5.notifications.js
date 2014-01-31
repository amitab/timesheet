/*jshint loopfunc:true, quotmark:false */
/*global jQuery:false, Notification:false */
var native5 = (function($, native5) {
    "use strict";
    native5.Notifications = native5.Notifications || {};
    var notificationQueue = [];

    native5.Notifications.requestPermission = function() {
        if (!("Notification" in window)) {
            return;
        } else if("webkitNotifications" in window) {
            if (window.webkitNotifications.checkPermission() === 0) {
                return;
            } else {
                window.webkitNotifications.requestPermission();
            }
        }
    };

    native5.Notifications.show = function(message, options) {
		var msg = message || "";
        var opts = options || {};
        var type = opts.notificationType || "web";

        notificationQueue.push({message: msg, opts: opts, type: type});
        enqueNotifier();
    };

    var enqueNotifier = function() {
		if(notificationQueue && notificationQueue.length > 0) {
	        var notification = null;
	        var opts = notificationQueue[0].opts;
	        var message = notificationQueue[0].message;
	        var notificationType = opts.notificationType || "web";
	        var persistent = false;
	        var timeout = opts.timeout || 3000;

            if(notificationType === "progress") {
                persistent = true;
            }

            persistent = opts.persistent || persistent;

			if(!notificationQueue[0].notifier) {
				if (!("Notification" in window) || notificationType === "toast" || notificationType === "progress") {
		            notification = toastNotification(message, opts);
		            notificationQueue[0].notifier = notification;
                    if(notificationType === "web") {
                        notificationQueue[0].type = "toast";
                    }
		        } else if("webkitNotifications" in window) {
					if (window.webkitNotifications.checkPermission() === 0) {
						notification = webNotification(message, opts);
	                    notificationQueue[0].notifier = notification;
				    } else {
					    window.webkitNotifications.requestPermission();
					}
		        } else {
		            Notification.requestPermission(function (permission) {
		                if (permission == 'granted') {
		                    notification = webNotification(message, opts);
		                    notificationQueue[0].notifier = notification;
		                }
		            });
		        }

		        if(!persistent) {
		            setTimeout(function() {
		                native5.Notifications.hide();
		            }, timeout);
		        }
		    }
	    }
    };

    native5.Notifications.hide = function() {
		if(notificationQueue[0] && notificationQueue[0].notifier) {
			if(notificationQueue[0].type === "web") {
				notificationQueue[0].notifier.close();
			} else {
				notificationQueue[0].notifier.remove();
	            if(notificationQueue[0].opts.onRemove && typeof notificationQueue[0].opts.onRemove === "function") {
	                notificationQueue[0].opts.onRemove();
	            }
				notificationQueue.splice(0, 1);
				enqueNotifier();
			}
	    }
    };

    native5.Notifications.update = function(opts) {
        if(notificationQueue[0] && notificationQueue[0].notifier) {
            if(notificationQueue[0].type === "progress") {
                var elm = notificationQueue[0].notifier[0];
                if(opts && opts.progressText) {
                    $(".toast-message", elm).text(opts.progressText);
                }
                if(opts && opts.progressComplete) {
                    $(".progress-bar", elm).width(opts.progressComplete);
                }
            }
        }
    };

    var deleteWebNotification = function() {
		notificationQueue.splice(0, 1);
		enqueNotifier();
    };

    var webNotification = function(message, options) {
        var opts = options || {};
        var title = opts.title || "";
        var content = message || "";
        var messageType = opts.messageType || "";
        var onShow = opts.onShow || null;
        var onRemove = opts.onRemove || null;
        var imageStr = "";
        var notification = null;

        switch (messageType) {
            case "success":
                imageStr = success;
                break;
            case "error":
                imageStr = error;
                break;
            case "warning":
                imageStr = warning;
                break;
            case "info":
                imageStr = info;
                break;
            default:
            	imageStr = n5default;
            	break;
        }

        notification = new Notification(title, {
            body: content,
            icon: imageStr
        });

        if(onShow && typeof onShow === "function") {
            notification.onshow = function() {
                onShow();
            };
        }

        notification.onclose = function() {
            notification = null;
            if(onRemove && typeof onRemove === "function") {
                onRemove();
            }
            deleteWebNotification();
        };

        return notification;
    };

    var toastNotification = function(message, options) {
        var opts = options || {};
        var title = opts.title || "";
        var content = message || "";
        var messageType = opts.messageType || "n5default";
        var position = opts.position || "top";
        var onShow = opts.onShow || null;
        var progressText = opts.progressText || "Loading...";
        var progressComplete = opts.progressComplete || "0%";

        var notification = $("<div>")
            .addClass("toast-container " + position);

        if(opts.notificationType === "progress") {
            notification.append("<div class='toast-body'><div class='toast-image " + messageType + "'></div><div class='toast-cancel'>x</div><div class='toast-title'>" + title + "</div><div><div class='progress-container'><div class='progress-bar'></div></div><div class='toast-message'>" + progressText + "</div></div></div>");
            $(".toast-cancel", notification).on("click", function() {
                native5.Notifications.hide();
            });
            $(".progress-bar", notification).width(progressComplete);
        } else {
            notification.append("<div class='toast-body'><div class='toast-image " + messageType + "'></div><div class='toast-cancel'>x</div><div class='toast-title'>" + title + "</div><div><p class=\"small\">" + content + "</p></div></div>");
            $(".toast-cancel", notification).on("click", function() {
                native5.Notifications.hide();
            });
        }

        if(onShow && typeof onShow === "function") {
            onShow();
        }

        notification.hide().appendTo($("body")).fadeIn(500);
        setupNotifier();

        return notification;
    };

    var setupNotifier = function() {
    	$(".toast-container").css({
            "font-family": "Helvetica",
    		"position": "fixed",
			"z-index": "1200",
			"background": "#fff",
			"right": "1%",
			"width": "350px",
			"box-shadow": "1px 1px 2px #aaa, -1px 0px 2px #aaa",
			"font-size": "1em",
			"min-height": "75px"
    	});
    	$(".top").css("top", "1%");
    	$(".bottom").css("bottom", "1%");
    	$(".toast-title").css({
    		"font-size": "1em",
    		"color": "#000"
    	});
    	$(".toast-body").css({
    		"padding": "5px",
		    "color": "#666",
		    "font-size": "1em"
    	});
        $(".toast-message").css({
            "margin-top": "5px",
            "font-size": "0.875em"
        });
    	$(".toast-cancel").css({
    		"height": "16px",
		    "width": "16px",
		    "background-size": "cover",
		    "display": "inline-block",
		    "float": "right",
		    "font-weight": "bold",
		    "text-align": "center",
		    "line-height": "14px"
    	});
    	$(".toast-cancel").hover(
    		function() {
	    		$(this).css({
		    		"border-radius": "8px",
					"background-color": "#888",
					"color": "#fff"
		    	});
	    	},
	    	function() {
	    		$(this).css({
		    		"border-radius": "0px",
					"background-color": "#fff",
					"color": "#666"
		    	});
	    	}
    	);
    	$(".toast-image").css({
    		"float": "left",
		    "height": "75px",
		    "width": "75px",
		    "background": "#fafafa",
		    "margin": "-5px 10px 0 -5px"
    	});
    	$(".n5default").css({
    		"background-image": "url(" + n5default + ")",
		    "background-repeat": "no-repeat",
		    "background-position": "50%"
    	});
    	$(".error").css({
    		"background-image": "url(" + error + ")",
		    "background-repeat": "no-repeat",
		    "background-position": "50%"
    	});
    	$(".warning").css({
    		"background-image": "url(" + warning + ")",
		    "background-repeat": "no-repeat",
		    "background-position": "50%"
    	});
    	$(".success").css({
    		"background-image": "url(" + success + ")",
		    "background-repeat": "no-repeat",
		    "background-position": "50%"
    	});
    	$(".info").css({
    		"background-image": "url(" + info + ")",
		    "background-repeat": "no-repeat",
		    "background-position": "50%"
    	});
        $(".progress-container").css({
            "margin": "5px 0 0 80px",
            "height": "10px",
            "overflow": "hidden",
            "border" : "1px solid rgb(101, 101, 124)"
        });
        $(".progress-bar").css({
            "background-color": "#428bca",
            "height": "10px",
            "-webkit-transition": "all linear 500ms",
            "-moz-transition": "all linear 500ms",
            "-ms-transition": "all linear 500ms",
            "transition": "all linear 500ms",
        });
    };

    var n5default = "data:image/png;base64,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";
    var error = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAFhklEQVR4Xp2Xa2wU5RfGn3dmdre3LexuYQlpS+UqxBTxA0kpYgwJiUUjiZoY0BiQ+MXglkAb/uGPHyQmcinQ77ZE4ycTE7xgoonRCFolCtIoBMFqixIu2y3d3bbbuR3f82bcXSezC/Fpnrx5Z848vzmn7e6MODu/GfchIf2o9GbpTuml0jEoYUL6mvS30p9In1ndf4BQQQ3PvwKWgerSpLsh0Fe/uBWNq5ai/oEWRJpi0OtqwHKmC8nZ9ERy6vc/O7OXrvZMjYzhYurgHgAnVh/f7yJQ1cHbIcRgfG075m/sgBECKJOGO/kXnJtXYdsWWEKeCNXWId4WQ+KRLvDh218M9WXODfdd3P3mjvZj/zuJAFUa9Rvh+NwDrS88jUjYhXN9BDQzDSFKcy8XwVsJEPIm9JbFmDU1jL33IczM3YPtR/e9Dk/RF1+tCD7RsKQ11fLcJuCPK3BzkwooIPzQYDj/EKBF5wBtKzD2/meYGrne3364t1uBX9oVOOpD0WVtqdYtj8H55QfANqH5gKI6uVhLk+OAzGh7diPGTn2VGu49bLa/tbc36He8PTIv1tvc1QHr4vcQIGnV6n8TAeTMwPrpOzQ/sQ4jE5M9w/uOXu7cnjpZDtaFJgabn9wA5/J5CMdmqOouk04jl82C1djYiERTE1jCa52Iil2Oy9qsVxuVtbEE15LM/BGcPfLOR4PfJFve7bx13fHASMUeXgkjPQoyZ0vQTAa5XA7JD4bAuvVMB5PQlEiUj1UpPT6ObEBtLBYHObMqmxmZ85dSAI5pgOL0xZcvAN1NQzgO4NjsciiLQ1V4Os11dtG8zwbU8vVQNY7Kji9Pglmya8HgDfWtC6HdGQUkVIW5KhBBUvB8HncyGQ7llfcKFCQvi7MlYwzMYqYBoKuhOQHK31Jjo7L5RWtreWQM88PVcbiE7MxMIJTPR2trQNwtQYnyOTQ0JzE1eqOLwetqwi5QsIr/LsKbf6I2AkFuNXhlaCSCBINtlVuER+pcXjoYvMww8zwKhpZJqH2iJgx48IWnzqFcvPfrxpa1aIyEJDSsuvVmCOHBQ8wCljM4JmZyINsGiRK0fEmEDB6rCl10+gIqaXTzGjTK2ri0yiPGsgnkgZnFTAaDCtNqpAgEe3BDAKSp8KWf/wy/rm16CI2GpurIsX2fZlRcmMVi8IRpu0lDI7jM8hneOmG5yDsuVn55BUHi45cfX8GDwdyQBlZQx7bMYCaDrxYcIxkR1r+hvCG1R9Z2MSOh7WdHUE18fnj9YjgAooYP7oFnHUaavzJ4aNYy1uu6WdYlQZBQ8GkJLbiENUOj8OtCxyL/cd6r4y4R6nTN67UMbOlgpgbgdCHvwHIBywEkB440r/l7QCOaUCvLD591ia8vZnE2Mwp5NepPueOvzcwUzAYdeqhs1CCYVaAhIZRdUb1znUrdOhZgTkwz+IzmTWFPIafBIoIlYTaxESgVJgBNmut51T14kGwvk2uZAaI98tvJZTCr37prwypAAS1lKoLKoQIswXVFEwREQC3L8mo4mxnM8j/67BA1+oA+3wW00kenLlSoEilXEJWuYbnSDhGI1AbObQ1UcHbKbgf8TyCD8sSDdlr0oAlMZbgaFXCfz1wE/18xwE5LF5wjC7q3DVR6vO3FNIXpjkg5TQShoSiB0g0EqQQsiVxATwuIGeqfl9rW61D15+puWWjqN9FjxQkU9j/gkR8N8u8JECYQykioRUcSqa29rq+q2ivMy9Jv2/WAFSW4RvATph+o2RKYEzCmwNoZe23rAMq0av+he75J8AUnZcBuY0octSOAXUOww+omit9kwoMZpoQVpGfB2it9fM6ura5L8Cmo4+rvUOuln5JeJ73E99L2m/fS9rH02agEooLa/686xt8gRfp7cTKuIQAAAABJRU5ErkJggg==";
    var warning = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAgNJREFUeNrEl98rQ2EYx98dixRbrVwZpUgm5U6UXEgREZFSyoXcunUhSqT4D2RRuCA3RFxSau3ODVZcjUXJaksR8+P76Nkcp+2c8x7b2bc+nfOuvef7/nze53U8eauFpGpBCT9vwAc456dpOU38h0y6wTDo4HI6nYJjsAEiRh916PS4EEyCKeCR6MwHm0/rNUDJ8HslCIIlSVNSARgDIdArY9zGpo3if6Ip2eMRM5xjMjsCxSJ7WuRRWMjU4zJwYGRaNDQgPLfXKRRvuRnzee2wq43XgOFXPu8iumUdbXHn/hh38pbJpWjOZ7TGM8IeTYCqpLEPNNtkXMhb7ce4V9ir/qRxm0ytxMXVb4i6DFkxbgBuhYO9aX3F42nfJeVT1EvcRnkUndMmp1uLjGN5MI6RcTgPxmGFswcpJVfzeyBoxfSFMhc6nc7AqEzN19U1oVR4RcKaMWUqb5SB0EF/z1HFDo0DP/U4CtY5jhrK4XIJZ31dqiw53HSUbasTgTkwYmZrkWnpzmaqHK2okTGmZOBZfTpRS5ZzPMS0iFfSJQLUmv0cmT6CPnXurU1v3eAkC4medvu0g4BelklRrJUT86wECtCiNc2U3tLkd4FZbq1VHYKmTAFK0alIK52WrJ82vIRhgEetBzxYucJoEzW6Nw3y+V3Gt40YX9yiPD27ZmP/twADAHDRdVcYn4fAAAAAAElFTkSuQmCC";
    var success = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyRpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoTWFjaW50b3NoKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyM0RFQ0ZGOTU0NUUxMUUyQjM5OUY0ODE3NkUxMTBDNyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyM0RFQ0ZGQTU0NUUxMUUyQjM5OUY0ODE3NkUxMTBDNyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjIzREVDRkY3NTQ1RTExRTJCMzk5RjQ4MTc2RTExMEM3IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjIzREVDRkY4NTQ1RTExRTJCMzk5RjQ4MTc2RTExMEM3Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+rsaiTwAAA7pJREFUeNqkl8tu00AUhsfjpISLhHmDsGeRik1bKjXZsqkRSySIn6DNE6R9gqZPkHSH2DQIxDap1KogFnERe/ICCKstudvmP+5MOjF27SQjjaw49nxzbv8ca77vszTjy881AxcTM4+5Ffr7BLOL2Xz57KuTZj0tCQxgEZcdAU0zmpiH2EB7ITCAZFkdsyjvTVzGRmONuZ7GPF+zNeY7nLMC13xjJeuzjD6zBIEtbKCbGgxoGZcDTHIv6w81TG5PPO2IFixvntrhdxqnm2ZW97fv3/PM3IpviNvk9grgjUSwgNalhVc93R67WgWwdho/YwNGLuvtPsh5VcUDVhg+A1ahZOVVX28AaLEFBjZQePLIrWczfiEKPgWLmHbIvQJqAdpgSwyyHvCWgJPbV2XMufIcWWqQe3tDXlsWSgNrOICWPC8oNUN6c2qxKJkW3fhzpdtv1s9WFwFhnV1ctkU5Naf11VkvIutb4meJSk1avCPjSom0IHRPVAIZcUww+Z+5ek6JGXgQ1lcDVyuKxIZj3k6bvSEovV9V7yFkO6HHDgMgZ8UP3zfyZHGQdS6JwySo03mhBTV2NChf+yM+Ixxwry1klUFwTC6VaeJqUu7mgcqEMdT7zrVuQ932I14JhAf1vZWRd1xkHmVhzOJkVTdC/urSY3Jc9nQHeWJFrYVxQWH1fGZMywm+78bo9S+R8R3hVvnfQfjg6A00NhgFUPvOAwJeziR4M6+4ka4tAEvCyl31QTo8rgf6PqCJ4YJ32RTMtchnwu4yZL3PLOSSiznJ614C87G4drnMNPX4UzMRtd2IgBtqBiOuNo7JNPUfhArPBuAgHnSevv+2UQg/+fr5uRUBnw5oOiXTq5hkCidpUYiIzdX6wjka2WXEwUUyEbSbwlpThmUw5icyq4+E1e/i3grDSV6RTJU5lC5QtsGIO5SAElwTiZQXmhsL/32p70Mg2nAxQWtz6Hie8mEw1g5nzuNPF2t7uj7V21JSszanpNI5z6773MGR+5TyYaYD+fxjrUPNm7C+JOK/LJTKz6A6d/7eekltBGhHFoLvKGJhLgE1JXRyW+e12GaPSuphzmvB7YbSJ1fi2tQYmaWQlWXDiJxovH1xZiW2twRHhh+jvPJqC4X5kdrb8NeCUqPbEijLDTH9D3pnQx+0qSv+AVrVMolLhJTaihoZYd0G0MH5bsVpd+InDDaQxwaqWR0byPhM12OE/6aRAJR3hzcNRe0uNdPSfrSRB4Q7C/DCzEcblMgRZ20z6UiU458AAwCfUgvWMBDLhwAAAABJRU5ErkJggg==";
    var info = "data:image/png;base64,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";

    return native5;
}(jQuery, native5 || {}));
