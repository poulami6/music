jQuery(document).ready(function(a) {
    "use strict";

    function s(a) {
        for (var s = a + "=", t = document.cookie.split(";"), e = 0; e < t.length; e++) {
            for (var i = t[e];
                " " == i.charAt(0);) i = i.substring(1);
            if (0 == i.indexOf(s)) return i.substring(s.length, i.length)
        }
        return ""
    }

    function t(a, s, t) {
        var e = new Date;
        e.setTime(e.getTime() + 24 * t * 60 * 60 * 1e3);
        var i = "expires=" + e.toUTCString();
        document.cookie = a + "=" + s + ";" + i + ";path=/"
    }
    jQuery(function(e) {
        if (e(".audio-player").length) {
            var i = "",
                r = new jPlayerPlaylist({
                    jPlayer: "#jquery_jplayer_1",
                    cssSelectorAncestor: "#jp_container_1"
                }, [], {
                    swfPath: "js/plugins",
                    supplied: "oga, mp3",
                    wmode: "window",
                    useStateClassSkin: !0,
                    autoBlur: !1,
                    smoothPlayBar: !0,
                    keyEnabled: !0,
                    playlistOptions: {
                        autoPlay: !1,
                        enableRemoveControls: !0
                    }
                });
            e(".play_hover").on("click", function() {
                var a = e(this).closest("ul").children("li:eq(1)").find("a").attr("data-musicid"),
                    s = e(this).closest("ul"),
                    t = "musicid=" + a;
                t += "&action=miraculous_play_single_music_action", e(".ms_ajax_loader").show(), e.ajax({
                    type: "post",
                    url: frontadminajax.ajax_url,
                    data: t,
                    success: function(a) {
                        var t = JSON.parse(a);
                        "false" != t.status ? (r.add({
                            image: t.image,
                            title: t.song_name,
                            artist: t.artists,
                            mp3: t.mp3url,
                            id: t.mid,
                            share: t.share_uri,
                            option: i
                        }), e(".ms_ajax_loader").hide(), r.play(-1), e(".ms_list_songs").removeClass("play_active_song"), e(".ms_player_wrapper").removeClass("close_player"), e(s).addClass("play_active_song"), localStorage.setItem("jp_playlist", JSON.stringify(r))) : (e(".ms_ajax_loader").hide(), toastr.error(t.msg))
                    }
                })
            }), e(".play_single_music").on("click", function() {
                var a = e(this).closest("ul").children("li:eq(1)").find("a").attr("data-musicid"),
                    s = e(this).closest("ul"),
                    t = "musicid=" + a;
                t += "&action=miraculous_play_single_music_action", e(".ms_ajax_loader").show(), e.ajax({
                    type: "post",
                    url: frontadminajax.ajax_url,
                    data: t,
                    success: function(a) {
                        var t = JSON.parse(a);
                        "false" != t.status ? (r.add({
                            image: t.image,
                            title: t.song_name,
                            artist: t.artists,
                            mp3: t.mp3url,
                            id: t.mid,
                            share: t.share_uri,
                            option: i
                        }), e(".ms_ajax_loader").hide(), r.play(-1), e(".ms_list_songs").removeClass("play_active_song"), e(".ms_player_wrapper").removeClass("close_player"), e(s).addClass("play_active_song"), localStorage.setItem("jp_playlist", JSON.stringify(r))) : (e(".ms_ajax_loader").hide(), toastr.error(t.msg))
                    }
                })
            }), e(".play_list_music").on("click", function() {
                var a = "playlist=" + e(this).attr("data-list");
                a += "&action=miraculous_play_user_playlist", e(".ms_ajax_loader").show(), e.ajax({
                    type: "post",
                    url: frontadminajax.ajax_url,
                    data: a,
                    success: function(a) {
                        var s = JSON.parse(a);
                        "false" != s.status ? (e.each(s, function(a, s) {
                            r.add({
                                image: s.image,
                                title: s.song_name,
                                artist: s.artists,
                                mp3: s.mp3url,
                                id: s.mid,
                                share: s.share_uri,
                                option: i
                            })
                        }), e(".ms_ajax_loader").hide(), r.play(0), e(".ms_player_wrapper").removeClass("close_player"), localStorage.setItem("jp_playlist", JSON.stringify(r))) : (e(".ms_ajax_loader").hide(), toastr.error(s.msg))
                    }
                })
            }), e(document).on("click", ".play_music", function() {
                e(this).removeClass("play_music"), e(this).addClass("pause_music btn_pause");
                var a = e(this).attr("data-musicid"),
                    s = e(this).attr("data-musictype"),
                    t = "musicid=" + a + "&musictype=" + s;
                t += "&action=miraculous_play_all_music_action", e(".ms_ajax_loader").show(), r.remove(), e.ajax({
                    type: "post",
                    url: frontadminajax.ajax_url,
                    data: t,
                    success: function(a) {
                        var t = JSON.parse(a);
                        "false" != t.status ? (e.each(t, function(a, s) {
                            r.add({
                                image: s.image,
                                title: s.song_name,
                                artist: s.artists,
                                mp3: s.mp3url,
                                id: s.mid,
                                share: s.share_uri,
                                option: i
                            })
                        }), e(".ms_ajax_loader").hide(), "radio" == s && e(".audio-player").addClass("ms_played_radio"), r.play(0), e(".ms_list_songs").removeClass("play_active_song"), e(".ms_player_wrapper").removeClass("close_player"), localStorage.setItem("jp_playlist", JSON.stringify(r))) : toastr.error(t.msg)
                    }
                })
            }), e(document).on("click", ".pause_music", function() {
                e(this).removeClass("pause_music btn_pause"), e(this).addClass("play_music"), e("#jquery_jplayer_1").jPlayer("pause")
            }), e(".add_to_queue").on("click", function() {
                var a = "musicid=" + e(this).attr("data-musicid") + "&musictype=" + e(this).attr("data-musictype");
                a += "&action=miraculous_add_to_queue_action", e(".ms_ajax_loader").show(), e.ajax({
                    type: "post",
                    url: frontadminajax.ajax_url,
                    data: a,
                    success: function(a) {
                        var s = JSON.parse(a);
                        "false" != s.status ? (e.each(s, function(a, s) {
                            0 == a && e(".jp-now-playing").html().length <= 0 && (e(".jp-now-playing").html("<div class='jp-track-name'><span class='que_img'><img src='" + s.image + "'></span><div class='que_data'>" + s.song_name + " <div class='jp-artist-name'>" + s.artists + "</div></div></div>"), e(".jp_cur_download").attr("data-msmusic", s.mid), e(".jp_cur_favourite").attr("data-musicid", s.mid), e(".jp_cur_playlist").attr("data-msmusic", s.mid), e(".jp_cur_share").attr("data-shareuri", s.share_uri), e(".jp_cur_share").attr("data-sharename", s.song_name)), r.add({
                                image: s.image,
                                title: s.song_name,
                                artist: s.artists,
                                mp3: s.mp3url,
                                id: s.mid,
                                share: s.share_uri,
                                option: i
                            })
                        }), e(".ms_ajax_loader").hide(), e(".ms_player_wrapper").removeClass("close_player"), toastr.success("Added to Queue Successfully.")) : toastr.error(s.msg)
                    }
                })
            }), e(".save_queue_list").on("click", function() {
                var a = JSON.stringify(r),
                    s = "musiclist=" + a;
                s += "&action=miraculous_user_queue_data_action", e(".ms_ajax_loader").show(), a ? e.ajax({
                    type: "post",
                    url: frontadminajax.ajax_url,
                    data: s,
                    success: function(a) {
                        var s = JSON.parse(a);
                        "success" == s.status ? toastr.success(s.msg) : toastr.error(s.msg), e(".ms_ajax_loader").hide()
                    }
                }) : toastr.error("Your queue is empty.")
            }), e(".ms_remove_all").on("click", function() {
                r.remove(), localStorage.removeItem("jp_playlist"), e("#jquery_jplayer_1").jPlayer("clearMedia"), toastr.success("Removed all from Queue"), e("#clear_modal").modal("hide"), e(".ms_list_songs").removeClass("play_active_song"), e(".ms_empty_queue").html("Queue is empty"), e(".jp-now-playing").html(""), e(".ms_player_wrapper").addClass("close_player")
            }), e(".ms_cancel").on("click", function() {
                e("#clear_modal").modal("hide")
            }), e(window).on("load", function() {
                var a = JSON.parse(localStorage.getItem("jp_playlist"));
                localStorage.getItem("current_song", l);
                if (a) {
                    var t = a.playlist,
                        l = a.current;
                    e.each(t, function(a, s) {
                        r.add({
                            image: s.image,
                            title: s.title,
                            artist: s.artist,
                            mp3: s.mp3,
                            id: s.id,
                            share: s.share,
                            option: i
                        }), a == l && (e(".jp-now-playing").html("<div class='jp-track-name'><span class='que_img'><img src='" + s.image + "'></span><div class='que_data'>" + s.title + " <div class='jp-artist-name'>" + s.artist + "</div></div></div>"), e(".jp_cur_download").attr("data-msmusic", s.id), e(".jp_cur_favourite").attr("data-musicid", s.id), e(".jp_cur_playlist").attr("data-msmusic", s.id), e(".jp_cur_share").attr("data-shareuri", s.share), e(".jp_cur_share").attr("data-sharename", s.title)), localStorage.setItem("current_song", l)
                    });
                    var o = s("MJTCURRENTTIME"),
                        n = s("MJTCURRENTSONG");
                    "" != o && "" != n && r.play(n, parseInt(o))
                } else {
                    var u = "musiclist=queue";
                    u += "&action=miraculous_user_load_queue_data_action", e.ajax({
                        type: "post",
                        url: frontadminajax.ajax_url,
                        data: u,
                        success: function(a) {
                            var s = JSON.parse(a);
                            if ("success" == s.status) {
                                var t = JSON.parse(s.queue_data);
                                if (t) {
                                    var l = t.playlist,
                                        o = t.current;
                                    e.each(l, function(a, s) {
                                        r.add({
                                            image: s.image,
                                            title: s.title,
                                            artist: s.artist,
                                            mp3: s.mp3,
                                            id: s.id,
                                            share: s.share,
                                            option: i
                                        }), a == o && (e(".jp-now-playing").html("<div class='jp-track-name'><span class='que_img'><img src='" + s.image + "'></span><div class='que_data'>" + s.title + " <div class='jp-artist-name'>" + s.artist + "</div></div></div>"), e(".jp_cur_download").attr("data-msmusic", s.id), e(".jp_cur_favourite").attr("data-musicid", s.id), e(".jp_cur_playlist").attr("data-msmusic", s.id), e(".jp_cur_share").attr("data-shareuri", s.share), e(".jp_cur_share").attr("data-sharename", s.title)), localStorage.setItem("current_song", o)
                                    })
                                }
                            }
                            "default" == s.status && (r.add({
                                image: s.image,
                                title: s.song_name,
                                artist: s.artists,
                                mp3: s.mp3url,
                                id: s.mid,
                                share: s.share_uri,
                                option: i
                            }), e(".jp-now-playing").html("<div class='jp-track-name'><span class='que_img'><img src='" + s.image + "'></span><div class='que_data'>" + s.song_name + " <div class='jp-artist-name'>" + s.artists + "</div></div></div>"), e(".jp_cur_download").attr("data-msmusic", s.mid), e(".jp_cur_favourite").attr("data-musicid", s.mid), e(".jp_cur_playlist").attr("data-msmusic", s.mid), e(".jp_cur_share").attr("data-shareuri", s.share_uri), e(".jp_cur_share").attr("data-sharename", s.song_name))
                        }
                    })
                }
            }), e("#jquery_jplayer_1").on(e.jPlayer.event.ready + " " + e.jPlayer.event.play, function(a) {
                var s = r.current,
                    t = r.playlist;
                e.each(t, function(a, t) {
                    a == s && (e(".jp-now-playing").html("<div class='jp-track-name'><span class='que_img'><img src='" + t.image + "'></span><div class='que_data'>" + t.title + " <div class='jp-artist-name'>" + t.artist + "</div></div></div>"), e(".jp_cur_download").attr("data-msmusic", t.id), e(".jp_cur_favourite").attr("data-musicid", t.id), e(".jp_cur_playlist").attr("data-msmusic", t.id), e(".jp_cur_share").attr("data-shareuri", t.share), e(".jp_cur_share").attr("data-sharename", t.title)), localStorage.setItem("current_song", s), i = "musicid=" + t.id, i += "&action=miraculous_play_single_music_action", e.ajax({
                        type: "post",
                        url: frontadminajax.ajax_url,
                        data: i,
                        success: function(a) {}
                    })
                }), e(".knob-wrapper").mousedown(function() {
                    return e(window).mousemove(function(a) {
                        var s = function(a) {
                            var s = a.css("-webkit-transform") || a.css("-moz-transform") || a.css("-ms-transform") || a.css("-o-transform") || a.css("transform");
                            if ("none" !== s) var t = s.split("(")[1].split(")")[0].split(","),
                                e = t[0],
                                i = t[1],
                                r = Math.round(Math.atan2(i, e) * (180 / Math.PI));
                            else r = 0;
                            return r < 0 ? r + 360 : r
                        }(e(".knob")) / 270;
                        s > 1 ? e("#jquery_jplayer_1").jPlayer("volume", 1) : s <= 0 ? e("#jquery_jplayer_1").jPlayer("mute") : (e("#jquery_jplayer_1").jPlayer("volume", s), e("#jquery_jplayer_1").jPlayer("unmute"))
                    }), !1
                }).mouseup(function() {
                    e(window).unbind("mousemove")
                });
                var i = !1;
                e(".jp-play-bar").mousedown(function(a) {
                    i = !0, l(a.pageX)
                }), e(document).mouseup(function(a) {
                    i && (i = !1, l(a.pageX))
                }), e(document).mousemove(function(a) {
                    i && l(a.pageX)
                });
                var l = function(a) {
                    var s = e(".jp-progress"),
                        t = 100 * (a - s.offset().left) / s.width();
                    t > 100 && (t = 100), t < 0 && (t = 0), e("#jquery_jplayer_1").jPlayer("playHead", t), e(".jp-play-bar").css("width", t + "%")
                };
                e("#playlist-toggle, #playlist-text, #playlist-wrap li a").unbind().on("click", function() {
                    e("#playlist-wrap").fadeToggle(), e("#playlist-toggle, #playlist-text").toggleClass("playlist-is-visible")
                }), e(".hide_player").unbind().on("click", function() {
                    e(".audio-player").toggleClass("is_hidden"), e(this).html('<i class="fa fa-angle-down"></i> HIDE' == e(this).html() ? '<i class="fa fa-angle-up"></i> SHOW PLAYER' : '<i class="fa fa-angle-down"></i> HIDE')
                }), e("body").unbind().on("click", ".audio-play-btn", function() {
                    e(".audio-play-btn").removeClass("is_playing"), e(this).addClass("is_playing");
                    var a = e(this).data("playlist-id");
                    r.play(a)
                })
            }), a("#jquery_jplayer_1").bind(a.jPlayer.event.play, function(s) {
                t("MJTCURRENTSONG", r.current, 1), a("#jquery_jplayer_1").bind(a.jPlayer.event.timeupdate, function(a) {
                    t("MJTCURRENTTIME", Math.trunc(a.jPlayer.status.currentTime), 1)
                })
            })
        }
    })
});