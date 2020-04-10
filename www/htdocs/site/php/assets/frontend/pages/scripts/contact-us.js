var ContactUs = function () {
    return {
        //main function to initiate the module
        init: function () {
			var map;
			$(document).ready(function(){
			  map = new GMaps({
				div: '#map',
	            lat: 0.324979,
				lng: 32.591726,
			  });
			   var marker = map.addMarker({
		            lat: 0.324979,
					lng: 32.591726,
		            title: 'MixaKids.',
		            infoWindow: {
		                content: "<b>MixaKids.</b> Lower Kololo Terrace<br>Kampala Uganda"
		            }
		        });

			   marker.infoWindow.open(map, marker);
			});
        }
    };

}();