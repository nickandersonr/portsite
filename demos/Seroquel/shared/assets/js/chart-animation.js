//var $step0LineViolet = $("#step0 #line-violet"),
var		$flagBox = $(".flag-box"),
			$circle = $(".circle"),
			$verticalLineCover = $(".vertical-line-cover"),
			//counter = 0,
			counterBorder = 0,
			perc = 59;

	$(".callout-dial-two").knob();

	$(".refresh").on("touchend",function(){
		resetAll();
		setTimeout(function(){gotFocus();},500);
	});


function gotFocus(){		
	$verticalLineCover.fadeIn(50,function(){

		setTimeout(function(){
			$verticalLineCover.addClass("week1");
			$(".pink-circle, .black-square").delay(250).fadeIn(125);
			
			$(".flag-box-on-line, .white-cover").delay(250).fadeIn(125);


			setTimeout(function(){
				$verticalLineCover.addClass("complete");
				$verticalLineCover.removeClass("week1");
				$(".pink-circle, .black-square").fadeOut(150);
				$(".flag-box-on-line").fadeOut(25);
			},1000);
		});
	});

	$flagBox.delay(1000).fadeIn(250,function(){

		$circle.addClass("show");	

		setTimeout(function(){
			sum = setInterval(function(){
				if(counterBorder < perc){
					$(".callout-dial").val(counterBorder).trigger("change");
					$(".callout-dial-two").val(counterBorder).trigger("change");
					counterBorder++;
				}
				else{
					clearInterval(sum);
					sum = null;
				}
			},10);
		},250);

		$("#slideGraphLabels.on-graph").delay(500).fadeIn(125);

		//setTimeout(function(){
			//sum2 = setInterval(function(){
				//if(counter < perc){
					//$(".callout-text .count").text(counter);
					//counter++;
				//}
				//else{
					//clearInterval(sum2);
					//sum2 = null;
				//}
			//},20);
		//},500);
	});
    
}

//function setViewName(name){
    
//}

function lostFocus(){
	location.reload();
}


function resetAll(){
	$verticalLineCover.removeClass("week1 complete");
	$(".pink-circle, .black-square").fadeOut(0);
	$(".flag-box-on-line, .white-cover").fadeOut(0);
	$("#slideGraphLabels.on-graph").fadeOut(0);

	$flagBox.fadeOut(15);
	$circle.removeClass("show");	

	counterBorder = 0;

	$(".callout-dial").val(counterBorder).trigger("change");
	$(".callout-dial-two").val(counterBorder).trigger("change");
}

