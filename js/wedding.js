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
            $("#overlay-priv").bind("click", function (event) {
                _self.privPhoto();
            });
            $("#overlay-next").bind("click", function (event) {
                _self.nextPhoto();
            });
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
            var name = $('#fm_name').val();
            // var email = $('#fm_email').val();
            var phone = $('#fm_phone').val();
            var group_id = $('#fm_group_id').val();
            var postal_code = $('#fm_postal_code').val();
            var address = $('#fm_address').val();
            var peoples = $('#fm_peoples').val();
            var vegan_peoples = $('#fm_vegan_peoples').val();

            var guest_data = {
                name : name,
                // email : email,
                phone : phone,
                group_id : group_id,
                postal_code : postal_code,
                address : address,
                peoples : peoples,
                vegan_peoples : vegan_peoples
            };

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
                            type: "warning",
                        }).then(function () {
                            $('#fm_' + field).focus();
                        });
                        return false;
                    }
                    swal({
                            title: "感謝您的填寫",
                            text: "期待婚禮上見囉 ^^！",
                            type: "success",
                    }).then(function () {
                        window.location.reload(true);
                    });
                }
            });
        }

        // 捲動效果
        function scroll(id)
        {
            var top = $(id).offset().top - 70;
            $("html,body").animate({scrollTop: top + 'px'}, 1500);
            this.hideMenu();
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
            var next_sn = this.sn + 1;
            next_sn = (next_sn > 8) ? 1 : next_sn;
            this.setFullScreenPhoto(next_sn);
        }

        function privPhoto()
        {
            var priv_sn = this.sn - 1;
            priv_sn = (priv_sn < 1) ? 8 : priv_sn;
            this.setFullScreenPhoto(priv_sn);
        }

        function setFullScreenPhoto(sn)
        {
            this.sn = sn;
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

        return {
            sn : sn,
            init : init,
            buildGroupSelect : buildGroupSelect,
            createGuest : createGuest,
            fullScreen : fullScreen,
            cancelFullScreen : cancelFullScreen,
            nextPhoto : nextPhoto,
            privPhoto : privPhoto,
            setFullScreenPhoto : setFullScreenPhoto,
            showMenu : showMenu,
            hideMenu : hideMenu,
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