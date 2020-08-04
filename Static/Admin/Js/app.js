$(function() {
    //根据当前域名自动打开菜单栏目
    var query = window.location.search;
    $('.tpl-left-nav-sub-menu li a').each(function(){
        var url = $(this).attr('href');
        if (query == url ){
            $(this).parent('li').parent('.tpl-left-nav-sub-menu').parent('.tpl-left-nav-item').children('.tpl-left-nav-link-list').click();
        }
    });

     var $fullText = $('.admin-fullText');
    var fullscreen = $.AMUI.fullscreen;
    // 判断各种浏览器，找到正确的方法
    function launchFullscreen(element) {
        if(element.requestFullscreen) {
            element.requestFullscreen();
        } else if(element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if(element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if(element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
    }
    function exitFullscreen() {
        if(document.exitFullscreen) {
            document.exitFullscreen();
        } else if(document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if(document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
    }

    $('#admin-fullscreen').on('click', function() {
        if (!fullscreen.isFullscreen){
            launchFullscreen(document.documentElement)
        } else {
            exitFullscreen(document.documentElement);
        }
     });

    $(document).on(fullscreen.raw.fullscreenchange, function() {
        $fullText.text(fullscreen.isFullscreen ? '退出全屏' : '开启全屏');
    });




        var dataType = $('body').attr('data-type');

        if (!"undefined" == typeof pageData){
            for (key in pageData) {
                if (key == dataType) {
                    pageData[key]();
                }
            }
        }

        $('.tpl-switch').find('.tpl-switch-btn-view').on('click', function() {
            $(this).prev('.tpl-switch-btn').prop("checked", function() {
                    if ($(this).is(':checked')) {
                        return false
                    } else {
                        return true
                    }
                })
                // console.log('123123123')

        })
    })
    // ==========================
    // 侧边导航下拉列表
    // ==========================

$('.tpl-left-nav-link-list').on('click', function() {
        $(this).siblings('.tpl-left-nav-sub-menu').slideToggle(80)
            .end()
            .find('.tpl-left-nav-more-ico').toggleClass('tpl-left-nav-more-ico-rotate');
    })
    // ==========================
    // 头部导航隐藏菜单
    // ==========================

$('.tpl-header-nav-hover-ico').on('click', function() {
    $('.tpl-left-nav').toggle();
    $('.tpl-content-wrapper').toggleClass('tpl-content-wrapper-hover');
})

// ==========================
// 网站公告说明文字 弹窗开关
// ==========================

var isopen = $('#WebGongaoOpen').val();
if (isopen == 2){
    $('#gongGaoWord').text('关闭');
}else{
    $('#gongGaoWord').text('开启');
}

$('#gongGaoWord').on('click', function() {
    clickStatu();
})

function clickStatu() {
    var isopen = $('#WebGongaoOpen').val();
    if (isopen == 2){
        $('#gongGaoWord').text('开启');
        $('#WebGongaoOpen').val(1);
    }else{
        $('#gongGaoWord').text('关闭');
        $('#WebGongaoOpen').val(2);
    }

}



