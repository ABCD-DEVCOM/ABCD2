var ContactUs = function () {
    return {
        //main function to initiate the module
        init: function () {
			var map;
			$(document).ready(function(){
			  map = new GMaps({
				div: '#map',
	            lat: -1.298342,
				lng: 36.786650,
			  });
			   var marker = map.addMarker({
		            lat: -1.298342,
					lng: 36.786650,
		            title: 'MixaKids.',
		            infoWindow: {
		                content: "<b>MixaKids Inc.</b><br> 2G, Commodore Office Suites<br>Kindaruma Road<br>Nairobi, Kenya"
		            }
		        });

			   marker.infoWindow.open(map, marker);
			});
        }
    };

}();