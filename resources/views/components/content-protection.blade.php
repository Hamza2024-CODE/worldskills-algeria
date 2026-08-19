<style>
/* 🛡️ Platform Media & Content Protection System (Anti-Copy & Anti-Download) */
img, video, canvas, picture, [data-protected-media] {
    -webkit-user-drag: none !important;
    -khtml-user-drag: none !important;
    -moz-user-drag: none !important;
    -o-user-drag: none !important;
    user-drag: none !important;
    -webkit-touch-callout: none !important;
    -webkit-user-select: none !important;
    -khtml-user-select: none !important;
    -moz-user-select: none !important;
    -ms-user-select: none !important;
    user-select: none !important;
}

/* Disable context menu highlight on touch devices */
body {
    -webkit-touch-callout: none;
}
</style>

<script>
(function() {
    'use strict';

    // 1. Prevent Right-Click Context Menu on Images, Videos, Canvas & Pictures
    document.addEventListener('contextmenu', function(e) {
        const target = e.target;
        if (
            target.tagName === 'IMG' || 
            target.tagName === 'VIDEO' || 
            target.tagName === 'CANVAS' || 
            target.tagName === 'PICTURE' || 
            target.tagName === 'SOURCE' ||
            target.closest('img, video, canvas, picture, [data-protected-media]')
        ) {
            e.preventDefault();
            return false;
        }
    }, true);

    // 2. Prevent Drag & Drop of Media Assets to Desktop or Other Windows
    document.addEventListener('dragstart', function(e) {
        const target = e.target;
        if (
            target.tagName === 'IMG' || 
            target.tagName === 'VIDEO' || 
            target.tagName === 'CANVAS' || 
            target.tagName === 'PICTURE' ||
            target.closest('img, video, canvas, picture')
        ) {
            e.preventDefault();
            return false;
        }
    }, true);

    // 3. Enforce Anti-Download Attributes & Lock Context Menu on Video Elements
    function lockVideoElements() {
        const videos = document.querySelectorAll('video');
        videos.forEach(function(video) {
            if (!video.hasAttribute('data-protected')) {
                video.setAttribute('controlsList', 'nodownload noremoteplayback noplaybackrate');
                video.setAttribute('disablePictureInPicture', 'true');
                video.setAttribute('oncontextmenu', 'return false;');
                video.setAttribute('ondragstart', 'return false;');
                video.setAttribute('data-protected', 'true');
            }
        });
    }

    // Run on page load & observe dynamic Livewire DOM updates
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', lockVideoElements);
    } else {
        lockVideoElements();
    }

    const observer = new MutationObserver(function() {
        lockVideoElements();
    });

    if (document.body) {
        observer.observe(document.body, { childList: true, subtree: true });
    } else {
        document.addEventListener('DOMContentLoaded', function() {
            observer.observe(document.body, { childList: true, subtree: true });
        });
    }

    // 4. Block Keyboard Shortcuts (Ctrl+S / Cmd+S for Save, Ctrl+U for View Source)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && (e.key === 's' || e.key === 'S')) {
            e.preventDefault();
            return false;
        }
        if ((e.ctrlKey || e.metaKey) && (e.key === 'u' || e.key === 'U')) {
            e.preventDefault();
            return false;
        }
    }, true);

})();
</script>
