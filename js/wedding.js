(function ()
{
    function Wedding()
    {
        function init()
        {
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

        }

        return {
            init : init,
            buildGroupSelect : buildGroupSelect,
            createGuest : createGuest
        }
    }

    window.wedding = new Wedding();
})(window);

// 呼叫
$(function () {
    wedding.init();
});