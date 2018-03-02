(function($) {
    $.fn.createSimpleImgGallery = function() {
        var lElements_jqe = $(this).find('a');
        var lElementsCount_int = lElements_jqe.length;
        for (var i = 0; i < lElementsCount_int; i++) {
            var lElement_jqe = $(lElements_jqe[i]);
            lElement_jqe.attr('data-id', i);
            lElement_jqe.find('img').css({
                float: "none",
                width: "100%",
                height: "100%",
                margin: "0"
            });
        }

        var lOverlay_jqe = $('<div id="codengineering_overlay"></div>'),
                lWrapper_jqe = $('<div class="wrapper"></div>'),
                lImgInnerWrapper_jqp = $('<div class="img_inner_wrapper" data-rotation="0"></div>'),
                lImgWrapper_jqp = $('<div class="img_wrapper"></div>'),
                lNavBtnLeft_jqe = $('<div class="nav-btn nav-btn-left pointer"><span class="fa fa-caret-left"></span></div>'),
                lNavBtnRight_jqe = $('<div class="nav-btn nav-btn-right pointer"><span class="fa fa-caret-right"></span></div>'),
                lSettingsWrapper_jqe = $('<div class="settings_wrapper"></div>'),
                lSettings_jqe = $('<div class="settings"></div>'),
                lRotateLeft_jqe = $('<a><i class="fa fa-rotate-left pointer"></i></a>'),
                lRotateRight_jqe = $('<a><i class="fa fa-rotate-right pointer"></i></a>'),
                lLoadingWrapper_jqe = $('<div class="loading_wrapper"></div>'),
                lLoadingText_jqe = $('<div class="loading_text"><i class="fa fa-refresh fa-spin fa-3x fa-fw margin-bottom"></i></div>'),
                lImage_jqe = $("<img>"),
                lCaption_jqe = $("<p>Curabitur ac sapien quis ligula tempor cursus eu eu risus.</p>");

        lOverlay_jqe.append(lWrapper_jqe);
        lImgInnerWrapper_jqp.append(lImage_jqe);
        lImgWrapper_jqp.append(lImgInnerWrapper_jqp);
        lSettingsWrapper_jqe.append(lSettings_jqe);
        lSettings_jqe.append('&nbsp;').append(lRotateLeft_jqe).append('&nbsp;').append(lRotateRight_jqe).append('&nbsp;');
        lLoadingWrapper_jqe.append(lLoadingText_jqe);
        lWrapper_jqe.append(lImgWrapper_jqp)
                .append(lSettingsWrapper_jqe)
                .append(lNavBtnLeft_jqe)
                .append(lNavBtnRight_jqe)
                .append(lLoadingWrapper_jqe)
                .append(lCaption_jqe);

        $("body").append(lOverlay_jqe);

        var lPrev_e = null,
                lNext_e = null;

        var redrawImage = function() {
            var lWrapperHeight = lWrapper_jqe.height();
            var lWrapperWidth = lWrapper_jqe.width();
            var lImageCurrentRotation_int = parseInt(lImgInnerWrapper_jqp.attr('data-rotation'));
            if ((lImageCurrentRotation_int % 180) !== 0) {
                lWrapperHeight = lWrapper_jqe.width();
                lWrapperWidth = lWrapper_jqe.height();
            }

            lImage_jqe.width('auto');
            lImage_jqe.height(lWrapperHeight);
            if (lImage_jqe.width() > lWrapperWidth) {
                lImage_jqe.width(lWrapperWidth);
                lImage_jqe.height('auto');
            }
            var lImageHeight = lImage_jqe.height();
            var lImageWidth = lImage_jqe.width();
            lImgInnerWrapper_jqp.css('margin-top', (-lImageHeight / 2) + 'px');
            lImgInnerWrapper_jqp.css('margin-left', (-lImageWidth / 2) + 'px');

            lNavBtnLeft_jqe.css('line-height', lNavBtnLeft_jqe.height() + 'px');
            lNavBtnRight_jqe.css('line-height', lNavBtnRight_jqe.height() + 'px');

            lLoadingWrapper_jqe.css('line-height', lWrapper_jqe.height() + 'px');
        };
        var showImage = function(aId) {
            aId = parseInt(aId);
            var lIsLast_bl = aId === (lElementsCount_int - 1);
            var lIsFirst_bl = aId === 0;
            var lCurrentImageLink_jqe = $(lElements_jqe[aId]);
            lImage_jqe.attr("src", lCurrentImageLink_jqe.attr("href"));
            var captionText = lCurrentImageLink_jqe.children("img").attr("alt");
            lCaption_jqe.text(captionText);
            lLoadingText_jqe.animate({opacity: 1}, 100);

            lIsFirst_bl && lNavBtnLeft_jqe.hide();
            if (!lIsFirst_bl) {
                lPrev_e = lElements_jqe[aId - 1];
                lNavBtnLeft_jqe.show();
            }
            lIsLast_bl && lNavBtnRight_jqe.hide();
            if (!lIsLast_bl) {
                lNext_e = lElements_jqe[1 + aId];
                lNavBtnRight_jqe.show();
            }

            lOverlay_jqe.show();
            lWrapper_jqe.animate({opacity: 1}, 300);
        };
        var rotateImage = function(aDeg) {
            aDeg = parseInt(aDeg);
            var lImageCurrentRotation_int = parseInt(lImgInnerWrapper_jqp.attr('data-rotation'));
            var lImageNewRotation_int = lImageCurrentRotation_int + aDeg;
            setImageRotation(lImageNewRotation_int);
            redrawImage();
        };
        var setImageRotation = function(aDeg) {
            lImgInnerWrapper_jqp.attr('data-rotation', aDeg);
            lImgInnerWrapper_jqp.css({'-webkit-transform': 'rotate(' + aDeg + 'deg)',
                '-moz-transform': 'rotate(' + aDeg + 'deg)',
                '-ms-transform': 'rotate(' + aDeg + 'deg)',
                'transform': 'rotate(' + aDeg + 'deg)'});
        };

        lOverlay_jqe.click(function() {
            lOverlay_jqe.hide();
            lWrapper_jqe.css('opacity', 0);
        });

        lNavBtnLeft_jqe.click(function(e) {
            e.stopPropagation();
            showImage($(lPrev_e).attr('data-id'));
        });
        lNavBtnRight_jqe.click(function(e) {
            e.stopPropagation();
            showImage($(lNext_e).attr('data-id'));
        });
        lElements_jqe.click(function(e) {
            e.preventDefault();
            showImage($(this).attr('data-id'));
        });
        lRotateLeft_jqe.click(function(e) {
            e.stopPropagation();
            rotateImage(-90);
        });
        lRotateRight_jqe.click(function(e) {
            e.stopPropagation();
            rotateImage(90);
        });
        lImage_jqe.on('load', function() {
            lLoadingText_jqe.animate({opacity: 0}, 100);
            setImageRotation(0);
            redrawImage();
        });

        $(window).on("resize", redrawImage);
    };
})(jQuery);