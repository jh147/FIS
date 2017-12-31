define(function (require, exports, module) { 
	require('/js/common/grid.js');

	$('#agent_grid').grid({
        url: '/agent/agent-list',
        idField: 'id',
        templateid: 'agent_grid_template',
        pagesize: 20,
        scrollLoad: false,
        setEmptyText: function () {
            return '没有数据';
        },
        method: 'post',
        queryParams: function () {
            return 'start_station='+$.trim($('#start_station').val());
        }
    });

	$('#editAgent').click(function(){
		location.href = "/agent/edit/"
	});
})