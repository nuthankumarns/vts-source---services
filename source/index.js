/**
 * @author nuthan
 */


  
  //demos.Tabs = new Ext.TabPanel({
Ext.setup({
    icon: 'icon.png',
    glossOnIcon: false,
       onReady: function() {
       	
       	 var map = new Ext.Map({
		    geo:new Ext.util.GeoLocation({
		      autoUpdate:false,
		      timeout:1000,
		      listeners:{
		        locationupdate: function(geo) {
		          var center = new google.maps.LatLng(geo.latitude, geo.longitude);
		
		          if (map.rendered)
		            map.update(center)
		          else
		            map.on('activate', map.onUpdate, map, {single: true, data: center});
		        },
		        locationerror: function(geo){
		          alert('got geo error');          
		        }
		      }
		    })
		  });
		
        new Ext.TabPanel({
            fullscreen: true,
            type: 'dark',
            sortable: true,
            items: [{
                title: 'Tab 1',
                html: '1',
                cls: 'card1'
            }, {
                title: 'Tab 2',
                xtype:'map',
                useCurrentLocation: true,
                fullscreen:true,
		    layout:'fit',
                cls: 'card2'
            }, {
                title: 'Tab 3',
                html: '3',
                cls: 'card3'
            }]
        });
        
		      //  Ext.reg('map', Ext.Map);
		  /*var panel = new Ext.Panel({
		   // fullscreen:true,
		    layout:'fit',
		    items:map
		  });*/
    }
});

  