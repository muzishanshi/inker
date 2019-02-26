var level = {
    data: "",
    init: function() {
        var o = this;
        this.getData().done(function(e) {
            0 == e.error_code ? o.data = o.formatData(e.data) : console.log(e.message || "获取等级图标失败，请重试！")
        })
    },
    getData: function() {
        return $.ajax({
            url: initData.api_url + "Live_resource_rank",
            dataType: "json",
            error: function() {
                console.log("获取等级图标出错！")
            }
        })
    },
    formatData: function(e) {
        for (var o = {},
        n = 0; n < e.length; n++) o[e[n].level + "_1"] = e[n].blk,
        o[e[n].level + "_0"] = e[n].glk;
        return o
    }
};
localStorage.level || level.init(),
$(document).ready(function() {
    var _uid = "",
    _id = "",
    _view_id = JSON.parse(initData.userInfo || "{}").view_id,
    $liveInfo = $(".live_info"),
    $hostInfo = $(".host_info"),
    $hostFocus = $(".host_focus"),
    $hostFocusDone = $(".host_focus_done"),
    $replayBox = $(".replay_box"),
    $playendBox = $(".playend_box"),
    $livePlay = $(".live_play"),
    $liveReplay = $("#live_replay"),
    $liveCont = $(".live_content"),
    $liveHot = $("#live_hot"),
    $listPanelBd = $(".list_panel_bd"),
    $loading = $(".loading_wrapper"),
    $comments = $(".comments"),
    $commentsBox = $comments.find(".comments_list"),
    $hasFlash = $(".has_flash"),
    _liveData = [],
    PlayControl = null,
    player = null,
    Chat = null,
    timer = null,
    _isLogin = initData.userInfo,
    _isFollow = !0,
    _isScroll = !1,
    recordsArr = [],
    hasFlash = flashCheck().hasFlash,
    isFull = !1,
    agent = navigator.userAgent.toLowerCase(),
    protocol = window.location.protocol;
    function getLocationSearch() {
        var e = document.location.search ? document.location.search.substring(1).split("&") : [];
        0 != e.length && (_uid = e[0].split("=")[1], _id = e[1].split("=")[1])
    }
    function dada_islive(e) {
        $.ajax({
            url: location.protocol + "//baseapi.busi.inke.cn/live/LiveInfo",
            data: {
                uid: e
            },
            dataType: "json",
            xhrFields: {
                withCredentials: !0
            },
            success: function(e) {
                if (console.log(e), _uid = getQueryString("uid"), 0 == e.error_code) if (1 * !e.data.live_info.status) {
                    liveEndFn(),
                    _id = e.data.live_info.liveid,
                    console.log(e.data.live_info.user.pic),
                    $(".host_name span").html(e.data.live_info.user.nick),
                    $(".host_code span").html(e.data.live_info.user.uid);
                    var o = e.data.live_info.user.pic;
                    e.data.live_info.user.pic.indexOf("http:") < 0 && (o = "//img2.inke.cn/" + o),
                    $hostInfo.find(".host_portrait").attr({
                        src: o
                    }),
                    $(".host_focus_done").hide()
                } else _id = e.data.live_info.liveid;
                else liveEndFn(),
                _id = "";
                initDataInfo()
            },
            error: function() {
                console.log("error！")
            }
        })
    }
    function getQueryString(e) {
        var o = new RegExp("(^|&)" + e + "=([^&]*)(&|$)", "i"),
        n = window.location.search.substr(1).match(o);
        return null != n ? unescape(n[2]) : ""
    }
    function initDataInfo() {
        var e = $.ajax({
            url: location.protocol + "//chatroom.inke.cn/url",
            data: {
                roomid: _id,
                uid: _uid,
                id: _id
            },
            dataType: "json",
            xhrFields: {
                withCredentials: !0
            }
        }),
        o = $.ajax({
            url: initData.api_url + "live_share_pc",
            data: {
                uid: _uid,
                id: _id
            },
            dataType: "json",
            xhrFields: {
                withCredentials: !0
            }
        });
        $.when(o, e).done(function(e, o) {
            var n = e.push ? e[0] : e,
            i = o.push ? o[0] : o;
            if (n.data.chartroom = i, n.data && n.data.records && 0 < n.data.records.length) for (var t = 0; t < n.data.records.length; t++) n.data.records[t].liveid != _id && recordsArr.push(n.data.records[t]);
            $loading.hide(),
            $liveCont.show(),
            "game" !== Util.getQueryString("type") && $liveHot.show(),
            0 < recordsArr.length && "game" !== Util.getQueryString("type") && $liveReplay.show(),
            0 == n.error_code ? (_liveData = n.data, renderView(n.data)) : console.log(n.message || "获取数据失败，请重试！")
        }).fail(function() {
            alert("获取数据出错！")
        })
    }
    function newPlayer(e) {
        var o, n, i = e.file.record_url,
        t = e.file.pic,
        s = i.substring(i.lastIndexOf(".") + 1),
        a = "",
        l = {};
        switch (a = t.match(/http(?!\:).*jpg/gi) ? decodeURIComponent(t.match(/http(?!\:).*jpg/gi)[0]) : (a = decodeURIComponent(t.match(/http(?!\:).*&w=/gi)[0])).split("&w")[0], -1 != i.indexOf("?") && (i = i.substr(0, i.indexOf("?")), s = s.substr(0, s.indexOf("?"))), s) {
        case "m3u8":
            l = {
                f: protocol + "//static.inke.cn/web/common/ckplayer/m3u8.swf",
                a: i,
                i: a,
                p: 1,
                s: 4,
                c: 0,
                e: 0,
                h: 3,
                loaded: "loadedHandler"
            };
            break;
        case "mp4":
            l = {
                f: i,
                s: 0,
                p: 0,
                i: a,
                c: 0,
                e: 0,
                h: 3
            };
            break;
        default:
            l = {
                f: i,
                i: a,
                p: 1,
                c: 1,
                e: 0,
                lv: 1,
                loaded: "loadedHandler"
            }
        }
        o = "liveMedia",
        n = [i],
        CKobject.embed(window.location.protocol + "//static.inke.cn/web/common/ckplayer/ckplayer.swf", o, "ckplayer_a1", "100%", "100%", !1, l, n, {
            bgcolor: "#999",
            allowFullScreen: !0,
            allowScriptAccess: "always",
            wmode: "transparent"
        }),
        setTimeout(function() {
            $("#js-gift-show-container").show()
        },
        2e3)
    }
    function renderView(e) {
        var n = new Chat(e);
        function o() {
            var e = $(".live_cont_lf").height(),
            o = $(".live_cont_lf").width(),
            n = 368 * e / 640;
            $("#js-gift-show-container").css("left", (o - n) / 2)
        }
        function i() {
            var e = $comments.find(".comments_box input"),
            o = e.val();
            addBuriedPointHandler("109000", 1),
            o.length <= 0 ? alert("请先输入内容，再进行评论哦～") : 150 < o.length ? alert("字数过多，请清除些，重新发送～") : (n.send(o.replace(/\<|\>/g, "")), e.val(""))
        }
        o(),
        window.onresize = function() {
            o()
        },
        _isLogin ? ($hostFocus.show(), $hostFocusDone.hide(), e.is_follow && ($hostFocus.hide(), $hostFocusDone.show().html("已关注")), $comments.find(".comments_box input").attr("placeholder", "和大家说点什么吧"), $comments.find(".comments_box span").on("click", i), $(document).on("keydown",
        function(e) {
            13 == e.keyCode && i()
        }), $comments.find(".comments_box p").hide()) : ($comments.find(".comments_box span").on("click",
        function() {
            addBuriedPointHandler("109000")
        }), $comments.find(".comments_box p").show()),
        $liveInfo.find("li:first span").html(e.file.online_users),
        $liveInfo.find("li:last span").html(e.file.city || "火星"),
        $hostInfo.find(".host_portrait").attr({
            src: e.media_info.portrait,
            alt: e.media_info.nick
        }),
        $hostInfo.find(".host_name span").html(e.media_info.nick),
        $hostInfo.find(".host_name i:first").addClass(0 == e.media_info.gender ? "sex_woman": "sex_man"),
        $hostInfo.find(".host_name i:last").css({
            backgroundImage: "url(" + e.media_info.level_img + ")",
            backgroundRepeat: "no-repeat",
            backgroundSize: "100% 100%"
        }),
        $hostInfo.find(".host_code span").html(e.live_uid),
        $hostInfo.find(".host_slogan").html(e.media_info.description),
        hasFlash ? 1 == e.status ? (n.enter_room(_id, _uid), newPlayer(e)) : 0 == e.status ? (newPlayer(e), $liveInfo.find("li:first span").html(e.file.online_users + "人看过"), $comments.find(".comments_box").hide(), $comments.css("background", '#f5f5f5 url("./images/comments_bg.png") no-repeat 50% 50%')) : ($("#liveMedia").css({
            background: "url(" + e.file.pic + ") no-repeat",
            backgroundSize: "100%"
        }), liveEndFn()) : $hasFlash.show(),
        $hostFocus.on("click",
        function() {
            hostFocusFn(_uid),
            addBuriedPointHandler("104000", 1)
        }),
        $hostFocusDone.on("click",
        function() {
            _isLogin || (renderLoginPanel(), addBuriedPointHandler("104000"))
        }),
        $comments.find(".comments_box p").on("click", renderLoginPanel),
        $commentsBox.on("mouseenter",
        function() {
            _isScroll = !0,
            $(this).css("overflowY", "auto")
        }).on("mouseleave",
        function() {
            _isScroll = !1,
            $(this).css("overflowY", "hidden")
        }).on("scroll",
        function(e) {
            e.preventDefault()
        }),
        $listPanelBd.on("mouseenter", ".list_box .list_pic",
        function() {
            $(this).find("img").addClass("hover_scale"),
            $(this).find(".play_layer").show()
        }).on("mouseleave", ".list_box .list_pic",
        function() {
            $(this).find("img").removeClass("hover_scale"),
            $(this).find(".play_layer").hide()
        }).on("click", ".list_box .list_pic",
        function(e) {
            window.location.search = "?uid=" + ($(this).data("uid") || "") + "&id=" + ($(this).data("id") || "")
        }),
        $liveReplay.find("h3").siblings().attr("href", "./replaylive_list.html?uid=" + _uid).on("click",
        function() {
            _isLogin ? addBuriedPointHandler("110001", 1) : addBuriedPointHandler("110001")
        }),
        0 < recordsArr.length || $liveReplay.hide(),
        getHotLiveFn(),
        $liveHot.find("h3").siblings().on("click",
        function() {
            _isLogin ? addBuriedPointHandler("110002", 1) : addBuriedPointHandler("110002")
        })
    }
    function hostFocusFn(e) {
        $.ajax({
            url: initData.api_url + "live_follow_pc",
            data: {
                uid: e
            },
            dataType: "json",
            xhrFields: {
                withCredentials: !0
            },
            success: function(e) {
                0 != e.error_code ? (alert(e.message || "关注失败，请重试！"), window.location.reload()) : ($hostFocus.hide(), $hostFocusDone.show().html("已关注"))
            },
            error: function() {
                console.log("关注出错！")
            }
        })
    }
    function liveEndFn() {
        $playendBox.find("dd").hide(),
        $playendBox.show(),
        $comments.find(".comments_box").hide(),
        $comments.css("background", '#f5f5f5 url("./images/comments_bg.png") no-repeat 50% 50%')
    }
    function getHotLiveFn() {
        $.ajax({
            url: initData.api_url + "live_hotlist_pc",
            dataType: "json",
            success: function(e) {
                0 == e.error_code || console.log(e.message || "获取热门数据失败，请重试！")
            },
            error: function() {
                console.log("获取热门数据出错！")
            }
        })
    }
    function json_decode(str) {
        var data = null;
        try {
            str = str.replace(/\"(\w+)\":/g, "$1:"),
            data = eval("(" + str + ")")
        } catch(e) {}
        return data
    }
    function init_game() {
        $(".host_info,#live_replay,#live_hot").hide(),
        $(".comments").css({
            "margin-top": "0",
            height: "100%"
        }),
        $(".live_cont_lf").css("background", "#f5f5f5"),
        $("#liveMedia").css("height", "64%"),
        $(".gift-show-container").css("bottom", "44%"),
        $(".box-game").show(),
        $(".toc-tit").html("直播标题:" + Util.getQueryString("tit")),
        $(".game-tit-push-url-addr").html(Util.getQueryString("addr")),
        $(".btn-close-live").on("click",
        function() {
            $.ajax({
                url: apiHost + "/game/Live_stop",
                data: {
                    uid: _uid
                },
                dataType: "json",
                xhrFields: {
                    withCredentials: !0
                },
                success: function(e) {
                    0 == e.dm_error ? window.history.back() : alert("操作失败，稍后再试")
                },
                error: function() {
                    console.log("结束直播接口gg")
                }
            })
        })
    }
    getQueryString("id") ? (getLocationSearch(), initDataInfo()) : getQueryString("uid") && dada_islive(getQueryString("uid")),
    PlayControl = {
        player: null,
        isRecordList: 0,
        conf: "",
        init: function(e) {
            return this
        },
        setUp: function(e, o) {
            var n = this;
            n.isRecordList = o || 0;
            var i = {
                flashplayer: "http://static.inke.cn/web/common/swf/jwplayer.flash.swf",
                width: "100%",
                height: "100%",
                primary: "flash",
                events: {
                    onPlay: n.onPlay,
                    onPause: n.onPause,
                    onBuffer: n.onBuffer,
                    onDisplayClick: n.onDisplayClick,
                    onSetupError: n.onSetupError,
                    onComplete: n.onComplete,
                    onIdle: n.onIdle,
                    onError: n.onError
                }
            };
            $.extend(!0, i, e || {}),
            n.player = jwplayer("liveMedia").setup(i)
        },
        onPlay: function() {
            console.log("onPlay")
        },
        onPause: function() {
            console.log("onPause")
        },
        onBuffer: function() {
            console.log("onBuffer")
        },
        onDisplayClick: function() {
            console.log("onDisplayClick")
        },
        onSetupError: function() {
            console.log("onSetupError", arguments)
        },
        onComplete: function() {
            liveEndFn(),
            console.log("onComplete")
        },
        onIdle: function() {
            console.log("onIdle", arguments)
        },
        onError: function() {
            console.error("player onError", arguments)
        },
        bindEvent: function() {}
    },
    Chat = function(s) {
        var a = this;
        this.socket = null,
        this.enter_room = function(e, o) {
            s.token,
            _isLogin ? s.token_time: s.time,
            s.nonce,
            s.sec;
            if (null != this.socket) {
                this.socket.emit("c.lr", {
                    b: {
                        ev: "c.lr"
                    }
                })
            }
            var n = s.sio_ip;
            Util.regs.http.test(n) || (n = protocol + "//" + n);
            var i, t;
            this.socket = (i = s.chartroom.url, (t = new WebSocket(i)).on = t.addEventListener, t.disconnect = t.close, t.emit = function() {},
            t),
            this.socket.on("connect",
            function(e) {}),
            this.socket.on("message",
            function(e, o) {
                var n = e.data;
                if (o && o(), null != (n = json_decode(n))) {
                    if (void 0 !== n.b && "s.d" == n.b.ev && ($commentsBox.hide(), $comments.css("background", '#f5f5f5 url("./images/comments_bg.png") no-repeat 50% 50%'), alertHandler("您的帐号同时在客户端登录，为了保证您的观看质量，建议您去客户端继续观看哦！"), a.leave_room()), void 0 !== n.b && "s.m" == n.b.ev) {
                        var i = a.parse_message(n);
                        a.show_message(i),
                        -1 < agent.indexOf("applewebkit/") && a.showGift(n)
                    }
                    void 0 !== n.b && "s.m" == n.b.ev && void 0 !== n.ms && 1 == n.ms.length && (n.ms[0].tp, "usernu" == n.ms[0].tp && void 0 !== n.ms[0].n && 0 < parseInt(n.ms[0].n) && $liveInfo.find("li:first span").html(n.ms[0].n)),
                    void 0 !== n.b && "c.g" == n.b.ev && gift.after_send(n)
                }
            })
        },
        this.send = function(e) {
            var o = {
                b: {
                    ev: "c.ch"
                },
                c: e
            };
            this.socket.send(JSON.stringify(o));
            var n = [{
                nick: JSON.parse(initData.userInfo).name,
                level: JSON.parse(initData.userInfo).level,
                gender: JSON.parse(initData.userInfo).gender,
                msg: e
            }];
            this.show_message(n)
        },
        this.parse_message = function(e) {
            var o = [];
            if (void 0 !== e.b && void 0 !== e.b.ev && "s.m" == e.b.ev && void 0 !== e.ms && e.ms.length) for (var n = e.ms,
            i = 0; i < n.length; i++) void 0 !== n[i].from && void 0 !== n[i].c && o.push({
                nick: n[i].from.nic,
                msg: n[i].c,
                level: n[i].from.lvl,
                gender: n[i].from.gd
            });
            return o
        },
        this.show_message = function(e) {
            level.data && (localStorage.level = JSON.stringify(level.data));
            for (var o = JSON.parse(localStorage.level), n = 0; n < e.length; n++) {
                var i = "comments_text"; - 1 != e[n].msg.indexOf("我送了") && (i = "comments_gift");
                var t = o[e[n].level + "_" + e[n].gender],
                s = '<li><img src="' + Util.getImgUrlAdapter(t) + '" alt="第' + e[n].level + '级" /><span>' + e[n].nick + '：</span><span class="' + i + '">' + e[n].msg + "</span></li>";
                $commentsBox.find("ul").append(s)
            } ! _isScroll && $commentsBox.find("ul").innerHeight() > $commentsBox.height() && $commentsBox.scrollTop($commentsBox.find("ul").innerHeight() - $commentsBox.height()),
            60 < $commentsBox.find("ul").children().length && $commentsBox.find("ul li:first").remove()
        },
        this.send_gift = function(e, o, n, i) {
            var t = {
                b: {
                    ev: "c.g"
                },
                id: e.id,
                repeat: o,
                cl: [255, 255, 255],
                to: n,
                seq: i
            };
            this.socket.send(JSON.stringify(t))
        },
        this.leave_room = function() {
            this.socket.disconnect()
        },
        this.showGift = function(e) {
            for (var o = 0; o < e.ms.length; o++) {
                if (!e.ms[o].gift) return;
                var n = e.ms[o].gift,
                i = e.ms[o].from,
                t = n.seq ? n.seq: 0,
                s = {
                    nick: i.nic,
                    ptr: i.ptr,
                    fromId: i.id,
                    num: t,
                    giftId: n.id,
                    type: n.name
                };
                ShowGiftAnimate.init(s)
            }
        }
    },
    "game" == Util.getQueryString("type") && Util.getQueryString("addr") && init_game();
    var clipboard = new Clipboard(".game-tit-push-url-addr-btn", {
        target: function() {
            return document.getElementById("game-tit-push-url-addr")
        }
    });
    clipboard.on("success",
    function(e) {
        console.log(e)
    }),
    clipboard.on("error",
    function(e) {
        console.log(e),
        alert("复制失败，请手动复制~")
    })
});