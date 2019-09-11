layui.config({
	base : '/res/js/'
}).use(['table', 'form', 'jquery'],function(){

	var table = layui.table;
	// test-table
	table.render({
		elem : '#test-table',
		method: 'post',
		height : 312,
		cellMinWidth: 80,	//全局定义单元格最小宽度
		url : 'default/index',
		page : true,
		cols : [[
			//表头
			{field:'id', title:'ID', sort:true},
			{field:'username', title:'用户名'},
			{field:'six', title:'性别', sort:true},
			{field:'score', title:'评分', sort:true, align:'right'}
		]],
		// data : [
		// 	{"id":1, "username":"zhangsan", "six":0, "score":102},
		// 	{"id":2, "username":"zhangsan2", "six":1, "score":1023},
		// 	{"id":3, "username":"zhangsan3", "six":2, "score":122},
		// 	{"id":4, "username":"zhangsan4", "six":0, "score":12},
		// ]
	});
});