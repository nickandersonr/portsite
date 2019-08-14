    if (window.DeviceOrientationEvent) {
        window.addEventListener('deviceorientation', function (eventData) {
            var tiltLR = eventData.gamma;
            var tiltFB = eventData.beta;
            var dir = eventData.alpha
            deviceOrientationHandler(tiltLR, tiltFB, dir);
        }, false);
    }

    

    function deviceOrientationHandler(tiltLR, tiltFB, dir) {
        
        if ((tiltFB >= 45 && tiltFB <= 90) || (tiltFB <= -45 && tiltFB >= -90)) {
        
            var el = document.getElementById("toolkit_body");
            el.style.display = "block";
            
            var gammaCorrect = 1;
//            if(tiltLR > 10) {
//                gammaCorrect = -1    
//            } else {
//                gammaCorrect = 1
//            }
            
            
            
            if (tiltFB <= -45 && tiltFB >= -90) {
                el.style.webkitTransform = "rotate("+ 90 * gammaCorrect + "deg)"
            } else {
                el.style.webkitTransform = "rotate("+-90 * gammaCorrect +"deg)"
            }

        } else {
            
            var el = document.getElementById("toolkit_body");
            el.style.display = "none";
        
        }

    }