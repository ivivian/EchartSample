<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<META HTTP-EQUIV="Pragma" CONTENT="no-cache"> 
	<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache"> 
	<META HTTP-EQUIV="Expires" CONTENT="0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/jquery/1.9.1/jquery.min.js"></script>
    <title>Echart Show Sample</title>
    <style type="text/css">
        BODY {-webkit-font-smoothing:antialiased;background-color:#fff;font-family:Microsoft YaHei,tahoma,arial,Hiragino Sans GB,\\5b8b\4f53,sans-serif;color:#666}
        table,div,tr,td,input,button,span,select,option,tbody {font-size:16px;font-family:Microsoft YaHei,tahoma,arial,Hiragino Sans GB,\\5b8b\4f53,sans-serif;padding:0px;}
        .smallside{margin: 0px;padding: 0px;}
        .zeroside{margin: 0px;padding: 0px;}
        .total-box {
            border-radius: 3px;
            border:1px solid #eee;
            color: white;
            font-size: 20px;
        }
        .total-box-title {border:0px;background: #11a7e4;margin:0px;padding: 0px 5px;}
        .total-box-main1 {border-left-color:#27a3d7;border-left-width:20px;background: #54b5df;margin:0px;padding: 10px;}
        .total-box-main2 {border-left-color:#76af3a;border-left-width:20px;background: #91c757;margin:0px;padding: 10px;}
        .total-box-main3 {border-left-color:#f79319;border-left-width:20px;background: #f9a94a;margin:0px;padding: 10px;}
        h4 {color: black;text-align: center;}
        .ftitle{font-size:24px;line-height: 180%;}
        .top{background: #a2d0d9;color:black;}
        .top1{background: #d9534f;color:black;}
        .top2{background: #f57288;color:black;}
        .top3{background: #f49eac;color:black;}
    </style>
</head>
<body>
<div class="container-fluid zeroside">
    <div class="row-fluid">
        <div class="col-sm-12 col-md-12 col-lg-12 alert alert-success total-box-title total-box">
            <div class="col-sm-6 col-md-6 col-lg-6 ftitle">
                <b>
                    Echart Show Title
                </b>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 smallside text-right"><p id="p_updatetime"></p></div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div id="total_month" class="alert alert-info total-box total-box-main1">
			
            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div id="total_today" class="alert alert-warning total-box total-box-main2">

            </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div id="tatal_today_out" class="alert alert-danger total-box total-box-main3">

            </div>
        </div>
    </div>
    <div class="row-fluid">
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div id="list_area"></div>
            <div id="list_area_qty"></div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4" >
            <div id="list_plat_title"style="padding-bottom: 0px;margin-bottom: 0px;"></div>
            <div id="list_plat" style="overflow:hidden;height:210px;"></div>
            <div id="list_plat_fix_title"style="padding-bottom: 0px;margin-bottom: 0px;"></div>
            <div id="list_plat_fix" style="overflow:hidden;height:175px;"></div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
            <div id="list_item"></div>
            <div id="list_item_today"></div>
        </div>
		</div>
    <div class="row-fluid">
        <div class="col-sm-12 col-md-12 col-lg-12 text-center total-box total-box-title">
            zzv.cn 2017
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="echarts-all-3.js"></script>
<script type="text/javascript">
    //scroll variable
    var ftop=1;
    var itemrow=30;//list_plat total rows
    var fixrow=20;//list_plat_fix total rows
    var i,j;

    $(document).ready(function(){//DOMReady start
        loadData();//First executed once, the content will be displayed
        setInterval(loadData, 300*1000);//every 300 seconds executed once
        setInterval(Marqueehq,60);//list_plat and list_plat_fix content scrolls
    });
    function Marqueehq(){
        ftop=ftop+1;
        i=ftop%(100+24*(itemrow-5));
        j=ftop%(100+24*(fixrow-6));
        if(ftop>=1000*5){
            ftop=1;
        }else{
            if(i<100){
                list_plat.scrollTop=1;
            }
            else
                list_plat.scrollTop=i-99;

            if(j<100) {
                list_plat_fix.scrollTop = 1;
            }
            else
                list_plat_fix.scrollTop=j-99;
        }
    }
    function loadData(){
        $('#p_updatetime').html('Last Update:'+getNowFormatDate());
        //get data
        $.get('data.php?ftype=1', function(data){
            var j=0;
            var ret = [];
            var arrdata=data.split("###");
            var map1='';
            var mapx='';
            var mapy='';
            var mapz='';

            var objtotal = eval('(' + arrdata[0] + ')');
            $.each(objtotal, function(i, entry){
                $('#total_month').html('<span class=\"glyphicon glyphicon-signal\"></span> Month Bill:'+entry['fbill']+' Qty:'+entry['fqty']);
                $('#total_today').html('<span class=\"glyphicon glyphicon-eye-open\"></span> Today Bill:'+entry['fbill_today']+' Qty:'+entry['fqty_today']);
                $('#tatal_today_out').html('<span class=\"glyphicon glyphicon-edit\"></span> Today Done Qty:'+entry['fqty_out']);
            });

            var objarea = eval('(' + arrdata[1] + ')');
            $.each(objarea, function(i, entry){
                j=j+1;

                if(map1!='')map1=map1+',';
                map1=map1+"{name:'"+entry['fname']+"',value:"+entry['fqty']+"}";

                if(mapx!='')mapx=mapx+',';
                mapx=mapx+"'"+entry['fname']+"'";
                if(mapy!='')mapy=mapy+',';
                mapy=mapy+entry['fbill'];
                if(mapz!='')mapz=mapz+',';
                mapz=mapz+entry['fqty'];
            });
            showareamap(map1);
            showareamapqty(mapx,mapy,mapz)

            var objplat = eval('(' + arrdata[2] + ')');
            itemrow=objplat.length;
            var htmltitle='';
            ret=[];
            j=0;
            $.each(objplat, function(i, entry){
                j=j+1;
                var fclass=getclass(j);
                if(j<=3)
                {
                    htmltitle += '<tr class="' + fclass + '">';
                    htmltitle += '<td width="35px">' + entry['fid'] + '</td>';
                    htmltitle += '<td>' + replaceplatname(entry['fname']) + '</td>';
                    htmltitle += '<td width="50px">' + entry['fbill'] + '</td>';
                    htmltitle += '<td width="60px">' + entry['fqty'] + '</td>';
                    htmltitle += '</tr>';
                }
                else {
                    var html = '<tr class="' + fclass + '">';
                    html += '<td width="35px">' + entry['fid'] + '</td>';
                    html += '<td>' + replaceplatname(entry['fname']) + '</td>';
                    html += '<td width="50px">' + entry['fbill'] + '</td>';
                    html += '<td width="60px">' + entry['fqty'] + '</td>';
                    html += '</tr>';
                    ret.push(html);
                }
            });
            $('#list_plat_title').html('<h4 style="padding-top: 0px;margin-top: 4px;"><b>Company Month Data:</b></h4><table class="table table-bordered" style="margin-bottom: 0px;"><tr><th width="35px">　</th><th>Company</th><th width="50px">Bill</th><th width="60px">Qty</th></tr>'+htmltitle+'</table>');
            $('#list_plat').html('<table class="table table-bordered" style="margin-bottom: 300px;">' + ret.join('') + '</table>');


            //Month Product Data
            var objitem = eval('(' + arrdata[3] + ')');
            ret=[];
            j=0;
            mapx='';
            mapy='';
            mapz='';
            $.each(objitem, function(i, entry){
                j=j+1;
                var fclass=getclass(j);

                if(mapx!='')mapx=mapx+',';
                mapx=mapx+"'"+entry['fname']+"'";
                if(mapy!='')mapy=mapy+',';
                mapy=mapy+entry['fbill'];
                if(mapz!='')mapz=mapz+',';
                mapz=mapz+entry['fqty'];

            });
            showitemmap(mapx,mapy,mapz)

            //Today Product Data
            var objitem = eval('(' + arrdata[4] + ')');
            ret=[];
            j=0;
            mapx='';
            mapy='';
            mapz='';
            $.each(objitem, function(i, entry){
                j=j+1;

                if(mapx!='')mapx=mapx+',';
                mapx=mapx+"'"+entry['fname']+"'";
                if(mapy!='')mapy=mapy+',';
                mapy=mapy+entry['fbill'];
                if(mapz!='')mapz=mapz+',';
                mapz=mapz+entry['fqty'];

            });
            showitemmaptoday(mapx,mapy,mapz)

        });
        //Get Data 2
        $.get('data.php?ftype=2', function(data){
                var objplat = eval('(' + data + ')');
                fixrow=objplat.length;
                ret=[];
                var htmltitle='';
                j=0;
                $.each(objplat, function(i, entry){
                    if(entry['platform']=='[total]')
                    {
                        htmltitle='<tr class="top">';
                        htmltitle+='<td width="35px">&nbsp;</td>';
                        htmltitle+='<td>'+entry['platform'].substr(0,7)+'</td>';
                        htmltitle+='<td width="50px">'+entry['qtyall']+'</td>';
                        htmltitle+='<td width="60px">'+entry['rate']+'%</td>';
                        htmltitle+='</tr>';
                    }
                    else
                    {
                        j=j+1;
                        var fclass=getclass(j);
                        if(j<=3)
                        {
                            htmltitle+='<tr class="'+fclass+'">';
                            htmltitle+='<td width="35px">'+j+'</td>';
                            htmltitle+='<td>'+replaceplatname(entry['platform'])+'</td>';
                            htmltitle+='<td width="50px">'+entry['qtyall']+'</td>';
                            htmltitle+='<td width="60px">'+entry['rate']+'%</td>';
                            htmltitle+='</tr>';
                        }
                        else
                        {
                            var html='<tr class="'+fclass+'">';
                            html+='<td width="35px">'+j+'</td>';
                            html+='<td>'+replaceplatname(entry['platform'])+'</td>';
                            html+='<td width="50px">'+entry['qtyall']+'</td>';
                            html+='<td width="60px">'+entry['rate']+'%</td>';
                            html+='</tr>';
                            ret.push(html);//存入数组
                        }
                    }
                });
                $('#list_plat_fix_title').html('<h4><b>Month Completion Rate </b></h4><table class="table table-bordered" style="margin-bottom: 0px;"><tr><th width="35px">　</th><th>Company</th><th width="50px">total</th><th width="60px">Rate</th></tr>'+htmltitle+'</table>');
                $('#list_plat_fix').html('<table class="table table-bordered" style="margin-bottom: 300px;">' + ret.join('') + '</table>');
        });
        ftop=1000*20;
    }
    function getclass(j) {
        var fclass='';
        switch(j){
            case 1:
                fclass='top1';
                break;
            case 2:
                fclass='top2';
                break;
            case 3:
                fclass='top3';
                break;
            case 4:
                fclass='warning';
                break;
            case 6:
                fclass='info';
                break;
            case 8:
                fclass='success';
                break;
            case 10:
                fclass='warning';
                break;
            case 12:
                fclass='info';
                break;
            case 14:
                fclass='success';
                break;
            case 16:
                fclass='warning';
                break;
            case 18:
                fclass='info';
                break;
            case 20:
                fclass='success';
                break;
        }
        return fclass;
    }
    function replaceplatname(fname){
        if(fname===undefined)
            return "";
        fname=fname.replace(" ","");
        return fname;
    }
    function getNowFormatDate() {
        var date = new Date();
        var seperator1 = "-";
        var seperator2 = ":";
        var month = date.getMonth() + 1;
        var strDate = date.getDate();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }
        var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
            + " " + date.getHours() + seperator2 + date.getMinutes()
            + seperator2 + date.getSeconds();
        return currentdate;
    }


    //Area Data
    function showareamap(map1) {
        var uploadedDataURL = "hn.json";
        var dom = document.getElementById("list_area");
        dom.style.height="400px";
        var myChart = echarts.init(dom);
        var name = 'hn';

        myChart.showLoading();

        $.get(uploadedDataURL, function(geoJson) {

            myChart.hideLoading();

            echarts.registerMap(name, geoJson);

            myChart.setOption(option = {

                title: {
                    text: "Area Data",
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item'
                },
                visualMap: {
                    min: 0,
                    max: 100,
                    left: 'left',
                    top: 'bottom',
                    text: ['High', 'Low'],
                    calculable: true
                },
                toolbox: {
                    show: false,
                    orient: 'vertical',
                    left: 'right',
                    top: 'center',
                    feature: {
                        dataView: {readOnly: false},
                        restore: {},
                        saveAsImage: {}
                    }
                },
                series: [{
                    name:'Bill',
                    type: 'map',
                    mapType: name,
                    label: {
                        normal: {
                            show: true
                        },
                        emphasis: {
                            textStyle: {
                                color: '#fff'
                            }
                        }
                    },
                    itemStyle: {

                        normal: {
                            borderColor: '#389BB7',
                            areaColor: '#fff',
                        },
                        emphasis: {
                            areaColor: '#389BB7',
                            borderWidth: 0
                        }
                    },
                    animation: false,

                    data:eval("["+map1+"]")

                }
                ],

            });
        });
    }
    function showareamapqty(mapx,mapy,mapz) {
        var dom = document.getElementById("list_area_qty");
        dom.style.height="400px";
        var myChart = echarts.init(dom);
        option = null;
        option = {
            title:{text: 'Area Data Qty ',left: 'center'},
            tooltip: {
                trigger: 'axis',
                axisPointer : {
                    type : 'shadow'
                }
            },
            xAxis: {
                type: 'category',
                data: eval("["+mapx+"]"),
                axisTick: {
                    alignWithLabel: true
                },
                axisLabel: {
                    interval: 0,
                    rotate: 45
                },
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    label: {
                        normal: {
                            show: true,
                            position: 'top'
                        }
                    },
                    type: 'bar',
                    data: eval("["+mapz+"]")
                }
            ]
        };
        ;
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }
    function showitemmap(mapx,mapy,mapz) {
        var dom = document.getElementById("list_item");
        dom.style.height="400px";
        var myChart = echarts.init(dom);
        option = null;
        option = {
            title:{text: 'Month Product List'},
            tooltip: {
                trigger: 'axis',
                axisPointer : {
                    type : 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            legend: {
                data: ['Qty','Bill'],left:'right'
            },
            xAxis: {
                type: 'value'
            },
            yAxis: {
                type: 'category',
                data: eval("["+mapx+"]")
            },
            series: [{
                name: 'Qty',
                type: 'bar',
                stack: 'All',
                itemStyle:{
                    normal:{
                        color:'rgba(233, 100, 50, 1)'
                    }
                },
                label: {
                    normal: {
                        show: true,
                        position: 'insideLeft'
                    }
                },
                data: eval("["+mapz+"]")
            },
                {
                    name: 'Bill',
                    type: 'bar',
                    stack: 'All',
                    itemStyle:{
                        normal:{
                            color:'rgba(40, 163, 215, 1)',
                            barBorderRadius: [0, 5, 5, 0]
                        }
                    },
                    label: {
                        normal: {
                            show: true,
                            position: 'right'
                        }
                    },
                    data: eval("["+mapy+"]")
                }
            ]
        };
        ;
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }
    function showitemmaptoday(mapx,mapy,mapz) {
        var dom = document.getElementById("list_item_today");
        dom.style.height="400px";
        var myChart = echarts.init(dom);
        option = null;
        option = {
            title:{text: 'Today Porduct List'},
            tooltip: {
                trigger: 'axis',
                axisPointer : {
                    type : 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            legend: {
                data: ['Qty','Bill'],left:'right'
            },
            xAxis: {
                type: 'value'
            },
            yAxis: {
                type: 'category',
                data: eval("["+mapx+"]")
            },
            series: [{
                name: 'Qty',
                type: 'bar',
                stack: 'All',
                itemStyle:{
                    normal:{
                        color:'rgba(233, 100, 50, 1)'
                    }
                },
                label: {
                    normal: {
                        show: true,
                        position: 'insideLeft'
                    }
                },
                data: eval("["+mapz+"]")
            },
                {
                    name: 'Bill',
                    type: 'bar',
                    stack: 'All',
                    itemStyle:{
                        normal:{
                            color:'rgba(40, 163, 215, 1)',
                            barBorderRadius: [0, 5, 5, 0]
                        }
                    },
                    label: {
                        normal: {
                            show: true,
                            position: 'right'
                        }
                    },
                    data: eval("["+mapy+"]")
                }
            ]
        };
        ;
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    }


</script>
