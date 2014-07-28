jQuery(document).ready(function($) {
    // Share on social networks
    $(".btn-facebook, .btn-twitter").prettySocial();
    
    // Copy to clipboard
    new ZeroClipboard($('.zeroclipboard'), {
        moviePath : 'js/jquery.zeroclipboard.swf'
    });

    $('.zeroclipboard').click(function() {
        // Current element
        var $this = $(this);

        // Remove selected class from others
        $('.zeroclipboard').removeClass('zeroclipboard-selected');

        // Add class to current element
        $this.addClass('zeroclipboard-selected');
    });

    // Vote response
    $('[data-trigger="response"] > a').click(function(e) {
        var $this = $(this);
        var $type = $this.data('type');

        // Prevent default
        e.preventDefault();
        
        // Check if item is not selected
        if (!$this.hasClass('response-selected')) {
            // Article parameters
            var $article = $this.parents('.meme');
            var $slug    = $article.data('slug');

            // Ajax request
            $.ajax({
                data: { slug: $slug, type: $type },
                type: 'POST',
                url:  '/vote'
            })
            .done(function(data) { 
                // Check if action was successful
                if (data.result === true) {
                    // Parent parameters
                    var $parent = $this.parent();

                    // Change points
                    $article.find('.meme-points > span').html(data.points);

                    // Remove class from others
                    $parent.find('a').removeClass('response-selected');

                    // Add class
                    $this.addClass('response-selected');
                }
            });
        }
        
        // Stop propagation
        return false;
    });

    // Animated GIF
    $('.meme-img.animated').on('click', function(e) {
        var $this      = $(this);
        var $reference = $this.find('.animated-reference');
        var $thumbnail = $this.find('.animated-thumbnail');

        // Prevent default
        e.preventDefault();

        // Check if image is loading
        if ($this.hasClass('loading')) {
            // Stop propagation
            return false;
        }

        // Check if image is loaded
        if (!$reference.find('img').size()) {
            // Add class
            $this.addClass('loading');

            // Set size
            $this.css('height', $thumbnail.find('img').height());
            $this.css('width', $thumbnail.find('img').width());

            // Append preloader
            $this.append("<div class=\"preload\"></div>");

            // Clone image
            var $clone = $thumbnail.find('img').clone();

            // Set source
            $clone
                .attr('src', $reference.data('image'))
                .load(function() {
                    // Remove preloader
                    $this.find('.preload').remove();

                    // Append element
                    $reference.append($clone);

                    // Toggle class
                    $reference.removeClass('hide').addClass('presenting');
                    $thumbnail.removeClass('presenting').addClass('hide');

                    // Remove class
                    $this.removeClass('loading');
                })
            ;
        }

        // Toggle class
        $reference.toggleClass('hide').toggleClass('presenting');
        $thumbnail.toggleClass('presenting').toggleClass('hide');

        // Stop propagation
        return false;
    });
    
    // Meme generator preview
    var $img   = $('#preview');
    var $src   = $img.attr('src');
    var $token = $('[name=token]');
    
    $('[name=top], [name=bottom]').on('focusout', function() {
        $.ajax({
            url: '/preview',
            type: 'POST',
            data: {
                top:     $('[name=top]').val(),
                bottom:  $('[name=bottom]').val(),
                source:  $src,
                token:   $token.val()
            },
            success: function(response) {
                $('#preview').attr('src', response.name + '?' + new Date().getTime());
            }
        });
    });
});