var lastSlide = sessionStorage.getItem('lastSlide');;
var currentSlide;
var clickCount = 0;

function navigateTo(slide, presentation) {
    //alert(slide + "," + presentation);
    var runningInVeeva = (location.hostname == "" && navigator.userAgent.indexOf("Mobile") > 0);
    if (runningInVeeva) {
        if (presentation == undefined) {
            slide = "veeva:gotoSlide(" + slide + ".zip)";
            //veeva:gotoSlide(Key Message External ID *)
        } else {
            slide = "veeva:gotoSlide(" + slide + ".zip,US-VYV-" + presentation + ")";
            //veeva:gotoSlide(Key Message External ID, CLM Presentation External ID)

        }
    } else {
        slide += ".html";
    }
    window.location.href = slide;
}

// Functions to handle "local storage" this works *fairly* well in iRep

function persistValue(key, value) {
    if (value.length < 1) {
        localStorage.removeItem(key);
    } else {
        localStorage.setItem(key, value);
    }
}

function clearValue(key) {
    persistValue(key, '');
}

function getValue(key) {
    return localStorage.getItem(key);
}


var lastSlide = sessionStorage.getItem('lastSlide');;
var currentSlide;

$(document).ready(function () {

    $('INPUT, TEXTAREA').blur(function () {
        window.scrollTo(0, 0);
    });

    //menu highlighting
    var url = window.location.pathname;
    var filename = "";
    filename = url.substring(url.lastIndexOf('/') + 1);
    filename = filename.substring(0, filename.lastIndexOf('.'));

    $(".menu a").each(function () {
        if ($(this).attr('href') == filename) $(this).addClass('currentSlide');
    });

    //prevent default link behaviour
    $('a').click(function (e) {
        e.preventDefault(); //prevent the damn spinner..like everywhere
    });

    //"Back Button"
    currentSlide = filename;
    sessionStorage.setItem('lastSlide', currentSlide);

    // toggle menu
    $('.menu .handle').click(function () {
        if (!$(".menu").hasClass("active")) {
            $(".menu-overlay").addClass("z-top");
            $(".handle").animate({ right: "0px" }, 100);
        }
        $('.menu-overlay').toggleClass('active', 450, 'easeOutSine', function () {
            if (!$(".menu-overlay").hasClass("active")) {
                $(".menu-overlay").removeClass("z-top");
                $(".handle").animate({ right: "-53px" }, 100);
            }
        });
        $('.menu').toggleClass('active', 250, 'easeOutSine');
    });

    // veeva linking 
    $('*[data-nav="true"]').click(function (e) {
        var slide = $(this).attr("href").toLowerCase();
        var presentation = $(this).data("presentation");
        sessionStorage.deepLink = $(this).data("deeplink");
        navigateTo(slide, presentation);
        e.preventDefault();
    });


    //show version info
    $('.logobutton').click(function () {
        clickCount++;
        if (clickCount == 3) {
            $.ajax({
                url: "Content/version/version_info.txt",
                dataType: 'text'
            }).done(function (html) {
                $(".versioninfo").html(html);
            });

            $('.versioninfo').show();
        }
    });

    var oldOverlayZIndex = 0;
    $('#functional-overlay-trigger').click(function (e) {
        oldOverlayZIndex = $(".menu-overlay").css("z-index");
        $(".menu-overlay").css("z-index", 499);
        $('.menu').removeClass('active');
        $('.menu .expandable').removeClass('active');
        $('#functional-overlay-confirmation').fadeIn();
        e.preventDefault();
    });

    $('#continue-button').click(function (e) {
        $('.functional-overlay').show();
        $('.menu-overlay').removeClass('active');
        $('#functional-overlay-confirmation').hide();
        $(".menu-overlay").removeClass("z-top");
        $(".menu-overlay").css("z-index", oldOverlayZIndex);
        e.preventDefault();
    });

    $('#cancel-button').click(function (e) {
        $('#functional-overlay-confirmation').hide();
        $('.menu-overlay').removeClass('active');
        $(".menu-overlay").removeClass("z-top");
        $(".menu-overlay").css("z-index", oldOverlayZIndex);
        e.preventDefault();
    });

    $('.functional-overlay').click(function () {
        $('.functional-overlay').hide();
    });

    // prevent "bouncy" scrolling
    document.ontouchmove = function (e) { e.preventDefault(); };

    // allow :active styles in mobile safari
    document.addEventListener("touchstart", function () {
    }, true);

    //DropDown.prototype = {
    //    initEvents: function () {
    //        var obj = this;

    //        obj.dd.on('click', function (event) {
    //            $(this).toggleClass('active');
    //            return false;
    //        });

    //        obj.opts.on('click', function () {
    //            var opt = $(this);
    //            obj.val = opt.text();
    //            obj.index = opt.index();
    //            obj.placeholder.text(obj.val);
    //        });
    //    },
    //    getValue: function () {
    //        return this.val;
    //    },
    //    getIndex: function () {
    //        return this.index;
    //    }
    //};

});

//closeBotton
$(".btn-close").click(function () {
    if (lastSlide != "") {
        navigateTo(lastSlide, undefined);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    textInput = document.querySelector('input');
    new FastClick(document.body);
});