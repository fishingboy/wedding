(function ()
{
    function Wedding()
    {
        var sn;

        function init()
        {
            var _self = this;

            // 設定 sweet alert
            alert = swal;

            // 建立下拉選單
            this.buildGroupSelect();

            // 透明header底色轉換＋固定在頁面上方
            $(window).scroll(function() {
                if ( $(this).scrollTop() > 100){
                    $(".full-header-fixed").addClass("header-bg-white");
                }
                if ( $(this).scrollTop() < 1){
                    $(".full-header-fixed").removeClass("header-bg-white");
                }
            });

            // menu
            $(".header-menu").click(function(event) {
                _self.showMenu();
                event.stopPropagation();
            });
            $("html,body").click(function() {
                _self.hideMenu();
            });

            // 全螢幕照片
            $(".photo img, .photo .image-overlay").bind("click", function (event) {
                _self.fullScreen(event);
            });
            $("#overlay-close").bind("click", function (event) {
                _self.cancelFullScreen(event);
            });
            $("#overlay-prev").bind("click", function (event) {
                _self.prevPhoto();
            });
            $("#overlay-next").bind("click", function (event) {
                _self.nextPhoto();
            });

            // 倒數計時
            window.setInterval(_self.countDown, 1000);
        }

        function buildGroupSelect()
        {
            $.ajax
            ({
                type     : 'GET',
                dataType : 'json',
                async    : false,
                data     : {},
                url      : '/group/get',
                error    : function(xhr){
                },
                success  : function(data)
                {
                    $('#fm_group_id').html(' ');
                    $.each(data.groups, function (i, item) {
                        $('#fm_group_id').append($('<option>', {
                            value: item.id,
                            text : item.name
                        }));
                    });
                }
            });
        }

        function createGuest()
        {
            swal({
                title: "目前資料已經停止填寫囉！",
                text: "有什麼問題請直接連絡新郎新娘哦 ^^！"
            });
            return false;

            var name = $('#fm_name').val();
            // var email = $('#fm_email').val();
            var phone = $('#fm_phone').val();
            var group_id = $('#fm_group_id').val();
            var postal_code = $('#fm_postal_code').val();
            var address = $('#fm_address').val();
            var peoples = $('#fm_peoples').val();
            var vegan_peoples = $('#fm_vegan_peoples').val();
            var say = $('#fm_say').val();

            var guest_data = {
                name : name,
                // email : email,
                phone : phone,
                group_id : group_id,
                postal_code : postal_code,
                address : address,
                peoples : peoples,
                vegan_peoples : vegan_peoples,
                say : say
            };

            var _self = this;
            $.ajax
            ({
                type     : 'POST',
                dataType : 'json',
                async    : false,
                data     : guest_data,
                url      : '/guest/create',
                error    : function(xhr){
                },
                success  : function(data)
                {
                    if ( ! data.status) {
                        var error = data.msg.split("@@@");
                        var field = error[0];
                        var msg = error[1];
                        alert(msg);
                        swal({
                            title: "資料發生錯誤",
                            text: msg,
                            type: "warning"
                        }).then(function () {
                            $('#fm_' + field).focus();
                            _self.scroll('#fm_' + field, 300);
                        });
                        return false;
                    }
                    swal({
                            title: "感謝您的填寫",
                            text: "期待婚禮上見囉 ^^！",
                            type: "success"
                    }).then(function () {
                        $("html,body").animate({scrollTop: '0px'}, 500);
                        window.setTimeout(function () {
                            window.location.reload(true);
                        }, 500);
                    });
                }
            });
        }

        // 捲動效果
        function scroll(id, ms)
        {
            var top = $(id).offset().top - 70;
            var ms = ms || 1500;
            $("html,body").animate({scrollTop: top + 'px'}, ms);
            this.hideMenu();

            if (id == '#form') {
                $('#fm_name').focus();
            }
        }

        function fullScreen(event)
        {
            $(".photo-overlay").show();
            var element = $(event.currentTarget);
            console.log("element", element);
            var sn = element.attr("photo-sn");

            // 塞入圖片
            this.setFullScreenPhoto(sn);
        }

        function cancelFullScreen()
        {
            $(".photo-overlay").hide();
        }

        function nextPhoto()
        {
            if (this.sn == 7) {
                swal({
                    title: "沒有了唷",
                    text: "已經沒有下一張囉！"
                });
                return false;
            }
            this.setFullScreenPhoto(this.sn + 1);
        }

        function prevPhoto()
        {
            if (this.sn == 0) {
                swal({
                    title: "沒有了唷",
                    text: "已經沒有上一張囉！"
                });
                return false;
            }
            this.setFullScreenPhoto(this.sn - 1);
        }

        function setFullScreenPhoto(sn)
        {
            this.sn = parseInt(sn);
            console.log("sn", sn);
            $("#full-photo").css("background-image", "url(" + photos[sn].file + ")");
        }

        function showMenu()
        {
            // $(".full-header-fixed ul").slideDown();
            $(".full-header-fixed ul").removeClass("menu-items-hidden");
        }
        
        function hideMenu()
        {
            // $(".full-header-fixed ul").slideUp();
            $(".full-header-fixed ul").addClass("menu-items-hidden");
        }

        // 倒數計時
        function countDown()
        {
            var wedding_time = new Date("2018-06-03 12:30:00");
            var now = new Date();
            var diff = parseInt((wedding_time.getTime() - now.getTime()) / 1000);

            // 日
            var day = parseInt(diff / 86400);
            $("#countDown-Day").html(day);
            diff %= 86400;

            // 時
            var hour = parseInt(diff / 3600);
            $("#countDown-Hour").html(hour);
            diff %= 3600;

            // 分
            var minute = parseInt(diff / 60);
            $("#countDown-Minute").html(minute);

            // 秒
            var sec = diff % 60;
            $("#countDown-Sec").html(sec);
        }

        return {
            sn : sn,
            init : init,
            buildGroupSelect : buildGroupSelect,
            createGuest : createGuest,
            fullScreen : fullScreen,
            cancelFullScreen : cancelFullScreen,
            nextPhoto : nextPhoto,
            prevPhoto : prevPhoto,
            setFullScreenPhoto : setFullScreenPhoto,
            showMenu : showMenu,
            hideMenu : hideMenu,
            countDown : countDown,
            scroll : scroll
        }
    }

    window.wedding = new Wedding();
})(window);

// 呼叫
$(function () {
    wedding.init();

    $.fn.extend({
        underscore: function (object, data) {
            data = data || false;      // 設成 'auto' or false
            var template = _.template($(object).html()); // id => '#aaa-bbb'
            $(this).html(template(data));
        }
    });
});