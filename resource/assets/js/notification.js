let n = new Audio();
(n.src = base_url + "resource/tmp/notification.mp3"),
    "denied" !== Notification.permission && Notification.requestPermission(),
    setInterval(function () {
        "denied" !== Notification.permission && Notification.requestPermission(),
            $.ajax({
                url: base_url + "lead/get_followup_notification",
                type: "POST",
                data: { push: !0 },
                success: function (t) {
                    if (((data = JSON.parse(t)), "success" === data.status)) {
                        for (let t = 0; t < data.n.length; t += 1) {
                            $.notify(data.n[t].followup_desc, { title: data.n[t].followup_status_id + "[ Commented By - " + data.n[t].commented_by + " ]", icon: "<?=base_url()?>favicon.ico", closeTime: 25e3 }).click(function () {
                                location.href = data.n[t].lead_id;
                            }),
                                n.play();
                            $.post(base_url+"lead/mark_notified", {followup_id:data.n[t].followup_id}).done(function(data){
                               // 
                            });
                        }
                    }
                },
            });
    }, 4e4),
    setInterval(function () {
        "denied" !== Notification.permission && Notification.requestPermission(),
            $.ajax({
                url: base_url + "task/get_task_notification",
                type: "POST",
                data: { push: !0 },
                success: function (t) {
                    if (((data = JSON.parse(t)), "success" === data.status)) {
                        for (let t = 0; t < data.n.length; t += 1) {
                            $.notify(data.n[t].task_name + " : - " + data.n[t].description, { title: data.n[t].task_status, icon: base_url + "favicon.ico", closeTime: 25e3 }).click(function () {
                                location.href = data.n[t].task_id;
                            }),
                            n.play();
                            $.post(base_url+"task/mark_notified", {task_id:data.n[t].id}).done(function(data){
                               // 
                            });
                        }
                    }
                },
            });
    }, 4e4);
