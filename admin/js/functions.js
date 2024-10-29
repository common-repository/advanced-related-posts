// (function($){

    // ===============================================================
    // ========================= Prefixes ============================
    // ===============================================================

    var $ays_prefix   = 'ays_';
    var $name_prefix  = 'ays_arp_';
    var $id_prefix    = '#ays-arp-';
    var $class_prefix = '.ays-arp-';

    // ===============================================================
    // ========================= Prefixes ============================
    // ===============================================================
    
    String.prototype.hexToRgbA = function(a) {
        
        if (typeof a === 'undefined'){
            a = 1;
        }
        var ays_rgb;
        var result1 = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})jQuery/i.exec(this);
        var result2 = /^#?([a-f\d]{1})([a-f\d]{1})([a-f\d]{1})jQuery/i.exec(this);
        if(result1){
            ays_rgb = {
                r: parseInt(result1[1], 16),
                g: parseInt(result1[2], 16),
                b: parseInt(result1[3], 16)
            };
            return 'rgba('+ays_rgb.r+','+ays_rgb.g+','+ays_rgb.b+','+a+')';
        }else if(result2){
            ays_rgb = {
                r: parseInt(result2[1]+''+result2[1], 16),
                g: parseInt(result2[2]+''+result2[2], 16),
                b: parseInt(result2[3]+''+result2[3], 16)
            };
            return 'rgba('+ays_rgb.r+','+ays_rgb.g+','+ays_rgb.b+','+a+')';
        }else{
            return null;
        }
    }
    
    jQuery.fn.aysModal = function(action){
        var jQuerythis = jQuery(this);
        switch(action){
            case 'hide':
                jQuery(this).find('.ays-modal-content').css('animation-name', 'zoomOut');
                setTimeout(function(){
                    jQuery(document.body).removeClass('modal-open');
                    jQuery(document).find('.ays-modal-backdrop').remove();
                    jQuerythis.hide();
                }, 250);
            break;
            case 'show': 
            default:
                jQuerythis.show();
                jQuery(this).find('.ays-modal-content').css('animation-name', 'zoomIn');
                jQuery(document).find('.modal-backdrop').remove();
                jQuery(document.body).append('<div class="ays-modal-backdrop"></div>');
                jQuery(document.body).addClass('modal-open');
            break;
        }
    }

    function checkTrue(flag) {
        return flag === true;
    }
    
    function searchForPage(params, data) {
        // If there are no search terms, return all of the data
        if (jQuery.trim(params.term) === '') {
          return data;
        }

        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
          return null;
        }
        var searchText = data.text.toLowerCase();
        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (searchText.indexOf(params.term) > -1) {
          var modifiedData = jQuery.extend({}, data, true);
          modifiedData.text += ' (matched)';

          // You can return modified objects from here
          // This includes matching the `children` how you want in nested data sets
          return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
    }

    function selectElementContents(el) {
        if (window.getSelection && document.createRange) {
            var sel = window.getSelection();
            var range = document.createRange();
            range.selectNodeContents(el);
            sel.removeAllRanges();
            sel.addRange(range);
        } else if (document.selection && document.body.createTextRange) {
            var textRange = document.body.createTextRange();
            textRange.moveToElementText(el);
            textRange.select();
        }
    }

    function aysGenCharArray(charA, charZ) {
        var a = [], i = charA.charCodeAt(0), j = charZ.charCodeAt(0);
        for (; i <= j; ++i) {
            a.push(String.fromCharCode(i));
        }
        return a;
    }

    function aysGetJsonFromUrl( url ) {
        if (!url) url = location.href;
        var question = url.indexOf("?");
        var hash = url.indexOf("#");
        if (hash == -1 && question == -1) return {};
        if (hash == -1) hash = url.length;
        var query = question == -1 || hash == question + 1 ? url.substring(hash) :
            url.substring(question + 1, hash);
        var result = {};
        var queryArray = query.split("&");
        for(var i=0; i < queryArray.length; i++){
            var part = queryArray[i];
            if (!part) return;
            part = part.split("+").join(" "); // replace every + with space, regexp-free version
            var eq = part.indexOf("=");
            var key = eq > -1 ? part.substr(0, eq) : part;
            var val = eq > -1 ? decodeURIComponent(part.substr(eq + 1)) : "";
            var from = key.indexOf("[");
            if (from == -1) result[decodeURIComponent(key)] = val;
            else {
                var to = key.indexOf("]", from);
                var index = decodeURIComponent(key.substring(from + 1, to));
                key = decodeURIComponent(key.substring(0, from));
                if (!result[key]) result[key] = [];
                if (!index) result[key].push(val);
                else result[key][index] = val;
            }
        }
        return result;
    }

    function nl2br (str, is_xhtml) {
        if (typeof str === 'undefined' || str === null) {
            return '';
        }
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }
    
    /**
     * @return {string}
     */
    function aysEscapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>\"']/g, function(m) { return map[m]; });
    }

    function changeCurrentUrl(key){
        var linkModified = location.href.split('?')[1].split('&');
        for(var i = 0; i < linkModified.length; i++){
            if(linkModified[i].split("=")[0] == key){
                linkModified.splice(i, 1);
            }
        }
        linkModified = linkModified.join('&');
        window.history.replaceState({}, document.title, '?'+linkModified);
    }

    function openMediaUploaderBg(e, element) {
        e.preventDefault();
        var aysUploader = wp.media({
            title: AdvencedRelatedPostsAdmin.upload,
            button: {
                text: AdvencedRelatedPostsAdmin.upload,
            },
            library: {
                type: 'image'
            },
            multiple: false
        }).on('select', function () {
            var _this = element;
            var parent = _this.parents('.ays_toggle_parent');

            var attachment = aysUploader.state().get('selection').first().toJSON();

            parent.find( $class_prefix + 'bg-image-container').parent().fadeIn();
            parent.find('img'+ $class_prefix +'default_thumbnail_img').attr('src', attachment.url);
            parent.find('input'+ $class_prefix +'default_image').val( attachment.url );

        }).open();
        return false;
    }
//})(jQuery);
