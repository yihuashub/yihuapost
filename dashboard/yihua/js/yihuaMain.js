//Created by yihua on 1/25/2017



function goBack() {
    window.history.back();
}

function initMap() {
    var niuvisionAdd = {lat: 49.8496158, lng: -97.1521062};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: niuvisionAdd
    });
    var geocoder = new google.maps.Geocoder();

    var image = {
        url: '../yihua/images/for-sale-sm.png',
    };

    var contentString = '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h1 id="firstHeading" class="firstHeading">平方米地产总部</h1>'+
        '<div id="bodyContent">'+
        '<p><b>平方米地产</b></p>'+
        '</div>'+
        '</div>';

    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });

    var marker = new google.maps.Marker({
        position: niuvisionAdd,
        map: map,
        icon: image,
        title: '平方米地产'
    });

    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

    document.getElementById('get-map').addEventListener('click', function() {
        geocodeAddress(geocoder, map);
    });
}

function geocodeAddress(geocoder, resultsMap) {
    var addNumber = document.getElementById('address-number').value;
    var addName = document.getElementById('address-name').value;
    var addSuffix = document.getElementById('address-suffix').value;

    var cityName = document.getElementById('city-list').value;
    if(cityName != null)
    {
        var address = addNumber+' '+addName+' '+addSuffix+','+cityName;
    }
    else
    {
        var address = addNumber+' '+addName+' '+addSuffix;
    }

    geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
            var image = {
                url: '../yihua/images/for-sale-sm.png',
            };
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: resultsMap,
                zoom: 15,
                icon: image,
                position: results[0].geometry.location
            });
        } else {
            $.confirm({
                closeIcon: true,
                theme: 'Modern',
                title: '抱歉',
                content: '错误: ' + status +' 地址：'+ address,
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: '好的',
                        btnClass: 'btn-red',
                        action: function(){
                        }
                    }
                }
            });
        }
    });
}




