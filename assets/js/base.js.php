<script>
var apiUrl = "<?=$this->options ->siteUrl;?>";
var apiHost = "//webapi.busi.inke.cn";
/beta/gi.test(location.href) && (apiHost = "//betawebapi.busi.inke.cn");
var initData = {
    api_address: apiUrl + "usr/themes/<?=$this->options->theme;?>/",
	api_url: apiHost + "/web/",
    userInfo: getCookie("INKERUSERINFO") || "",
    area_code: [{
        name: "阿富汗",
        code: 93
    },
    {
        name: "阿尔巴尼亚",
        code: 355
    },
    {
        name: "阿尔及利亚",
        code: 213
    },
    {
        name: "美属萨摩亚",
        code: 684
    },
    {
        name: "安道尔",
        code: 376
    },
    {
        name: "安哥拉",
        code: 244
    },
    {
        name: "安圭拉",
        code: 1264
    },
    {
        name: "南极洲",
        code: 672
    },
    {
        name: "安提瓜和巴布达",
        code: 1268
    },
    {
        name: "阿根廷",
        code: 54
    },
    {
        name: "亚美尼亚",
        code: 374
    },
    {
        name: "阿鲁巴",
        code: 297
    },
    {
        name: "澳大利亚",
        code: 61
    },
    {
        name: "奥地利",
        code: 43
    },
    {
        name: "阿塞拜疆",
        code: 994
    },
    {
        name: "巴林",
        code: 973
    },
    {
        name: "孟加拉国",
        code: 880
    },
    {
        name: "巴巴多斯",
        code: 1246
    },
    {
        name: "白俄罗斯",
        code: 375
    },
    {
        name: "比利时",
        code: 32
    },
    {
        name: "伯利兹",
        code: 501
    },
    {
        name: "贝宁",
        code: 229
    },
    {
        name: "百慕大",
        code: 1441
    },
    {
        name: "不丹",
        code: 975
    },
    {
        name: "玻利维亚",
        code: 591
    },
    {
        name: "波黑",
        code: 387
    },
    {
        name: "博茨瓦纳",
        code: 267
    },
    {
        name: "巴西",
        code: 55
    },
    {
        name: "英属维尔京群岛",
        code: 1284
    },
    {
        name: "文莱",
        code: 673
    },
    {
        name: "保加利亚",
        code: 359
    },
    {
        name: "布基纳法索",
        code: 226
    },
    {
        name: "缅甸",
        code: 95
    },
    {
        name: "布隆迪",
        code: 257
    },
    {
        name: "柬埔寨",
        code: 855
    },
    {
        name: "喀麦隆",
        code: 237
    },
    {
        name: "加拿大",
        code: 1
    },
    {
        name: "佛得角",
        code: 238
    },
    {
        name: "开曼群岛",
        code: 1345
    },
    {
        name: "中非",
        code: 236
    },
    {
        name: "乍得",
        code: 235
    },
    {
        name: "智利",
        code: 56
    },
    {
        name: "中国",
        code: 86
    },
    {
        name: "圣诞岛",
        code: 61
    },
    {
        name: "科科斯（基林）群岛",
        code: 61
    },
    {
        name: "哥伦比亚",
        code: 57
    },
    {
        name: "科摩罗",
        code: 269
    },
    {
        name: "刚果（金）",
        code: 243
    },
    {
        name: "刚果（布）",
        code: 242
    },
    {
        name: "库克群岛",
        code: 682
    },
    {
        name: "哥斯达黎加",
        code: 506
    },
    {
        name: "科特迪瓦",
        code: 225
    },
    {
        name: "克罗地亚",
        code: 385
    },
    {
        name: "古巴",
        code: 53
    },
    {
        name: "塞浦路斯",
        code: 357
    },
    {
        name: "捷克",
        code: 420
    },
    {
        name: "丹麦",
        code: 45
    },
    {
        name: "吉布提",
        code: 253
    },
    {
        name: "多米尼克",
        code: 1767
    },
    {
        name: "多米尼加",
        code: 1809
    },
    {
        name: "厄瓜多尔",
        code: 593
    },
    {
        name: "埃及",
        code: 20
    },
    {
        name: "萨尔瓦多",
        code: 503
    },
    {
        name: "赤道几内亚",
        code: 240
    },
    {
        name: "厄立特里亚",
        code: 291
    },
    {
        name: "爱沙尼亚",
        code: 372
    },
    {
        name: "埃塞俄比亚",
        code: 251
    },
    {
        name: "福克兰群岛（马尔维纳斯）",
        code: 500
    },
    {
        name: "法罗群岛",
        code: 298
    },
    {
        name: "斐济",
        code: 679
    },
    {
        name: "芬兰",
        code: 358
    },
    {
        name: "法国",
        code: 33
    },
    {
        name: "法属圭亚那",
        code: 594
    },
    {
        name: "法属波利尼西亚",
        code: 689
    },
    {
        name: "加蓬",
        code: 241
    },
    {
        name: "格鲁吉亚",
        code: 995
    },
    {
        name: "德国",
        code: 49
    },
    {
        name: "加纳",
        code: 233
    },
    {
        name: "直布罗陀",
        code: 350
    },
    {
        name: "希腊",
        code: 30
    },
    {
        name: "格陵兰",
        code: 299
    },
    {
        name: "格林纳达",
        code: 1473
    },
    {
        name: "瓜德罗普",
        code: 590
    },
    {
        name: "关岛",
        code: 1671
    },
    {
        name: "危地马拉",
        code: 502
    },
    {
        name: "根西岛",
        code: 1481
    },
    {
        name: "几内亚",
        code: 224
    },
    {
        name: "几内亚比绍",
        code: 245
    },
    {
        name: "圭亚那",
        code: 592
    },
    {
        name: "海地",
        code: 509
    },
    {
        name: "梵蒂冈",
        code: 379
    },
    {
        name: "洪都拉斯",
        code: 504
    },
    {
        name: "香港",
        code: 852
    },
    {
        name: "匈牙利",
        code: 36
    },
    {
        name: "冰岛",
        code: 354
    },
    {
        name: "印度",
        code: 91
    },
    {
        name: "印度尼西亚",
        code: 62
    },
    {
        name: "伊朗",
        code: 98
    },
    {
        name: "伊拉克",
        code: 964
    },
    {
        name: "爱尔兰",
        code: 353
    },
    {
        name: "以色列",
        code: 972
    },
    {
        name: "意大利",
        code: 39
    },
    {
        name: "牙买加",
        code: 1876
    },
    {
        name: "日本",
        code: 81
    },
    {
        name: "约旦",
        code: 962
    },
    {
        name: "哈萨克斯坦",
        code: 73
    },
    {
        name: "肯尼亚",
        code: 254
    },
    {
        name: "基里巴斯",
        code: 686
    },
    {
        name: "朝鲜",
        code: 850
    },
    {
        name: "韩国",
        code: 82
    },
    {
        name: "科威特",
        code: 965
    },
    {
        name: "吉尔吉斯斯坦",
        code: 996
    },
    {
        name: "老挝",
        code: 856
    },
    {
        name: "拉脱维亚",
        code: 371
    },
    {
        name: "黎巴嫩",
        code: 961
    },
    {
        name: "莱索托",
        code: 266
    },
    {
        name: "利比里亚",
        code: 231
    },
    {
        name: "利比亚",
        code: 218
    },
    {
        name: "列支敦士登",
        code: 423
    },
    {
        name: "立陶宛",
        code: 370
    },
    {
        name: "卢森堡",
        code: 352
    },
    {
        name: "澳门",
        code: 853
    },
    {
        name: "马达加斯加",
        code: 261
    },
    {
        name: "马拉维",
        code: 265
    },
    {
        name: "马来西亚",
        code: 60
    },
    {
        name: "马尔代夫",
        code: 960
    },
    {
        name: "马里",
        code: 223
    },
    {
        name: "马耳他",
        code: 356
    },
    {
        name: "马绍尔群岛",
        code: 692
    },
    {
        name: "马提尼克",
        code: 596
    },
    {
        name: "毛里塔尼亚",
        code: 222
    },
    {
        name: "毛里求斯",
        code: 230
    },
    {
        name: "马约特",
        code: 269
    },
    {
        name: "墨西哥",
        code: 52
    },
    {
        name: "密克罗尼西亚",
        code: 691
    },
    {
        name: "摩尔多瓦",
        code: 373
    },
    {
        name: "摩纳哥",
        code: 377
    },
    {
        name: "蒙古",
        code: 976
    },
    {
        name: "蒙特塞拉特",
        code: 1664
    },
    {
        name: "摩洛哥",
        code: 212
    },
    {
        name: "莫桑比克",
        code: 258
    },
    {
        name: "纳米尼亚",
        code: 264
    },
    {
        name: "瑙鲁",
        code: 674
    },
    {
        name: "尼泊尔",
        code: 977
    },
    {
        name: "荷兰",
        code: 31
    },
    {
        name: "荷属安的列斯",
        code: 599
    },
    {
        name: "新喀里多尼亚",
        code: 687
    },
    {
        name: "新西兰",
        code: 64
    },
    {
        name: "尼加拉瓜",
        code: 505
    },
    {
        name: "尼日尔",
        code: 227
    },
    {
        name: "尼日利亚",
        code: 234
    },
    {
        name: "纽埃",
        code: 683
    },
    {
        name: "诺福克岛",
        code: 6723
    },
    {
        name: "北马里亚纳",
        code: 1
    },
    {
        name: "挪威",
        code: 47
    },
    {
        name: "阿曼",
        code: 968
    },
    {
        name: "巴基斯坦",
        code: 92
    },
    {
        name: "帕劳",
        code: 680
    },
    {
        name: "巴拿马",
        code: 507
    },
    {
        name: "巴布亚新几内亚",
        code: 675
    },
    {
        name: "巴拉圭",
        code: 595
    },
    {
        name: "秘鲁",
        code: 51
    },
    {
        name: "菲律宾",
        code: 63
    },
    {
        name: "波兰",
        code: 48
    },
    {
        name: "葡萄牙",
        code: 351
    },
    {
        name: "波多黎各",
        code: 1809
    },
    {
        name: "卡塔尔",
        code: 974
    },
    {
        name: "留尼汪",
        code: 262
    },
    {
        name: "罗马尼亚",
        code: 40
    },
    {
        name: "俄罗斯",
        code: 7
    },
    {
        name: "卢旺达",
        code: 250
    },
    {
        name: "圣赫勒拿",
        code: 290
    },
    {
        name: "圣基茨和尼维斯",
        code: 1869
    },
    {
        name: "圣卢西亚",
        code: 1758
    },
    {
        name: "圣皮埃尔和密克隆",
        code: 508
    },
    {
        name: "圣文森特和格林纳丁斯",
        code: 1784
    },
    {
        name: "萨摩亚",
        code: 685
    },
    {
        name: "圣马力诺",
        code: 378
    },
    {
        name: "圣多美和普林西比",
        code: 239
    },
    {
        name: "沙特阿拉伯",
        code: 966
    },
    {
        name: "塞内加尔",
        code: 221
    },
    {
        name: "塞尔维亚和黑山",
        code: 381
    },
    {
        name: "塞舌尔",
        code: 248
    },
    {
        name: "塞拉利",
        code: 232
    },
    {
        name: "新加坡",
        code: 65
    },
    {
        name: "斯洛伐克",
        code: 421
    },
    {
        name: "斯洛文尼亚",
        code: 386
    },
    {
        name: "所罗门群岛",
        code: 677
    },
    {
        name: "索马里",
        code: 252
    },
    {
        name: "南非",
        code: 27
    },
    {
        name: "西班牙",
        code: 34
    },
    {
        name: "斯里兰卡",
        code: 94
    },
    {
        name: "苏丹",
        code: 249
    },
    {
        name: "苏里南",
        code: 597
    },
    {
        name: "斯瓦尔巴岛和扬马延岛",
        code: 47
    },
    {
        name: "斯威士兰",
        code: 268
    },
    {
        name: "瑞典",
        code: 46
    },
    {
        name: "瑞士",
        code: 41
    },
    {
        name: "叙利亚",
        code: 963
    },
    {
        name: "台湾",
        code: 886
    },
    {
        name: "塔吉克斯坦",
        code: 992
    },
    {
        name: "坦桑尼亚",
        code: 255
    },
    {
        name: "泰国",
        code: 66
    },
    {
        name: "巴哈马",
        code: 1242
    },
    {
        name: "冈比亚",
        code: 220
    },
    {
        name: "多哥",
        code: 228
    },
    {
        name: "托克劳",
        code: 690
    },
    {
        name: "汤加",
        code: 676
    },
    {
        name: "特立尼达和多巴哥",
        code: 1868
    },
    {
        name: "突尼斯",
        code: 216
    },
    {
        name: "土耳其",
        code: 90
    },
    {
        name: "土库曼斯坦",
        code: 993
    },
    {
        name: "特克斯和凯科斯群岛",
        code: 1649
    },
    {
        name: "图瓦卢",
        code: 688
    },
    {
        name: "乌干达",
        code: 256
    },
    {
        name: "乌克兰",
        code: 380
    },
    {
        name: "阿拉伯联合酋长国",
        code: 971
    },
    {
        name: "英国",
        code: 44
    },
    {
        name: "美国",
        code: 1
    },
    {
        name: "乌拉圭",
        code: 598
    },
    {
        name: "乌兹别克斯坦",
        code: 998
    },
    {
        name: "瓦努阿图",
        code: 678
    },
    {
        name: "委内瑞拉",
        code: 58
    },
    {
        name: "越南",
        code: 84
    },
    {
        name: "美属维尔京群岛",
        code: 1340
    },
    {
        name: "瓦利斯和富图纳",
        code: 681
    },
    {
        name: "也门",
        code: 967
    },
    {
        name: "赞比亚",
        code: 260
    },
    {
        name: "津巴布韦",
        code: 263
    }]
},
$loginRegistBox = $(".header_rg"),
$userBox = $(".user_box"),
$logoutBtn = $(".logout_btn");
/*
if (initData.userInfo) {
    var user_info = JSON.parse(initData.userInfo);
    $loginRegistBox.hide();
    var name = $.trim(user_info.name);
    6 < name.length && (name = name.substr(0, 6) + "..."),
    $userBox.find("img").attr({
        src: user_info.pic,
        alt: user_info.name
    }).end().find(".user_name").html(name),
    $userBox.show()
} else $loginRegistBox.show();
*/
function renderMaskLayer() {
    var e = $('<div class="mask_layer"></div>');
    e.css({
        position: "absolute",
        top: 0,
        left: 0,
        zIndex: 100,
        width: $("body").width(),
        height: $("body").height(),
        backgroundColor: "#000",
        filter: "alpha(opacity=40)",
        opacity: .4
    }),
    $("body").append(e)
}
function renderLoginPanel() {
    renderMaskLayer(),
    addBuriedPointHandler("104000");
    for (var e = "",
    n = 0; n < initData.area_code.length; n++) e += '<li data-code="' + initData.area_code[n].code + '">' + initData.area_code[n].name + "</li>";
    var a = '<div id="login_panel"><div class="login_panel-lf fl"><h2>登录<?php $this->options->title();?></h2><div class="area_code" style="display:none;"><p><span data-code="86">中国（＋86）</span></p><ul>' + e + '</ul></div><form class="login_form" action="<?php $this->options->loginAction();?>" method="post"><input type="hidden" name="action" value="submit"><input type="hidden" name="referer" value="<?php $this->options->rootUrl(); ?>" data-current-url="value"><fieldset><legend>登录</legend><div class="login_form_item"><input type="text" name="name" placeholder="请输入手机号码或邮箱"></div><?php if(empty($this->options->switch)||(!empty($this->options->switch) && in_array('isShowImgCode', $this->options->switch))){?><div class="login_form_item login_form_img"><input type="text" name="imgcode" placeholder="请输入图文验证码"><img class="img_code" src=' + initData.api_address + "libs/checkcode.php?r=" + Math.random() + 'alt="图形验证码" /></div><?php }?><?php if(empty($this->options->switch)||(!empty($this->options->switch) && in_array('isShowSmsCode', $this->options->switch))){?><div class="login_form_item login_form_code"><input type="text" name="code" placeholder="请输入验证码"><span class="code_btn">获取验证码</span><span class="code_btn_dis">获取验证码</span></div><?php }?><div class="login_form_item"><input type="password" name="password" placeholder="请输入密码"></div><div class="login_form_item"><p class="msg"></p></div><div class="login_form_item"><span class="login_btn">登录</span></div></fieldset></form><p class="login_terms"><?php if($this->options->head_serviceitem!=""||$this->options->head_privacyitem!=""){?>登录即代表你同意<?php }?><?php if($this->options->head_serviceitem!=""){?><a target="_blank" href="<?=$this->options->head_privacyitem;?>">《服务条款》</a><?php }?><?php if($this->options->head_serviceitem!=""&&$this->options->head_privacyitem!=""){?>和<?php }?><?php if($this->options->head_privacyitem!=""){?><a target="_blank" href="<?=$this->options->head_privacyitem;?>">《隐私条款》</a></p><?php }?></div><div class="login_panel-rg fr"><div class="download_code"><img src="<?=$this->options->head_qrcode;?>" alt="<?php if($this->options->head_qrcode_info!=""){echo $this->options->head_qrcode_info;}?>"><p><?php if($this->options->head_qrcode_info!=""){echo $this->options->head_qrcode_info;}?></p></div><?php if (!empty($this->options->switch) && in_array('isWeiboLogin', $this->options->switch)){?><a href="" class="sinalogin"><i></i><span>新浪微博登录</span></a><?php }?><?php if (!empty($this->options->switch) && in_array('isQQLogin', $this->options->switch)){?><a href="" class="qqlogin"><i></i><span>QQ登录</span></a><?php }?></div><span class="close_login_panel"></span></div>';
    $("body").append(a);
    var o = $(".close_login_panel"),
    d = $(".area_code"),
    c = d.find("p"),
    i = d.find("ul"),
    m = $('.login_form input[name="name"]'),
	pwd = $('.login_form input[name="password"]'),
    t = $('.login_form input[name="imgcode"]'),
    l = $('.login_form input[name="code"]'),
    s = $(".img_code"),
    r = $(".code_btn"),
    p = $(".code_btn_dis"),
    u = $(".login_btn"),
    h = $(".login_form p.msg");
    m.focus(),
    o.on("click",
    function() {
        clearMaskLoginHandler(),
        addBuriedPointHandler("110003")
    }),
    d.on("click", "p",
    function() {
        i.show(),
        i.animate({
            height: "270"
        },
        200),
        i.on("click", "li",
        function() {
            c.find("span").html($(this).html() + "（+" + $(this).data("code") + "）"),
            c.find("span").data("code", $(this).data("code")),
            i.css({
                height: 0
            }),
            i.hide()
        })
    }).on("mouseleave",
    function() {
        i.animate({
            height: "0"
        },
        200,
        function() {
            i.hide()
        })
    }),
    s.on("click",
    function() {
        s.attr("src", initData.api_address + "libs/checkcode.php?r=" + Math.random())/*Live_captcha_pc*/
    }),
    t.on("input",
    function() {
        5 == $(this).val().length ? (p.hide(), r.show()) : (p.show(), r.hide())
    }),
    t.on("change",
    function() {
        5 == $(this).val().length ? (p.hide(), r.show()) : (p.show(), r.hide())
    }),
    r.on("click",
    function() {
        var n = 60,
        a = null; (h.html(""), m.val()) ? sendCodeHandler(c.find("span").data("code") + m.val(), t.val(),m.val()).done(function(e) {
            0 != e.error_code ? h.html(e.message) : (r.hide(), p.show().html(n + "s"), a = setInterval(function() {
                1 < n ? (n--, p.html(n + "s")) : (r.html("重新发送").show(), p.hide(), clearInterval(a))
            },
            1e3))
        }).fail(function() {
            h.html("验证码获取错误！")
        }) : h.html("请输入手机号码或邮箱！")
    }),
    u.on("click",
    function() {
        return h.html(""),
        /*
		m.val() ? l.val() ? void loginRegistHandler(c.find("span").data("code") + m.val(), l.val(),m.val(),pwd.val(),t.val()) : (h.html("请输入验证码！"), !1) : (h.html("请输入手机号码或邮箱！"), !1)
		*/
		m.val() ? void loginRegistHandler(c.find("span").data("code") + m.val(), l.val(),m.val(),pwd.val(),t.val()) : (h.html("请输入手机号码或邮箱！"), !1)
    }),
    otherLogin().done(function(e) {
        0 == e.error_code ? ($(".sinalogin").attr("href", e.data && e.data.wb_url), $(".qqlogin").attr("href", e.data && e.data.qq_url)) : console.log("错误提示：" + e.msg)
    }).fail(function() {
        console.log("错误提示：第三方登录接口错误！")
    })
}
function otherLogin() {
	/*window.location.search*/
    return $.ajax({
        url: initData.api_address + "ajax/regoauth.php",
        dataType: "json"
    })
}
function sendCodeHandler(e, n,m) {
	var type="phone";
	if(m.indexOf("@")!=-1){
		type="mail";
	}
    return $.ajax({
        url: initData.api_address + "ajax/sendsms.php",/*Live_mobilecode_pc*/
        data: {
			action:type,
            phone: e,
            captcha: n,
			cnphone: m
        },
        xhrFields: {
            withCredentials: !0
        },
        dataType: "json"
    })
}
function loginRegistHandler(e, n,m,pwd,t) {
	/*
	if($(".login_form input[name='imgcode']").val()!=n){
		 $(".login_form p.msg").html("请输入正确的验证码")
		return;
	}
	*/
	var address="ajax/regphone.php";
	if(m.indexOf("@")!=-1){
		address="ajax/regmail.php";
	}
    $.ajax({
        url: initData.api_address + address,/*Live_login_pc*/
        data: {
            phone: e,
			pwd:pwd,
			imgcode: t,
            code: n,
			cnphone: m
        },
        xhrFields: {
            withCredentials: !0
        },
		crossDomain: true,
        dataType: "json",
        success: function(e) {
			if(e.error_code==0){
				$.ajax({
					url: $(".login_form").attr("action"),
					type: $(".login_form").attr("method"),
					data: $(".login_form").serializeArray(),
					success: function(data) {
						/*setCookie("INKERUSERINFO",e.data.INKERUSERINFO,0);*/
						location.reload();
					},
					error: function() {
						$(".login_form p.msg").html("登录错误！");
					}
				});
				/*
				0 == e.error_code ? (clearMaskLoginHandler(), $loginRegistBox.hide(), e.data && ($userBox.find("img").attr({
					src: e.data.portrait,
					alt: e.data.nick
				}).end().find(".user_name").html(e.data.nick), $userBox.show())) : $(".login_form p.msg").html(e.message)
				*/
			}else{
				$(".login_form p.msg").html(e.message);
			}
        },
        error: function() {
            $(".login_form p.msg").html("登录/注册错误！")
        }
    })
}
function loginOutHandler() {
	clearCookie();
	location.href="<?php $this->options->logoutUrl(); ?>";
}
function clearMaskLoginHandler() {
    $(".mask_layer").remove(),
    $("#login_panel").remove()
}
function setCookie(e, n, a) {
    var o = new Date;
    o.setDate(o.getDate() + a),
    document.cookie = e + "=" + encodeURIComponent(n) + ";expires=" + a
}
function getCookie(e) {
    for (var n, a = document.cookie.split("; "), o = 0; o < a.length; o++) if ((n = a[o].split("="))[0] == e) return decodeURIComponent(n[1])
}
function delCookie(e) {
    setCookie(e, 1, -1)
}
function addBuriedPointHandler(e, n) {
    var a = {
        source_cc: "TG6001",
        busi_code: e,
        is_login: n || 0,
        click_time: (new Date).getTime()
    };
    /*
	url = "https://service.busi.inke.cn/web/web_click_report?" + $.param(a),
    setTimeout(function() { (new Image).src = url
    },
    0)
	*/
}
function alertHandler(e) {
    renderMaskLayer();
    var n = '<div class="alert_box"><p style="text-align: center;">' + e + "</p><span>确认</span></div>";
    $("body").append(n),
    $(".alert_box span").on("click",
    function() {
        $(".mask_layer").remove(),
        $(".alert_box").remove()
    })
}
function flashCheck() {
    var e, n = {
        hasFlash: 0,
        flashVersion: 0
    };
    if (document.all)(e = new ActiveXObject("ShockwaveFlash.ShockwaveFlash")) && (n.hasFlash = 1, VSwf = e.GetVariable("$version"), n.flashVersion = parseInt(VSwf.split(" ")[1].split(",")[0]));
    else if (navigator.plugins && 0 < navigator.plugins.length && (e = navigator.plugins["Shockwave Flash"])) {
        n.hasFlash = 1;
        for (var a = e.description.split(" "), o = 0; o < a.length; ++o) isNaN(parseInt(a[o])) || (n.flashVersion = parseInt(a[o]))
    }
    return n
}
$loginRegistBox.find(".login").on("click", renderLoginPanel),
$loginRegistBox.find(".regist").on("click", renderLoginPanel),
$userBox.on("mouseenter",
function() {
    $logoutBtn.show()
}).on("mouseleave",
function() {
    $logoutBtn.hide()
}),
$logoutBtn.on("click",
function() {
    loginOutHandler()
});
function clearCookie(){ 
	var keys=document.cookie.match(/[^ =;]+(?=\=)/g); 
	if (keys) { 
		for (var i = keys.length; i--;) 
		document.cookie=keys[i]+'=0;expires=' + new Date( 0).toUTCString() 
	} 
}
</script>