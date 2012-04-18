jQuery(function($) {
        $.getJSON('http://www.tritonetech.com/php_uploads/rnd/gmt.php', function(json) {
                var select = $('#city-list');
 
                $.each(json.Result.Data, function(i, v) {
			var loc=String(v.Location);
			var temp=new Array();
			temp=loc.split(",");
			
			for(j=0;j<temp.length;j++)
			{
                        var option = $('<option />');
			

                        option.attr('value', v.gmt_id)
                              .html("<div style='clear: both;'><p style='float:left;'>"+temp[j]+"</p><p style='float:right;'>"+v.gmt+"</p></div>")
                              .appendTo(select);
			}
                });
        });
});
