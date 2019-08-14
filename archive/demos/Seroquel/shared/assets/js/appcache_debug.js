// Check if a new cache is available on page load.
window.addEventListener('load', function(e) {
    window.applicationCache.addEventListener('updateready', function(e) {
        //console.log(e);
        if (window.applicationCache.status == window.applicationCache.UPDATEREADY) {
            // Browser downloaded a new app cache.
            if (confirm('A new version of this site is available. Load it?')) {
                window.location.reload();
            }
        } else {
            // Manifest didn't changed. Nothing new to server.
        }
    }, false);

    window.applicationCache.addEventListener('cached', function(e) {
        console.log('cached' + ' ' + statusToString(window.applicationCache.status));
    }, false);

    window.applicationCache.addEventListener('checking', function(e) {
        console.log('checking' + ' ' + statusToString(window.applicationCache.status));
    }, false);

    window.applicationCache.addEventListener('downloading', function(e) {
        alert('cache updated');
        console.log('downloading' + ' ' + statusToString(window.applicationCache.status));
    }, false);

    window.applicationCache.addEventListener('error', function(e) {
        console.log('error' + ' ' + statusToString(window.applicationCache.status));
    }, false);

    window.applicationCache.addEventListener('noupdate', function(e) {
        alert('cache valid');
        console.log('noupdate' + ' ' + statusToString(window.applicationCache.status));
    }, false);

    window.applicationCache.addEventListener('obsolete', function(e) {
        console.log('obsolete' + ' ' + statusToString(window.applicationCache.status));
    }, false);

    window.applicationCache.addEventListener('progress', function(e) {
        //console.log('progress' + ' ' + statusToString(window.applicationCache.status));
    }, false);

    window.applicationCache.addEventListener('updateready', function(e) {
        console.log('updateready' + ' ' + statusToString(window.applicationCache.status));
    }, false);


}, false);

function statusToString(status) {

    switch (status) {
        case window.applicationCache.UNCACHED: // UNCACHED == 0
            return 'UNCACHED';
            break;
        case window.applicationCache.IDLE: // IDLE == 1
            return 'IDLE';
            break;
        case window.applicationCache.CHECKING: // CHECKING == 2
            return 'CHECKING';
            break;
        case window.applicationCache.DOWNLOADING: // DOWNLOADING == 3
            return 'DOWNLOADING';
            break;
        case window.applicationCache.UPDATEREADY: // UPDATEREADY == 4
            return 'UPDATEREADY';
            break;
        case window.applicationCache.OBSOLETE: // OBSOLETE == 5
            return 'OBSOLETE';
            break;
        default:
            return 'UKNOWN CACHE STATUS';
            break;
    };

}