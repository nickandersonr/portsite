var mddURL = ['mdd 1', 'mdd 2', 'mdd 3', 'mdd 4', 'mdd 5', 'mdd 6', 'mdd 7', 'mdd 8', 'mdd 9'];
var bpdURL = ['bpd 1', 'bpd 2', 'bpd 3', 'bpd 4', 'bpd 5', 'bpd 6', 'bpd 7', 'bpd 8', 'bpd 9'];
var refDosing2 = [];
var refPk = [];

function hidePopup() {
    $('#patient-popup').hide();
    for (i = 1; i <= 10; i++) {
        $('#patient-popup-' + i).hide();
    }
}

function setURLs() {
    if ($('#sidebar').attr('class') == 'btn-switch') {
        for (i = 0; i <= 8; i++) {
            $('#so-' + i).attr('href', bpdURL[ i ]);
        }
    } else {
        for (i = 0; i <= 8; i++) {
            $('#so-' + i).attr('href', mddURL[ i ]);
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
    $('.s-logo').on('click', function (e) {
        e.preventDefault();
        $('#s-navbar').show();
    });

    $('.btn-switch').on('click', function (e) {
        e.preventDefault();
        setURLs();
        if ($(this).attr('class') == 'btn-switch') {
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
        }

    });

    $('#patient-list a').on('click', function (e) {
        $('#patient-list').fadeOut('slow');
    });

    $('.btn-open').on('click', function (e) {
        e.preventDefault();
        $('#page-overlay').show();

        tmpRel = $(this).attr('rel');
        if (tmpRel != '') {
            $('#' + tmpRel).show();
        } else {
            $('#patient-popup').show();
        }

    });
    $('.btn-close').on('click', function (e) {
        e.preventDefault();
        hidePopup();
        $('#page-overlay').hide();
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
        for (i = 1; i <= 2; i++) {
            $('#' + tmpid[0] + '-' + i).html('');
        }
        $(this).html('<span class="selected"></span>');
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
    /* PollingQuestion */
    $('#polling-question').on('click', function (e) {
        $(this).fadeTo(1000, 0, function () {
            $(this).css('display', 'none');
        });
    });
    $('.polling-answer').on('click', function(e) {
        e.preventDefault();
        $(this).fadeTo(500, 1);
        $(this).addClass('answer-selected ');
        tmpid = $(this).attr('rel');
        $("#answer-"+tmpid).val(1);
        
        if(tmpid == 1) {
            $(this).addClass('option-1');
        } else {
            $("#answer-b1").removeClass('option-1');
        }
        
        for(i=1; i<=4; i++) {
            if( tmpid != i ) {
                $("#answer-b" + i).fadeTo(500, .5);
                $("#answer-b" + i).removeClass('answer-selected');
                $("#answer-b" + i).addClass('answer-not-selected');
                $("#answer-" + i).val(0);
            }
        }
        $('#answer-title').fadeTo(1000, 1);
    });
    /* Tolerability */
    $('.navbar-tabs li a').on('click', function(e) {
        switch($(this).attr('id')) {
            case 'tab-bpd-1':
                $('#bpd-navbar').addClass('hidden');
                $('#mdd-navbar').removeClass('hidden');
                for(i=1; i<=3; i++){ $('#tmdd-'+i).removeClass('active'); }
                $('#tmdd-1').addClass('active');
                $('#title-gray').html('SEROQUEL XR Tolerability in MDD');
                $('#title-bpd').addClass('hidden');
                $('#title-mdd').removeClass('hidden');
                $('#ref').attr('rel', 'patient-popup-1');
                break;
                
            case 'tab-mdd-1':
                $('#mdd-navbar').addClass('hidden');
                $('#bpd-navbar').removeClass('hidden');
                for(i=1; i<=3; i++){ $('#tbpd-'+i).removeClass('active'); }
                $('#tbpd-1').addClass('active');
                $('#title-gray').html('SEROQUEL XR Tolerability');
                $('#title-mdd').addClass('hidden');
                $('#title-bpd').removeClass('hidden');
                $('#ref').attr('rel', 'patient-popup');
                break;
                
            default:
                for(i=1; i<=3; i++){ $('#tbpd-'+i).removeClass('active'); }
                for(i=1; i<=3; i++){ $('#tmdd-'+i).removeClass('active'); }
                $(this).addClass('active');
                break;
        }
    });
    
    /* Important Safety Information */
    $('#tab-content-1').fadeTo(1000, 1);
    $('#tab-1').addClass('tab-active');
    $('.button-list a').on('click', function(e) {
        e.preventDefault();
        for(i=1; i<=16; i++) {
            $('#popup-content-' + i).hide();
        }
        $('#popup-content-' + $(this).attr('rel') ).show();
        $('#gray-popup').fadeTo(1000, 1);
    });
    $('.close-x').on('click', function(e) {
        e.preventDefault();
        $('#' + $(this).attr('rel') ).hide();
    });
    
    $('.warning-box a').on('click', function(e) {
        e.preventDefault();
        tmpid = $(this).attr('rel');
        $('#warning-popup-'+tmpid).fadeTo(1000, 1);
    });
    
    $('.safety-tabs a').on('click', function(e) {
        e.preventDefault();
        tmpid = $(this).attr('rel');
        for(i=1; i<=3; i++) {
            $('#tab-' + i).removeClass('tab-active');
            $('#tab-content-'+i).hide();
        }
        $('#tab-content-'+tmpid).fadeTo(1000, 1);
        $(this).addClass('tab-active');
    });
});
