'use strict';
var veevaVariables = {};

/*
 This code will enable scrolling on an element, or array of elements.
 This does not require jQuery or any external libraries, but you MUST
 use the "querySelectorAll" function otherwise it will not work.
 
 Example(s):
     
     allowScroll(document.querySelectorAll('.scroll'));
     allowScroll(document.querySelectorAll('#scroll_area_1'));
*/

var allowScroll = function (els) {
    if (els.length > 0) {
        for (var i = 0; i < els.length; i++) {
            addOverscroll(els[i]);
        }
    }
}

var addOverscroll = function (el) {
    console.log(el);
    if (el != null) {

        el.addEventListener('touchstart', function () {
            var top = el.scrollTop,
                totalScroll = el.scrollHeight,
                currentScroll = top + el.offsetHeight
                //If we're at the top or the bottom of the containers
                //scroll, push up or down one pixel.
                //
                //this prevents the scroll from "passing through" to
                //the body.
            if (top === 0) {
                el.scrollTop = 1
            } else if (currentScroll === totalScroll) {
                el.scrollTop = top - 1
            }
        })
        el.addEventListener('touchmove', function (evt) {
            //if the content is actually scrollable, i.e. the content is long enough
            //that scrolling can occur
            if (el.offsetHeight < el.scrollHeight)
                evt._isScroller = true
        })
    }
}

//prevent scrolling on anything unless we have allowed it
document.body.addEventListener('touchmove', function (evt) {
    if (!evt._isScroller) {
        evt.preventDefault()
    }
});

//allow scrolling on anything with the class 'scrollable'
document.addEventListener("DOMContentLoaded", function (event) {
    allowScroll(document.querySelectorAll('.scrollable'));
});

// allow :active styles in mobile safari
document.addEventListener("touchstart", function () {}, true);



/*

Basic Animation functions that dont require jQuery.

*/

(function () {
    var PageEffects = {
        easing: {
            linear: function (progress) {
                return progress;
            },
            quadratic: function (progress) {
                return Math.pow(progress, 2);
            },
            swing: function (progress) {
                return 0.5 - Math.cos(progress * Math.PI) / 2;
            },
            circ: function (progress) {
                return 1 - Math.sin(Math.acos(progress));
            },
            back: function (progress, x) {
                return Math.pow(progress, 2) * ((x + 1) * progress - x);
            },
            bounce: function (progress) {
                for (var a = 0, b = 1, result; 1; a += b, b /= 2) {
                    if (progress >= (7 - 4 * a) / 11) {
                        return -Math.pow((11 - 6 * a - 11 * progress) / 4, 2) + Math.pow(b, 2);
                    }
                }
            },
            elastic: function (progress, x) {
                return Math.pow(2, 10 * (progress - 1)) * Math.cos(20 * Math.PI * x / 3 * progress);
            }
        },
        animate: function (options) {
            var start = new Date;
            var id = setInterval(function () {
                var timePassed = new Date - start;
                var progress = timePassed / options.duration;
                if (progress > 1) {
                    progress = 1;
                }
                options.progress = progress;
                var delta = options.delta(progress);
                options.step(delta);
                if (progress == 1) {
                    clearInterval(id);
                    options.complete();
                }
            }, options.delay || 10);
        },
        fadeOut: function (element, options) {
            var to = 1;
            this.animate({
                duration: options.duration,
                delta: function (progress) {
                    progress = this.progress;
                    return PageEffects.easing.swing(progress);
                },
                complete: options.complete,
                step: function (delta) {
                    element.style.opacity = to - delta;
                }
            });
        },
        fadeIn: function (element, options) {
            var to = 0;
            this.animate({
                duration: options.duration,
                delta: function (progress) {
                    progress = this.progress;
                    return PageEffects.easing.swing(progress);
                },
                complete: options.complete,
                step: function (delta) {
                    element.style.opacity = to + delta;
                }
            });
        }
    };
    window.PageEffects = PageEffects;
})()



/*

This is the code to handle navigation within iRep and the MVC. Compatible with Windows.
Anchors must be decorated with the data-nav="true" attribute to enable navigation. The 
href should not contain any extensions (ie. .html, .htm, etc...)

Example:

    <a href="US-SXR-CNS-Receptor-Affinity" data-nav="true" data-presentation="newPresExternalID">LINK</a>

*/

var runningInVeeva = ((location.hostname == "" || location.hostname.indexOf('veevamobile') > -1)) && (navigator.userAgent.indexOf("Mobile") > 0 || (navigator.userAgent.indexOf("Touch") > 0));

//This is maintained for legacy purposes. Some old scripts used this and it doesnt hurt to leave it in.
var isIREP = runningInVeeva;


function navigateTo(slide, presentation, deeplink) {
    if (deeplink != null) {
        sessionStorage.deepLink = deeplink
    }
    if (runningInVeeva) {
        slide = slide + ".zip";

        if (presentation != null) {
            com.veeva.clm.gotoSlide(slide, presentation);
        } else {
            com.veeva.clm.gotoSlide(slide);
        }


    } else {
        if (window.location.href.indexOf('.html') > -1) {
            slide += ".html";
        }
        window.location.href = slide;
    }
}

function iRepClickHandler(element) {
    var slide = element.getAttribute("href");
    var presentation = element.getAttribute("data-presentation");
    var deeplink = element.getAttribute("data-deeplink");
    PageEffects.fadeOut(document.querySelector('body'), {
        duration: 100,
        complete: function () {

        }
    });
    navigateTo(slide, presentation, deeplink);
}

//Create our own "click" event to handle navigation.
var setupiRepNavigation = function () {

    //Prevent "clicking" on all A tags so that we can replace it with our function
    var allAnchors = document.querySelectorAll('A');
    for (var i = 0; i < allAnchors.length; i++) {

        if (allAnchors[i].id != 'external_link') {
            //remove it to avoid duplication
            allAnchors[i].removeEventListener("click", function (event) {
                event.preventDefault();
            });

            //add it
            allAnchors[i].addEventListener('click', function (event) {
                event.preventDefault();
            });
        }

    }

    var iRepLinks = document.querySelectorAll('a[data-nav="true"]');
    for (var i = 0; i < iRepLinks.length; i++) {
        //remove it to avoid duplication
        iRepLinks[i].removeEventListener('click', function (event) {
            iRepClickHandler(this);
        });
        //add it
        iRepLinks[i].addEventListener('click', function (event) {
            iRepClickHandler(this);
        })
    }
}


//Setup listeners for navigation, and fire deep link events.
document.addEventListener("DOMContentLoaded", function (event) {
    setupiRepNavigation();
});

var checkForDeepLink = new Promise(function (resolve, reject) {

    var deepLink = sessionStorage.deepLink;
    sessionStorage.removeItem('deepLink');
    if (deepLink != undefined) {
        var customEvent = new CustomEvent(
            "deepLinkReady", {
                detail: {
                    deeplink: deepLink,
                },
                bubbles: false,
                cancelable: false
            }
        );
        document.dispatchEvent(customEvent);
        resolve(deepLink);
    } else {
        reject();
    }

});

/*
 This code will allow you to respond to deep link events fired by base library.
 
 Example(s):
     
     document.addEventListener("deepLinkReady", function (event) {
         var deeplink = event.detail.deeplink

         //Make sure it works
         console.log('Deep Link: ' + deeplink);

         //Do something with the link
         switch (deeplink) {
         case 'test':
             //Do something here like turn stuff on or of, or scroll down the page
             break;
         case 'test2':
         //Do something different here
         break;
         }

     });

*/


//Check for the veeva API Helper
var veevaHelper = veevaHelper || null


function initVeevaVariables() {
    veevaVariables.Account = {}
    veevaVariables.Address = {}
    veevaVariables.Call = {};
    veevaVariables.Presentation = {};
    veevaVariables.KeyMessage = {};

    if (veevaHelper != null) {

        //Create an array of calls so we can send them to Promise.all to dispatch the ready / failure event.
        var ApiCalls = [];

        /* Calls that do not require call specific objects to be wired up go here */
        
        //Presentation Id
        ApiCalls.push(veevaHelper.get(new apiValue('Presentation', 'Presentation_Id_vod__c', 'US-SXR-CNS-DSM-5'))
            .then(function (result) {
                veevaVariables.Presentation.Id = result.Presentation.Presentation_Id_vod__c;
                return result;
            }));

        //Presentation Name
        ApiCalls.push(veevaHelper.get(new apiValue('Presentation', 'Name', 'US-SXR-CNS-DSM-5'))
            .then(function (result) {
                veevaVariables.Presentation.Name = result.Presentation.Name;
                return result;
            }));

        //KeyMessage Media File
        ApiCalls.push(veevaHelper.get(new apiValue('KeyMessage', 'Media_File_Name_vod__c', 'TEST'))
            .then(function (result) {
                veevaVariables.KeyMessage.Name = result.KeyMessage.Media_File_Name_vod__c;
                return result;
            }));

        //KeyMessage Media File Version
        ApiCalls.push(veevaHelper.get(new apiValue('KeyMessage', 'Slide_Version_vod__c', '00000'))
            .then(function (result) {
                veevaVariables.KeyMessage.Version = result.KeyMessage.Slide_Version_vod__c;
                return result;
            }));
        
        /* Put any calls that will fail if we are in the media tab below this line; this ensures that the ones that can complete will complete. */
        
        //Account Id
        ApiCalls.push(veevaHelper.get(new apiValue('Account', 'Id', '00000'))
            .then(function (result) {
                veevaVariables.Account.Id = result.Account.Id;
                return result;
            }));

        //Person Name
        ApiCalls.push(veevaHelper.get(new apiValue('Account', 'Name', 'Test User'))
            .then(function (result) {
                veevaVariables.Account.Name = result.Account.Name;
                return result;
            }));

        //Address
        ApiCalls.push(veevaHelper.get(new apiValue('Address', 'Zip_vod__c', '00501'))
            .then(function (result) {
                veevaVariables.Address.Zip = result.Address.Zip_vod__c;
                return result;
            }));

        //Call Id
        ApiCalls.push(veevaHelper.get(new apiValue('Call', 'Id', '00000'))
            .then(function (result) {
                veevaVariables.Call.Id = result.Call.Id;
                return result;
            }));




        //This just waits till ALL promises have been fulfilled and then fires "then" and acts as an error handler for all the calls
        Promise.all(ApiCalls).then(function (data) {
            //All the values loaded properly
            var customEvent = new CustomEvent(
                "veevaVariablesReady", {
                    detail: {
                        status: 'success',
                        data: data,
                    },
                    bubbles: false,
                    cancelable: false
                }
            );
            document.dispatchEvent(customEvent);
        }).catch(function (err) {
            //One or more of the values failed to load, this is normal in the media tab.
            var customEvent = new CustomEvent(
                "veevaVariablesReady", {
                    detail: {
                        status: 'failure',
                        data: err,
                    },
                    bubbles: false,
                    cancelable: false
                }
            );
            document.dispatchEvent(customEvent);
        });

    }
}

//Get the variables as soon as possible.
initVeevaVariables();


/*
 This code will allow you to respond to veeva variable events fired by base library.
 
 Example(s):

 document.addEventListener("veevaVariablesReady", function (event) {
     var data = event.detail.data
     var status = event.detail.status

     //If the status is failure then decide what to do.
     switch (status) {
     case 'failure':
         //We are probably in the media tab, so this would be a good place to fake any data we need to, or alert "data" to see the error!
         break;
     case 'success':
         //Everything worked so pretty much do nothing.
         break;
     }

     //This would be a good spot to do whatever you need to with the Veeva API variable such as switch out content, or boot strap angular, etc...

 });
 
 */