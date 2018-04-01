(function ()
{
    function Wedding()
    {
        function init()
        {
            // 設定 sweet alert
            alert = swal;

            // 建立下拉選單
            this.buildGroupSelect();
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
            var email = $('#fm_email').val();
            var phone = $('#fm_phone').val();
            var group_id = $('#fm_group_id').val();
            var postal_code = $('#fm_postal_code').val();
            var address = $('#fm_address').val();
            var peoples = $('#fm_peoples').val();
            var vegan_peoples = $('#fm_vegan_peoples').val();

            var guest_data = {
                name : name,
                email : email,
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
                    alert("感謝你的填寫！");
                }
            });
        }

        // 捲動效果
        function scroll(id)
        {
            var top = $(id).offset().top - 70;
            $("html,body").animate({scrollTop: top + 'px'}, 1500);
        }

        return {
            init : init,
            buildGroupSelect : buildGroupSelect,
            createGuest : createGuest,
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