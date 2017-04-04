! function($) {
    $.fn.jvmobilemenu = function(e) {
        function t() {
            settings.mainContent.css({
                minHeight: $(window).height()
            })
        }

        function n() {
            s.removeClass("open"), TweenMax.to(a, settings.slideSpeed / 2, {
                rotation: 0,
                ease: Power3.easeOut
            }), TweenMax.to(settings.mainContent, settings.slideSpeed, {
                marginLeft: 0
            }), "left" === settings.position && TweenMax.to(s, settings.slideSpeed, {
                marginLeft: o
            }), setTimeout(function() {
                settings.theMenu.css({
                    display: "none"
                })
            }, 200), settings.theMenu.css({
                "overflow-y": "hidden",
				"right": "-276px",
                "-webkit-overflow-scrolling": "inherit",
                "overflow-scrolling": "inherit"
            }), $(document).off("touchmove"), $("body").css({
                overflow: "inherit"
            })
        }

        function i() {
            s.addClass("open"), TweenMax.to(d, settings.slideSpeed / 2, {
                rotation: 45,
                ease: Power3.easeOut
            }), TweenMax.to(l, settings.slideSpeed / 2, {
                rotation: -45,
                ease: Power3.easeOut
            }), TweenMax.to(settings.mainContent, settings.slideSpeed, {
                marginLeft: theMarginLeft
            }), "left" === settings.position && TweenMax.to(s, settings.slideSpeed, {
                marginLeft: theMarginLeft - r
            }), settings.theMenu.css({
                display: "block"
            });
            var e = ".mobile-menu",
                t = $("body");
            t.css({
                overflow: "hidden"
            }), $(document).on("touchmove", function(e) {
                e.preventDefault()
            }), t.on("touchstart", e, function(e) {
                0 === e.currentTarget.scrollTop ? e.currentTarget.scrollTop = 1 : e.currentTarget.scrollHeight === e.currentTarget.scrollTop + e.currentTarget.offsetHeight && (e.currentTarget.scrollTop -= 1)
            }), t.on("touchmove", e, function(e) {
                e.stopPropagation()
            }), settings.theMenu.css({
                "overflow-y": "scroll",
				"right": "0",
                "overflow-scrolling": "touch",
                "-webkit-overflow-scrolling": "touch"
            })
        }
        settings = $.extend({
            mainContent: $(".page"),
            theMenu: $(".mobile-nav"),
            slideSpeed: .3,
            menuWidth: 240,
            position: "right",
            push: !0,
            menuPadding: "20px 20px 60px"
        }, e), $(this).prepend('<div class="hamburger hamburger--spin main-ham "><div class="hamburger-inner"><div class="bar bar1 hide"></div><div class="bar bar2 cross"></div><div class="bar bar3 cross hidden"></div><div class="bar bar4 hide"></div></div></div>'), settings.theMenu.css({
            width: settings.menuWidth,
            position: "fixed",
            top: 0,
            display: "none",
            height: "100%"
        }).addClass("mobile-menu").wrapInner('<div class="mobile-menu-inner"></div>'), $(".mobile-menu-inner").css({
            width: "auto",
            padding: settings.menuPadding,
            display: "block"
        }), t();
        var s = $(".hamburger"),
            o = parseInt(s.css("margin-left")),
            r = s.outerWidth(!0) - o,
            a = $(".bar2,.bar3"),
            d = $(".bar2"),
            l = $(".bar3");
        "left" === settings.position ? (theMarginLeft = settings.menuWidth, settings.theMenu.add(s).css({
            left: 0,
            right: "auto"
        })) : "right" === settings.position && (theMarginLeft = -settings.menuWidth, settings.theMenu.add(s).css({
            left: "auto",
            right: -276
        })), $(window).resize(function() {
            n(), t()
        }), s.on("click", function(e) {
            return $(this).hasClass("open") ? n() : i(), e.stopPropagation(), !1
        }), settings.mainContent.on("click", function() {
            s.hasClass("open") && n()
        })
    }, $.jvmobilemenu = function(e) {
        return $("body").jvmobilemenu(e)
    }
}(jQuery);