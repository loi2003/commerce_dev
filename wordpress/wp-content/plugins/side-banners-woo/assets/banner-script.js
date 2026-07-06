/**
 * Side Banners for WooCommerce - Script
 */

jQuery(document).ready(function($) {
    
    // ======= ĐÓNG BANNER =======
    $('.sbw-close-btn').on('click', function(e) {
        e.preventDefault();
        var banner = $(this).closest('.sbw-banner');
        var bannerId = banner.attr('id');
        
        banner.addClass('hidden');
        
        var expiryDate = new Date();
        expiryDate.setTime(expiryDate.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = bannerId + '_closed=true; expires=' + expiryDate.toUTCString() + '; path=/';
        
        updatePadding();
    });
    
    // ======= KIỂM TRA COOKIE =======
    function getCookie(name) {
        var value = '; ' + document.cookie;
        var parts = value.split('; ' + name + '=');
        if (parts.length === 2) {
            return parts.pop().split(';').shift();
        }
        return null;
    }
    
    $('.sbw-banner').each(function() {
        var bannerId = $(this).attr('id');
        if (getCookie(bannerId + '_closed') === 'true') {
            $(this).addClass('hidden');
        }
    });
    
    // ======= CẬP NHẬT PADDING =======
    function updatePadding() {
        var leftBanner = $('#sbw-left-banner:not(.hidden)');
        var rightBanner = $('#sbw-right-banner:not(.hidden)');
        var paddingValue = 20;
        var windowWidth = window.innerWidth;
        
        if (leftBanner.length > 0 && rightBanner.length > 0) {
            if (windowWidth > 1600) paddingValue = 400;
            else if (windowWidth > 1366) paddingValue = 360;
            else if (windowWidth > 1024) paddingValue = 310;
            else if (windowWidth > 768) paddingValue = 240;
            else paddingValue = 20;
        } else if (leftBanner.length > 0 || rightBanner.length > 0) {
            if (windowWidth > 1600) paddingValue = 250;
            else if (windowWidth > 1366) paddingValue = 220;
            else if (windowWidth > 1024) paddingValue = 190;
            else if (windowWidth > 768) paddingValue = 150;
            else paddingValue = 20;
        }
        
        $('.site-content').css({
            'padding-left': paddingValue + 'px',
            'padding-right': paddingValue + 'px'
        });
    }
    
    updatePadding();
    
    // ======= XỬ LÝ SCROLL =======
    function handleScroll() {
        var scrollTop = $(window).scrollTop();
        var windowHeight = $(window).height();
        var documentHeight = $(document).height();
        
        var distanceToFooter = documentHeight - (scrollTop + windowHeight);
        var shouldHide = distanceToFooter < 250;
        
        $('.sbw-banner:not(.hidden)').each(function() {
            if (shouldHide) {
                $(this).addClass('scroll-hide');
            } else {
                $(this).removeClass('scroll-hide');
                
                var bannerInner = $(this).find('.sbw-banner-inner');
                if (scrollTop > 400) {
                    bannerInner.css('transform', 'scale(0.92)');
                } else if (scrollTop > 150) {
                    bannerInner.css('transform', 'scale(0.96)');
                } else {
                    bannerInner.css('transform', 'scale(1)');
                }
            }
        });
    }
    
    $(window).on('scroll', function() {
        handleScroll();
    });
    
    $(window).on('resize', function() {
        updatePadding();
        handleScroll();
    });
    
    // ======= KEYBOARD ACCESSIBILITY =======
    $('.sbw-close-btn').on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            $(this).click();
        }
    });
    
    // ======= CẬP NHẬT KHI AJAX =======
    $(document).on('wc_fragments_refreshed', function() {
        $('.sbw-banner').each(function() {
            var bannerId = $(this).attr('id');
            if (getCookie(bannerId + '_closed') === 'true') {
                $(this).addClass('hidden');
            }
        });
        updatePadding();
        handleScroll();
    });
    
    console.log('Side Banners for WooCommerce v1.0.7 loaded successfully!');
});