$(function () {
   // $('head').append("<script type='text/javascript' src='/Public/js/main.js'></script>");
XQ.goTop('.go_top');
    /*___________________________________________________* Jq开始  ___________________________________________________*/
    var win_w = $(window).width() || document.documentElement.clientWidth || document.body.clientWidth;
    var win_h = $(window).height() || document.documentElement.clientHeight || document.body.clientHeight;
    win_w=win_w>$('body').width()?win_w:$('body').width();
    /*______________________________* Nav_index *______________________________*/
   
try{
      setTimeout(function(){
        // $('.l_nav .l_a .l_div').css({'width':win_w,'left':(parseInt($('.l_head ').offset().left)+2)*-1});//'left':-(win_w-$('.l_head').width())/2
    },500);  
}catch(e){}
    $(window).resize(function  () {
          win_w = $(window).width() || document.documentElement.clientWidth || document.body.clientWidth;
     win_h = $(window).height() || document.documentElement.clientHeight || document.body.clientHeight;
    win_w=win_w>$('body').width()?win_w:$('body').width();
    try{
     $('.l_nav .l_a .l_div').css({'width':win_w,'left':(parseInt($('.l_head ').offset().left)+2)*-1});//'left':-(win_w-$('.l_head').width())/2
}catch(e){}    
    })
    /*______________________________* Map_index *______________________________*/
    
    setTimeout(function () {
      $('#l_map .l_map_').each(function(){
        $(this).find('p').css({'margin-left':-$(this).find('p').width()/2,'margin-top':-$(this).find('p').height()/2});
    });
  });
    try{
        $('#l_map .l_pos_1').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_1').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_1').css('top'))+$('#l_map .l_pos_1').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_2').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_2').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_2').css('top'))+$('#l_map .l_pos_2').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_3').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_3').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_3').css('top'))+$('#l_map .l_pos_3').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_4').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_4').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_4').css('top'))+$('#l_map .l_pos_4').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_5').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_5').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_5').css('top'))+$('#l_map .l_pos_5').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_6').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_6').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_6').css('top'))+$('#l_map .l_pos_6').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_7').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_7').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_7').css('top'))+$('#l_map .l_pos_7').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_8').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_8').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_8').css('top'))+$('#l_map .l_pos_8').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_9').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_9').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_9').css('top'))+$('#l_map .l_pos_9').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_10').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_10').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_10').css('top'))+$('#l_map .l_pos_10').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_11').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_11').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_11').css('top'))+$('#l_map .l_pos_11').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_12').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_12').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_12').css('top'))+$('#l_map .l_pos_12').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_13').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_13').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_13').css('top'))+$('#l_map .l_pos_13').height()-6 //范围最小值
        }); 
        $('#l_map .l_pos_14').parallax({
            ratio:0, //移动比例
            addclass:'l_active',
            min_top: parseInt($('#l_map').offset().top)-$(window).height()+parseInt($('#l_map .l_pos_14').css('top'))+6, //范围最大值
            max_top: parseInt($('#l_map').offset().top)+parseInt($('#l_map .l_pos_14').css('top'))+$('#l_map .l_pos_14').height()-6 //范围最小值
        }); 
    } catch(e){
        // console.log(e)
    };
    
    
    /*______________________________* Map_index *______________________________*/
    /*______________________________* Anli_Nav *______________________________*/
    $('.l_anli_con ul li').each(function () {
        if ($(this).index() % 3 == 0) {
            $(this).css('margin-left', '0');
        };
    });
    /*______________________________* Shop *______________________________*/
    $('.l_tc_ewm').css({'opacity':'0','top':'60%'});
    
    $('.l_ban_shop .l_a').click(function(){
        $('.l_zzc,.l_tc_ewm,.l_tc_ewm .l_tit p:eq(0),.l_tc_ewm .l_div img').show();
        $('.l_tc_ewm').animate({'opacity':'1','top':'50%'},600);
    });
    $().click(function(){
        $('.l_zzc,.l_tc_ewm,.l_tc_ewm .l_tit p:eq(1),.l_tc_ewm .l_div p').show();
    });
    $('.l_tc_ewm .l_close').click(function(){
        $('.l_tc_ewm').animate({'opacity':'0','top':'60%'},600,function () {
            $('.l_zzc,.l_tc_ewm,.l_tc_ewm .l_tit p,.l_tc_ewm .l_div img,.l_tc_ewm .l_div p').hide();
        });
    });
    /*-------------------------------- 返回顶部 --------------------------------*/
    $('.l_shop_xf_right .l_a_3').click(function(){
        $('html,body').stop(true,true).animate({'scrollTop':'0'},600);
    });
    try {
        /*____________________________ Index_ban ____________________________*/
            var img=new Image();
                img.src=' ';
                var showBan=false;
                img.onload=function  () {
                    if(showBan){
                    return
                }else{
                    showBanner();
                    showBan=true;
                    clearTimeout(showb);
                }
                };
               var showb= setTimeout(function  () {
                  if(showBan){
                    return
                }else{
                     showBanner();
                       showBan=true;
                }
                
                },0) //轮播延时
     function showBanner  () {
                XQ.slide({
                    obj: '.l_ban_index_img .l_ban_index_img_div',
                    way: 'slide',
                    fortime: 10,
                    autotime: 8000,
                    prev: '.l_ban_index_img .l_ban_an_l',
                    radio: '.l_ban_index_img  .l_ban_list',
                    size: true,
                    next: '.l_ban_index_img .l_ban_an_r',
                    fullScreen: true,
                  //  hoverstop: true,
                    //parallax:true,
                    syncClassOnOff:true,
                    syncClass:{
                        obj:'.sync_div .sync',
                        classs:['z','x','c','v','b','n']
                    },
                    afterLoad:function(){
                    
                          setTimeout( function (){
                        $('.loading-img').fadeOut(600);
                                $('.loading').addClass('hide');
                                    setTimeout(function (){
                                        $('.loading').remove();
                                    }, 1200);
                                      if(XQ.moborpc()){
                            marginrise();
                        XQ.resize(marginrise);
$('.l_ban .l_ban_index_img').addClass('mob');
                        }else{
                        $('.sync_div').addClass('pc');
                        }
                          },500) 
                       // if($(window).height()>600){
                       // $('.banner-1 .l_div').alignMid({error:-80});
                  //  }else{
                         $('.banner-1 .l_div').alignMid({error:-30});
                   // }
                    }
                });
    }
        /*____________________________ Anli_xq ____________________________*/
        XQ.slide({
            obj: '.l_anli_xq_xg .l_anli_xq_div',
            way: 'slide',
            fortime: 400,
            autotime: 3000,
            prev: '.l_anli_xq_xg .l_anli_xq_an_l',
            radio: '.l_anli_xq_xg  .l_anli_xq_list',
            size: true,
            next: '.l_anli_xq_xg .l_anli_xq_an_r',
            autoHeight:'auto',
            hoverstop: true,
            callback:gundong
        });
        XQ.amouse('.l_anli_div .l_div_l', {
            x: '100',
            y: '100'
        })
        XQ.amouse('.l_anli_div .l_div_r_1', {
            x: '100',
            y: '100'
        })
        XQ.amouse('.l_anli_div .l_div_r_2_1', {
            x: '100',
            y: '100'
        })
        XQ.amouse('.l_anli_div .l_div_r_2_2', {
            x: '100',
            y: '100'
        })
    } catch (e) { };
    /*__________________________ Shop_nav  __________________________*/
    $('.l_head_shop .l_nav a').click(function  () {
        var $this=$(this);
        $('html,body').stop(true,true).animate({'scrollTop':$($this.attr('abc')).offset().top-58},600);
    });
    /*__________________________ Box_nav  __________________________*/
    $('.l_head_box .l_nav_box a').click(function  () {
        var $this=$(this);
        $('html,body').stop(true,true).animate({'scrollTop':$($this.attr('abc')).offset().top-58},600);
    });
    /*__________________________ Box_con3  __________________________*/
    $('.l_box_4 .l_left .l_pos').css({'width':$('.l_box_4 .l_left').width()-308});
    /*__________________________ Shop_con3  __________________________*/
    $('.l_shop_con3 .l_abc').each(function () {
        $(this).find('p').css({'padding-top':($(this).height()-$(this).find('p').height())/2});
    });
    /*__________________________ Dibuguanggao  __________________________*/
    var foot_guanggao;
//     $(window).scroll(function () {
//        if($(window).scrollTop()>($('.foot').offset().top-$(window).height()/2)){
//         $('.l_foot_guanggao').addClass('show');
//     }else{
//         $('.l_foot_guanggao').removeClass('show');
//     }
// });
    /*__________________________ Donghua  __________________________*/
    try{
        var wow = new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: true,
            live: true
        });
        wow.init();
    }catch(e){
    }
    // XQ.popup({
    //     obj: '.showdetail',
    //     popup_zc: '.modul-popup-1 .tanchu_zc',
    //     popup: '.modul-popup-1 .tanchu',
    //     closes: '.modul-popup-1 .tanchu_zc,.modul-popup-1 .tanchu .close',
    //     ways: 'bottom',
    //     mobile: false,
    //     num: '0',
    //     showbefore: function(obj) {
    //         var isor=false;
    //         $.ajax({
    //             type:"GET",
    //             url:'/Api/Index/register/id/'+obj.attr('uid'),
    //             async:false,
    //             success:function(data){
    //                 var json=eval('('+data+')');
    //                 console.log(json);
    //                 var obb=$('.content_tanchu');
    //                 obb.find('.title h4').text(json.title);
    //                 obb.find('.title .time').text(XQ.getTime(json.date).dayTime());
    //                 obb.find('.scroll  ').html(json.content);
                    
    //                 isor=true;
    //             }
    //         })
    //         return isor;
    //     },
    //     showafter: function() {
    //         $('.tanchu .content .content_').height($('.modul-popup-1 .content_tanchu').height() - $('.modul-popup-1 .content_tanchu .title').height() -110);
    //     }
    //     }) //弹窗
    //XQ.download(function(){
    XQ.Parallax();//视差初始化
    var bigImg=new XQV;//点击显示大图初始化
    bigImg.showImg({imgWidth:'1024',imgHeight:'347'});
    bigImg.inputInit();
    /*____________________________ box_zhanshi ____________________________*/
    XQ.slide({
        obj: '.l_box_3 .l_box_zx_div',
        way: 'slide',
        fortime: 10,
        autotime: 3000,
        prev: '.l_box_3 .l_box_zx_an_l',
        radio: '.l_box_3  .l_box_zx_list',
        size: true,
        next: '.l_box_3 .l_box_zx_an_r',
        screen: true,
        hoverstop: true
    });
    // XQ.slide({
    //     obj: '.modul-item-showpic-1  ul.row',
    //     way: 'slide',
    //     autotime: 3000,
    //     itemshow:3,
    //     hoverstop: true
    // });
//});
if(XQ.moborpc()){
    $('.l_foot_guanggao').width('1000px');
}
//滚动定位
if($('.l_anli_xq_xg').size()>0){
    $(window).scroll(gundong)
}
function gundong(){
    var scrTop=$(window).scrollTop();
        var foot_top=$('.foot').offset().top-760;
        $('.l_anli_xq_xg').offset().top;
        if(scrTop>528 &&scrTop< foot_top){
            $('.l_nav_left').css('top',(153+scrTop-528)+'px');
            $('.l_anli_xq_an_l,.l_anli_xq_an_r').css('top',(278+scrTop-528)+'px');
        }else if(scrTop> foot_top){
               $('.l_nav_left').css('top',(153+foot_top-528)+'px');
                $('.l_anli_xq_an_l,.l_anli_xq_an_r').css('top',(278+foot_top-528)+'px');
        }else if(scrTop<528){
                $('.l_nav_left').css('top',(153)+'px');
                $('.l_anli_xq_an_l,.l_anli_xq_an_r').css('top',(278)+'px');
        }
    /*___________________________________________________* Jq结束 *___________________________________________________*/
}
if($('.xunhuangeshu').size()<1){
    $('.showorno').hide();
};
var str = [
  '我们只做最好的互联网产品',
  '国内顶尖APP定制开发提供商',
  '移动微网站开发服务提供商',
  '高端网站定制服务提供商',
  '软件系统开发服务提供商'
];
var AutoWrite = function () {
  'use stric'
  this.fun = '自动打印字';
  this.i = 0;
  this.loop = false;
  this.times = 1;
  this.doWork = function (str, i) {
    var this_ = this;
    i = i || 0;
    var str1 = this.isArry ? str[i] : str;
    this.obj.html(str1.substr(0, this_.i));
    if (this_.i == str1.length) {
      if (i == this_.l) {
        return this_.autoLoop();
      }
      i++;
      this_.i = 0;
      this_.nextTimeDo(str, i)
    } else {
      this_.i++;
      this_.timeDo(str, i)
    }
  }
  this.timeDo = function (str, i) {
    var this_ = this;
    setTimeout(function () {
      this_.doWork(str, i)
    }, 300);
  }
  this.nextTimeDo = function (str, i) {
    var this_ = this;
    setTimeout(function () {
      this_.doWork(str, i);
    }, 2000);
  }
  this.begin = function (arrStr, obj, times) {
    this.obj = $(obj);
    this.arry = arrStr;
    'string' == typeof arrStr ? this.isArry = false : this.isArry = true;
    this.l = this.isArry ? (arrStr.length - 1)  : 0;
    if (times) {
      if ('number' == typeof times) {
        this.times = times;
        this.agotime = 1;
      } else if (times == 'infinate') {
        this.loop = true;
        this.stopLoop = function () {
          this.loop = false;
        }
      }
    }
    this.doWork(arrStr);
    return this;
  }
  this.autoLoop = function () {
    var this_ = this;
    if (this.loop) {
      this.i = 0;
      setTimeout(function () {
        this_.doWork(this_.arry);
      }, 1000);
    } else if (this.times && (this.agotime < this.times)) {
      this.i = 0;
      this.agotime++;
      setTimeout(function () {
        this_.doWork(this_.arry);
      }, 1000);
    }
  }
  if (!(this instanceof AutoWrite)) {
    return new AutoWrite();
  }
  return this
}
//var newrun = new AutoWrite();
//newrun.begin(str, '#dayin', 2);
function marginrise () {
    $('.sync_div li img').each(function  () {
        $(this).css({
            'marginLeft':-$(this).width()/2,
            'left':'50%'
        });
    });
}
});
