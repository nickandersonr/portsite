var mddURL = [
    'US-SXR-CNS-Versatility',
    'US-SXR-CNS-Indication-Comparison',
    'US-SXR-CNS-Efficacy-in-MDD',
    'US-SXR-CNS-Dosing-in-MDD',
    'US-SXR-CNS-Safety',
    'US-SXR-CNS-Tolerability',
    'US-SXR-CNS-Formulary-Framework',
    'US-SXR-CNS-Summary',
    'US-SXR-CNS-Email'
];
var mddPrez = [
    'US-SXR-CNS-Receptor-Affinity',
    'US-SXR-CNS-Patient-Profile-MDD',
    'US-SXR-CNS-Patient-Profile-MDD',
    'US-SXR-CNS-Patient-Profile-MDD',
    'US-SXR-CNS-Patient-Profile-Bipolar-I-and-II',
    'US-SXR-CNS-Tolerability',
    'US-SXR-CNS-Access',
    'US-SXR-CNS-Patient-Profile-Bipolar-I-and-II',
    'US-SXR-CNS-Email'
];
var bpdURL = [
    'US-SXR-CNS-Versatility',
    'US-SXR-CNS-Indication-Comparison',
    'US-SXR-CNS-Efficacy-in-BPD',
    'US-SXR-CNS-Dosing-in-BPD',
    'US-SXR-CNS-Safety',
    'US-SXR-CNS-Tolerability',
    'US-SXR-CNS-Formulary-Framework',
    'US-SXR-CNS-Summary',
    'US-SXR-CNS-Email'
];
var bpdPrez = [
    'US-SXR-CNS-Receptor-Affinity',
    'US-SXR-CNS-Patient-Profile-Bipolar-I-and-II',
    'US-SXR-CNS-Patient-Profile-Bipolar-I-and-II',
    'US-SXR-CNS-Patient-Profile-Bipolar-I-and-II',
    'US-SXR-CNS-Patient-Profile-Bipolar-I-and-II',
    'US-SXR-CNS-Tolerability',
    'US-SXR-CNS-Access',
    'US-SXR-CNS-Patient-Profile-Bipolar-I-and-II',
    'US-SXR-CNS-Email'
];
var refDosing2 = [];
var refPk = [];

function hidePopup() {
    $('#patient-popup').hide();
    $('#chart-popup').hide();
    for (i = 1; i <= 10; i++) {
        $('#patient-popup-' + i).hide();
    }
}

function setURLs() {
    if ($('#switch').attr('class') == 'btn-switch') {
      for (i = 0; i <= 8; i++) {
          $('#so-' + i).attr('href', bpdURL[ i ]);
          $('#so-' + i).attr('data-presentation', bpdPrez[ i ]);
      }
    } else {

        for (i = 0; i <= 8; i++) {
            $('#so-' + i).attr('href', mddURL[ i ]);
            $('#so-' + i).attr('data-presentation', mddPrez[ i ]);
        }
    }
}

/* DSM-5 */
var dsm5Answers = ["1-1", "2-2", "3-2", "4-2", "5-2", "6-1", "6-2"];
function setAnswers(answerArray, selectedClass) {
    switch (answerArray) {
        case 'dsm5Answers':
            tmpArray = dsm5Answers;
            break;
    }
    for (i = 0; i <= tmpArray.length; i++) {
        var el = $('#' + tmpArray[i]);
        el.css({opacity: 0.0});
        el.addClass(selectedClass);
        el.animate({opacity: '1.0'}, "slow");

    }
}
function resetAnswers(answerArray, selectedClass) {
    switch (answerArray) {
        case 'dsm5Answers':
            tmpArray = dsm5Answers;
            break;
    }
    for (i = 0; i <= tmpArray.length; i++) {
        var el = $('#' + tmpArray[i]);
        el.removeClass(selectedClass);
    }
    for (i = 1; i <= 10; i++) {
        for (j = 1; j <= 2; j++) {
            $('#' + i + '-' + j).html('');
        }
    }
}

$(document).ready(function () {
    setURLs();
    $('.s-logo').on('click', function (e) {
        e.preventDefault();
        $('#s-navbar').show();
    });

    $('.btn-switch').on('click', function (e) {
        e.preventDefault();
        if ($(this).attr('class') == 'btn-switch') {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }
        setURLs();
    });

    $('#patient-list a').on('click', function (e) {
        $('#patient-list').fadeOut('slow');
        localStorage.SXRPatientImage = $(this).data('patient');
    });
    
    $('.profile-selection-buttons a').on('click', function (e) {
        sessionStorage.AccessSelection = $(this).data('plan');
    });

    //$('.btn-open').on('click', function (e) {
    $(document).on('click', '.btn-open', function (e) {
        e.preventDefault();
        hidePopup();
        $('#page-overlay').show();
        tmpRel = $(this).attr('rel');

        if(tmpRel == 'empty'){
            $('#page-overlay').hide();
        }else{
            $('#page-overlay').show();
        }

        if (tmpRel != '') {
            $('#' + tmpRel).show();
        } else {
            $('#patient-popup').show();
        }
    });
    $('.magnifier').on('click', function (e) {
        e.preventDefault();
        hidePopup();
        $('#page-overlay').show();

        tmpRel = $(this).attr('rel');
        if (tmpRel != '') {
            $('#chart-popup').show();
            for(i=1; i<=10; i++) {
                $('#zoom-'+i).hide();
            }
            $('#zoom-'+tmpRel).show();
        }
    });

    $('.btn-close').on('click', function (e) {
        e.preventDefault();
        hidePopup();
        $('#page-overlay').hide();
        $('#patient-popup-ISI').hide();
    });


    $('.enable-column').on('click', function (e) {
        if ($('#last-2').attr('class') == 'cell-off') {
            $('#last-1').css('background-color', '#a96d8a');
            for (i = 2; i <= 8; i++) {
                $('#last-' + i).addClass('cell-on');
                $('#last-' + i).addClass('cell-opacity');
                $('#last-' + i).animate({opacity: '1.0'}, "slow");
            }
        } else {
            $('#last-1').css('background-color', '#bab6b8');
            for (i = 2; i <= 8; i++) {
                $('#last-' + i).removeClass('cell-on');
                $('#last-' + i).removeClass('cell-opacity');
                $('#last-' + i).addClass('cell-off');
                $('#last-' + i).animate({opacity: '0'}, "slow");
            }
        }
    });

    /* subpages for dosing section */
    $('#subpage-close').on('click', function (e) {
        $(this).hide();
        for (i = 1; i <= 5; i++) {
            $('#page-' + i).hide();
        }

        $('#page-1').show();
        $('#ref').attr('rel', 'patient-popup');
    });

    $('.subpages a').on('click', function (e) {
        e.preventDefault();
        tmpidp = $(this).attr('rel');
        tmpid = $(this).attr('id');
        for (i = 1; i <= 2; i++) {
            $('#page-' + i).hide();
        }
        $('#btn-people').hide();
        $('#subpage-close').show();
        $('#' + tmpidp).show();

        switch (tmpid) {
            case 'pkp':
                $('#ref').attr('rel', 'patient-popup-1');
                break;

            case 'vas':
                $('#ref').attr('rel', 'patient-popup-2');
                break;
        }
    });

    /* DSM-5 */
    $('#form-questions .black').on('click', function (e) {
        e.preventDefault();
        tmp = $(this);
        tmpid = tmp.attr('id').split('-');
        $('#question-' + tmpid[0]).val(tmpid[1]);
        $(this).html('<span class="selected"></span>');
    });
    $('.black span').on('click', function (e) {
        $(this).remove('.selected');
    });

    $('.btn-submit').on('click', function (e) {
        e.preventDefault();

        formStatus = parseInt($('#form-status').val());
        switch (formStatus) {
            case 1:
                $('#form-status').val(2);
                $(this).addClass('btn-reset');
                $(this).html('Reset');
                setAnswers('dsm5Answers', 'green');
                break;

            case 2:
                $('#form-status').val(1);
                $(this).removeClass('btn-reset');
                $(this).html('Answer');
                resetAnswers('dsm5Answers', 'green');
                break;
        }
    });

    /* Tolerability */
    $('.navbar-tabs li a').on('click', function (e) {
        switch ($(this).attr('id')) {
            case 'tab-bpd-1':
                $('#bpd-navbar').addClass('hidden');
                $('#mdd-navbar').removeClass('hidden');
                for (i = 0; i <= 3; i++) {
                    $('#tmdd-' + i).removeClass('active');
                }
                $('#tmdd-1').addClass('active');
                $('#title-gray').html('SEROQUEL XR Tolerability in MDD');
                $('#title-bpd').addClass('hidden');
                $('#title-mdd').removeClass('hidden');
                Reveal.slide( 3, 0 );
                break;

            case 'tab-mdd-1':
                $('#mdd-navbar').addClass('hidden');
                $('#bpd-navbar').removeClass('hidden');
                for (i = 0; i <= 3; i++) {
                    $('#tbpd-' + i).removeClass('active');
                }
                $('#tbpd-1').addClass('active');
                $('#title-gray').html('SEROQUEL XR Tolerability');
                $('#title-mdd').addClass('hidden');
                $('#title-bpd').removeClass('hidden');
                Reveal.slide( 0, 0 );
                break;

            default:
                for (i = 1; i <= 3; i++) {
                    $('#tbpd-' + i).removeClass('active');
                }
                for (i = 1; i <= 3; i++) {
                    $('#tmdd-' + i).removeClass('active');
                }
                $(this).addClass('active');

                slideIndex = $(this).attr('rel');
                Reveal.slide( slideIndex, 0 );
                break;
        }
    });

    /* Important Safety Information */
    $('#tab-content-1').fadeTo(500, 1);
    $('#tab-1').addClass('tab-active');
    $('.button-list a').on('click', function (e) {
        e.preventDefault();
        for (i = 1; i <= 16; i++) {
            $('#popup-content-' + i).hide();
        }
        $('#popup-content-' + $(this).attr('rel')).show();
        $('#gray-popup').fadeTo(500, 1);
    });
    $('.close-x').on('click', function (e) {
        e.preventDefault();
        $('#' + $(this).attr('rel')).hide();
    });
    $('.warning-box a').on('click', function (e) {
        e.preventDefault();
        tmpid = $(this).attr('rel');
        $('#warning-popup-' + tmpid).fadeTo(500, 1);
    });
    $('.safety-tabs a').on('click', function (e) {
        e.preventDefault();
        tmpid = $(this).attr('rel');
        for (i = 1; i <= 3; i++) {
            $('#tab-' + i).removeClass('tab-active');
            $('#tab-content-' + i).hide();
        }
        $('#tab-content-' + tmpid).fadeTo(500, 1);
        $(this).addClass('tab-active');
    });

    /* Summary */
    $('#summary-indications').on('click', function(e) {
        e.preventDefault();
        setTimeout(function () { $("#sr-1").addClass('active-row'); }, 150);
        setTimeout(function () { $("#sr-2").addClass('active-row'); }, 300);
        setTimeout(function () { $("#sr-3").addClass('active-row'); }, 450);
        setTimeout(function () { $("#sr-4").addClass('active-row'); }, 600);
        setTimeout(function () { $("#sr-5").addClass('active-row'); }, 750);
        setTimeout(function () { $("#sr-6").addClass('active-row'); }, 900);
        setTimeout(function () { $("#last-3").addClass('active-row'); }, 1050);
    });
    $('.summary-efficacy p').on('click', function (e) {
        e.preventDefault();
        for (i = 1; i <= 2; i++) {
            $('#text-' + i).removeClass('p-active');
        }
        $(this).addClass('p-active');
    });
    $('.navbar-summary a').on('click', function (e) {
        e.preventDefault();
        tmpid = $(this).attr('rel');
        $('#content-summary').show();
        $('#summary-' + tmpid).fadeIn(500);
        $('#close-summary').show();
        $('#second-title').hide();
        $('#page-content').removeClass('fix-margin');
        $('#ref').attr('rel', 'patient-popup-1');
        switch (tmpid) {
            case 'efficacy':
                $('#main-title').html('SEROQUEL XR for MDD adjunctive therapy and for bipolar depression');
                setTimeout(function () {
                    $("#text-1").fadeIn(500);
                }, 500);
                setTimeout(function () {
                    $("#text-2").fadeIn(500);
                }, 1000);
                break;

            case 'indications':
                $('#page-content').addClass('fix-margin');
                $('#main-title').html('SEROQUEL XR offers versatility across a breadth of indications');
                $('#second-title').show();
                $('#ref').attr('rel', 'patient-popup-2');
                break;

            case 'access':
                $('#main-title').html('Access and Affordability');
                setTimeout(function () {
                    $("#image-access").fadeIn(500);
                }, 500);
                setTimeout(function () {
                    $("#text-1-access").fadeIn(1000);
                }, 1000);
                break;

            case 'safety':
                $('#main-title').html('Important Safety Information About SEROQUEL XR');
                break;
        }
    });
    $('#close-summary').on('click', function(e) {
        e.preventDefault();
        $('#main-title').html('SEROQUEL XR for MDD adjunctive therapy and for bipolar depression');
        $('#content-summary').hide();
        $('#summary-efficacy').hide();
        $('#summary-indications').hide();
        $('#summary-access').hide();
        $('#summary-safety').hide();
        $('#close-summary').hide();
        $('#second-title').hide();
        $('#page-content').removeClass('fix-margin');
        $('#ref').attr('rel', 'patient-popup-1');
    });

    //versatility
    $('.s-note2').on('click', function (e) {
        e.preventDefault();
        $('#versatility-page-1').hide();
        $('#versatility-page-2').show();
    });

    //Patient-type-Selection
    $('.profile-selection-more').on('click', function (e) {
        e.preventDefault();
        $('#page-overlay').show();

        tmpRel = $(this).attr('rel');
        if (tmpRel != '') {
            $('#' + tmpRel).show();
        } else {
            $('#patient-popup').show();
        }

    });

});


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
                var dq=1;
               
                switch(veevaVariables.Presentation.Id) {
                    case 'US-SXR-CNS-Access': 
                        dq = 4
                        break;
                    case 'US-SXR-CNS-Patient-Profile-Bipolar-I-and-II': 
                        dq = 1
                        break;
                    case 'US-SXR-CNS-DSM-5': 
                        dq = 2
                        break;
                    case 'US-SXR-CNS-Patient-Profile-MDD': 
                        dq = 1
                        break;
                    case 'US-SXR-CNS-Receptor-Affinity': 
                        dq = 3
                        break;
                    case 'US-SXR-CNS': 
                        dq = 1
                        break;
                    case 'US-SXR-CNS-Tolerability': 
                        dq = 1
                        break;

                }

                 $.get( "../shared/partials/dq"+dq+".html", function( data ) {
                    $('#discussionQuestion').html(data);
                    console.log( "Discussion Question " + dq + " Loaded" );
                        /* PollingQuestion */
                        $('#polling-question').on('click', function (e) {
                            $(this).fadeTo(500, 0, function () {
                                $(this).css('background-image', 'none');
                                $('.btn-transparent').css('pointer-events', 'none');
                                $(this).fadeTo(750, .2, function () {});
                            });
                        });
                        $('.polling-answer').on('click', function (e) {
                            e.preventDefault();
                            $(this).fadeTo(500, 1);
                            $(this).addClass('answer-selected ');
                            tmpid = $(this).attr('rel');
                            $("#answer-" + tmpid).val(1);

                            if (tmpid == 1) {
                                $(this).addClass('option-1');
                            } else {
                                $("#answer-b1").removeClass('option-1');
                            }

                            for (i = 1; i <= 4; i++) {
                                if (tmpid != i) {
                                    $("#answer-b" + i).fadeTo(500, .2);
                                    $("#answer-b" + i).removeClass('answer-selected');
                                    $("#answer-b" + i).addClass('answer-not-selected');
                                    $("#answer-" + i).val(0);
                                }
                            }
                            $('#answer-title').fadeTo(1000, 1);
                        });
                    });

                $('.btn-people').click(function(){
                   $('#discussionQuestion').show();
                    $('.polling #close').click(function(){
                    $('#discussionQuestion').hide();
                });
                });

         });
