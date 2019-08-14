var runningInVeeva = (location.hostname == "" && navigator.userAgent.indexOf("Mobile") > 0);
var isIREP = runningInVeeva; //legacy
var video; 

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

function playVideo(theUrl) {
    theUrl += ".mp4";
    video.src = theUrl;
    video.type = "video/mp4";
    $('#player').show();
    $('#player').click(function() {
        video.pause();
        $('#player').hide();
    });
    
    //$("video").bind("ended", function () {
    //    alert("I'm done!");
    //});
    //window.location.href = theUrl;
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


function saveToCSCallback(result) {
    if (!result.success) {
        alert("API Call Failed(" + result.code + ":" + result.message + ")");
    }
}

function saveToCS(questionFieldValue, answerFieldValue) {
    var fieldValues = {};
    fieldValues.Answer_vod__c = answerFieldValue;
    fieldValues.Question_vod__c = questionFieldValue;
    if (isIREP) {
        com.veeva.clm.createRecord("Call_Clickstream_vod__c", fieldValues, saveToCSCallback);
    } else {
        console.log('Veeva API Call Skipped');
    }
}




// prevent "bouncy" scrolling
document.ontouchmove = function (e) { e.preventDefault(); };

// allow :active styles in mobile safari
document.addEventListener("touchstart", function () { }, true);



$(document).ready(function () {
    video = document.getElementById('video-player');
    
    video.addEventListener("play", function () {
         saveToCS('Video Playing', video.src);
         console.log('playing');
    }, true);
    video.addEventListener("ended", function () {
        saveToCS('Video Stopped', video.src);
         console.log('stopped');
    }, true);
    video.addEventListener("pause", function () {
         saveToCS('Video Paused', video.src);
         console.log('stopped');
    }, true);
	//Prevent A tag clicking
	$('a').click(function (e) {
		e.preventDefault(); 
	});

	//menu highlighting
	var url = window.location.pathname;
	var filename = "";
	filename = url.substring(url.lastIndexOf('/') + 1);
	filename = filename.substring(0, filename.lastIndexOf('.'));
	$("#menu div ul li a").each(function () {
	    if ($(this).attr('href') == filename) $(this).parent().addClass('active');
	});
	$("#footer ul li a").each(function () {
	    if ($(this).attr('href') == filename) $(this).parent().addClass('active');
	});

	// veeva linking 
	$('*[data-nav="true"]').click(function (e) {
	    var slide = $(this).attr("href").toLowerCase();
	    var presentation = $(this).data("presentation");
	    navigateTo(slide, presentation);
	    e.preventDefault();
	});
    
    // video linking 
	$('*[data-video="true"]').click(function (e) {
	    var theUrl = $(this).attr("href");
	    playVideo(theUrl);
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
});



