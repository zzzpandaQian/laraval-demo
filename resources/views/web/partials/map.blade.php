<script type="text/javascript">

  // 数据
  var points = {!! $dealers !!};

  // 在指定容器创建地图实例并设置最大最小缩放级别
  var map = new BMap.Map("allmap", {
      minZoom: 5,
      maxZoom: 19
  });

  //初始化地图，设置中心点和显示级别
  map.centerAndZoom("上海", 11);
  // map.centerAndZoom(new BMap.Point(116.316967, 39.990748), 15);

  var styleJson = [
  {
      "featureType": "land",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "color": "#091220ff"
      }
  }, {
      "featureType": "water",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "color": "#113549ff"
      }
  }, {
      "featureType": "green",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "color": "#0e1b30ff"
      }
  }, {
      "featureType": "building",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "building",
      "elementType": "geometry.fill",
      "stylers": {
          "color": "#666666b3"
      }
  }, {
      "featureType": "building",
      "elementType": "geometry.stroke",
      "stylers": {
          "color": "#dadadab3"
      }
  }, {
      "featureType": "subwaystation",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "color": "#b15454B2"
      }
  }, {
      "featureType": "education",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "color": "#e4f1f1ff"
      }
  }, {
      "featureType": "medical",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "color": "#f0dedeff"
      }
  }, {
      "featureType": "scenicspots",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "color": "#e2efe5ff"
      }
  }, {
      "featureType": "highway",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "weight": 4
      }
  }, {
      "featureType": "highway",
      "elementType": "geometry.fill",
      "stylers": {
          "color": "#f7c54dff"
      }
  }, {
      "featureType": "highway",
      "elementType": "geometry.stroke",
      "stylers": {
          "color": "#fed669ff"
      }
  }, {
      "featureType": "highway",
      "elementType": "labels",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "highway",
      "elementType": "labels.text.fill",
      "stylers": {
          "color": "#8f5a33ff"
      }
  }, {
      "featureType": "highway",
      "elementType": "labels.text.stroke",
      "stylers": {
          "color": "#ffffffff"
      }
  }, {
      "featureType": "highway",
      "elementType": "labels.icon",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "arterial",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "weight": 2
      }
  }, {
      "featureType": "arterial",
      "elementType": "geometry.fill",
      "stylers": {
          "color": "#d8d8d8ff"
      }
  }, {
      "featureType": "arterial",
      "elementType": "geometry.stroke",
      "stylers": {
          "color": "#ffeebbff"
      }
  }, {
      "featureType": "arterial",
      "elementType": "labels",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "arterial",
      "elementType": "labels.text.fill",
      "stylers": {
          "color": "#525355ff"
      }
  }, {
      "featureType": "arterial",
      "elementType": "labels.text.stroke",
      "stylers": {
          "color": "#ffffffff"
      }
  }, {
      "featureType": "local",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "weight": 1
      }
  }, {
      "featureType": "local",
      "elementType": "geometry.fill",
      "stylers": {
          "color": "#d8d8d8ff"
      }
  }, {
      "featureType": "local",
      "elementType": "geometry.stroke",
      "stylers": {
          "color": "#ffffffff"
      }
  }, {
      "featureType": "local",
      "elementType": "labels",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "local",
      "elementType": "labels.text.fill",
      "stylers": {
          "color": "#979c9aff"
      }
  }, {
      "featureType": "local",
      "elementType": "labels.text.stroke",
      "stylers": {
          "color": "#ffffffff"
      }
  }, {
      "featureType": "railway",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "weight": 1
      }
  }, {
      "featureType": "railway",
      "elementType": "geometry.fill",
      "stylers": {
          "color": "#123c52ff"
      }
  }, {
      "featureType": "railway",
      "elementType": "geometry.stroke",
      "stylers": {
          "color": "#12223dff"
      }
  }, {
      "featureType": "subway",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on",
          "weight": 1
      }
  }, {
      "featureType": "subway",
      "elementType": "geometry.fill",
      "stylers": {
          "color": "#d8d8d8ff"
      }
  }, {
      "featureType": "subway",
      "elementType": "geometry.stroke",
      "stylers": {
          "color": "#ffffff00"
      }
  }, {
      "featureType": "subway",
      "elementType": "labels",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "subway",
      "elementType": "labels.text.fill",
      "stylers": {
          "color": "#979c9aff"
      }
  }, {
      "featureType": "subway",
      "elementType": "labels.text.stroke",
      "stylers": {
          "color": "#ffffffff"
      }
  }, {
      "featureType": "continent",
      "elementType": "labels",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "continent",
      "elementType": "labels.icon",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "continent",
      "elementType": "labels.text.fill",
      "stylers": {
          "color": "#333333ff"
      }
  }, {
      "featureType": "continent",
      "elementType": "labels.text.stroke",
      "stylers": {
          "color": "#ffffffff"
      }
  }, {
      "featureType": "city",
      "elementType": "labels.icon",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "city",
      "elementType": "labels",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "city",
      "elementType": "labels.text.fill",
      "stylers": {
          "color": "#454d50ff"
      }
  }, {
      "featureType": "city",
      "elementType": "labels.text.stroke",
      "stylers": {
          "color": "#ffffffff"
      }
  }, {
      "featureType": "town",
      "elementType": "labels.icon",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "town",
      "elementType": "labels",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "town",
      "elementType": "labels.text.fill",
      "stylers": {
          "color": "#454d50ff"
      }
  }, {
      "featureType": "town",
      "elementType": "labels.text.stroke",
      "stylers": {
          "color": "#ffffffff"
      }
  }, {
      "featureType": "road",
      "elementType": "geometry.fill",
      "stylers": {
          "color": "#12223dff"
      }
  }, {
      "featureType": "poilabel",
      "elementType": "labels",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "districtlabel",
      "elementType": "labels",
      "stylers": {
          "visibility": "off"
      }
  }, {
      "featureType": "road",
      "elementType": "geometry",
      "stylers": {
          "visibility": "on"
      }
  }, {
      "featureType": "road",
      "elementType": "labels",
      "stylers": {
          "visibility": "off"
      }
  }, {
      "featureType": "road",
      "elementType": "geometry.stroke",
      "stylers": {
          "color": "#ffffff00"
      }
  }, {
      "featureType": "district",
      "elementType": "labels",
      "stylers": {
          "visibility": "off"
      }
  }, {
      "featureType": "poilabel",
      "elementType": "labels.icon",
      "stylers": {
          "visibility": "off"
      }
  }, {
      "featureType": "poilabel",
      "elementType": "labels.text.fill",
      "stylers": {
          "color": "#2dc4bbff"
      }
  }, {
      "featureType": "poilabel",
      "elementType": "labels.text.stroke",
      "stylers": {
          "color": "#ffffff00"
      }
  }, {
      "featureType": "manmade",
      "elementType": "geometry",
      "stylers": {
          "color": "#12223dff"
      }
  }, {
      "featureType": "districtlabel",
      "elementType": "labels.text.stroke",
      "stylers": {
          "color": "#ffffffff"
      }
  }, {
      "featureType": "entertainment",
      "elementType": "geometry",
      "stylers": {
          "color": "#ffffffff"
      }
  }, {
      "featureType": "shopping",
      "elementType": "geometry",
      "stylers": {
          "color": "#12223dff"
      }
  }
  ];
  map.setMapStyle({styleJson:styleJson});

  //开启鼠标滚轮缩放功能，仅对PC上有效
  map.enableScrollWheelZoom(true);

  // 将控件（平移缩放控件）添加到地图上
  map.addControl(new BMap.NavigationControl());

  //添加标注
  addMarker(points);

  // 创建图标对象
  function addMarker(points) {
      var point, marker;
      // 创建标注对象并添加到地图
      for (var i = 0, pointsLen = points.length; i < pointsLen; i++) {
          point = new BMap.Point(points[i].longitude, points[i].latitude);
          var myIcon;
          // 判断正常或者故障，根据不同装填显示不同Icon
          myIcon = new BMap.Icon("{{ asset('images/logo-1.png') }}", new BMap.Size(32, 32), {
              // 指定定位位置
              offset: new BMap.Size(16, 32),
              // 当需要从一幅较大的图片中截取某部分作为标注图标时，需要指定大图的偏移位置
              //imageOffset: new BMap.Size(0, -12 * 25)
          });
          // 创建一个图像标注实例
          marker = new BMap.Marker(point, {
              icon: myIcon
          });
          // 将覆盖物添加到地图上
          map.addOverlay(marker);

          //给标注点添加点击事件
          (function() {
              var thePoint = points[i];
              marker.addEventListener("click", function() {
                  showInfo(this, thePoint);
              });
          })();
      }
  };

  //显示信息窗口，显示标注点的信息
  function showInfo(thisMaker, point) {
    var infoHtml = '';

    infoHtml += '<ul class="map_info_ul">';
    infoHtml += '   <li>';
    infoHtml += '       <span class="info_span">名称：</span>';
    infoHtml += '       <span>' + point.title + '</span>';
    infoHtml += '   </li>';
    infoHtml += '   <li>';
    infoHtml += '       <span class="info_span">电话：</span>';
    infoHtml += '       <span>' + point.tel + '</span>';
    infoHtml += '   </li>';
    infoHtml += '   <li>';
    infoHtml += '       <span class="info_span">简介：</span>';
    infoHtml += '       <span>' + point.description + '</span>';
    infoHtml += '   </li>';
    infoHtml += '   <li>';
    infoHtml += '       <div class="btn" onclick=func("' + point.title + '")>' + "按钮" + '</div>';
    infoHtml += '   </li>';
    infoHtml += '</ul>';

    // 创建信息窗口对象
    var infoWindow = new BMap.InfoWindow(infoHtml);

    //图片加载完毕重绘infowindow
    thisMaker.openInfoWindow(infoWindow);
  };

  // 弹窗增加点击事件
  function func(data) {
      alert("点击了：" + data + "\n");
  }
</script>
