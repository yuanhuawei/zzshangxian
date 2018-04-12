function add_favorite(jobid,jobname, company){
	$.ajax({
		url: P8CONFIG.URI.talent.student.controller+'-favorite',
		data: 'jobid='+jobid+'&jobname='+jobname+'&company='+company,
		type: 'post',
		beforeSend: function(){ ajaxing({}); },
		success: function(msg){
			if(msg==1){ ajaxing({action:'hide',text:'收藏成功'});}
			else if(msg==2){ ajaxing({action:'hide',text:'你己收藏过了'});}
			else{ ajaxing({action:'hide',text:'未知错误'});}
		}
	});

}