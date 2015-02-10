jQuery(document).ready(function($) {

    // Set canvas size
    var canvas = $('#memecanvas').get(0);
    var ctx = canvas.getContext('2d');
   
    // Canvas parent
    var container = $(canvas).parent();
    
    //  Grab the image
    var img = $('#preview').get(0);

    // Run function when browser resizes
    $(window).resize(redrawCanvas());

    function redrawCanvas() {
        
        canvas.width = $(container).width();
        canvas.height = $(container).height();
        
        // Redraw image
        var x = canvas.width/2 - img.width/2;
        var y = canvas.height/2 - img.height/2;
        
        ctx.drawImage(img, x, y);
        
    }

    //Initial call 
    redrawCanvas();
    
    // Max line width
    var maxWidth = canvas.width - 40;
    
    // Line height
    var lineHeight = 36;
            
    // Watch for text changes
    $('[name=top]').on("change keyup paste click", function(){
        clearAndWrite();
    })
    
    $('[name=bottom]').on("change keyup paste click", function(){
        clearAndWrite();
    })
               
    // Clear one half of the canvas
    function clearAndWrite() {

        // Clear lines
        ctx.beginPath();

        // Use the identity matrix while clearing the canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Redraw image
        redrawCanvas();
        
        var topText = $('[name=top]').val().toUpperCase();
        
        // Top text
        addText(
                topText,
                canvas.width / 2,
                50, 
                maxWidth,
                lineHeight
        );       
       
        var bottomText = $('[name=bottom]').val().toUpperCase();
       
        // Calculate Y coord.
        var startY = canvas.height - countLines(bottomText) * (lineHeight - 5);

         // Bottom text
         addText(
                 bottomText,
                 canvas.width / 2,
                 startY,
                 maxWidth,
                 lineHeight
         );
    }
    
    // Adds the text in canvas, oon multiple lines
    function addText(text, x, y, maxWidth, lineHeight) {
        
        // Set font
        ctx.font = '26pt Impact';
        ctx.textAlign = 'center';

        // Add stroke
        ctx.strokeStyle = 'black';
        ctx.lineWidth = 5;

        // Font color
        ctx.fillStyle = 'white';
                
        var words = text.split(' ');
        var addtxt = '';
                
        // Multiple rows
        for (var n = 0; n < words.length; n++) {
            
            var txtLine = addtxt + words[n] + ' ';
            
            var metrics = ctx.measureText(txtLine);
            var txtWidth = metrics.width;
            
            // Go to new line
            if (txtWidth > maxWidth && n > 0) {
                ctx.strokeText(addtxt, x, y);
                ctx.fillText(addtxt, x, y);
                
                addtxt = words[n] + ' ';
                y += lineHeight;
            }
            else {
                addtxt = txtLine;
            }
            
        }
        
        // Add text
        ctx.strokeText(addtxt, x, y);
        ctx.fillText(addtxt, x, y);   
    }
    
    // Count number of lines needed for given text
    function countLines(text) {
        
        var words = text.split(' ');
        var addtxt = '';
        
        // Find number of lines needed
        var lines = 1;
        for (var n = 0; n < words.length; n++) {
            
            var txtLine = addtxt + words[n] + ' ';
            var metrics = ctx.measureText(txtLine);
            
            // Go to new line
            if (metrics.width > maxWidth && n > 0) {
                addtxt = words[n] + ' ';
                lines++;
            }
            else {
                addtxt = txtLine;
            }
            
        }
        
        return lines;        
    }

    // Save canvas 
    var dataURL = canvas.toDataURL();
    var $token = $('[name=token]');
    
  //  alert(dataURL);
    
    $('[name=publish]').on('click', function() {
        $.ajax({
            url:      '/save',
            type:     'POST',
            dataType: 'json',
            data: {
                token:   $token.val(),
                imgBase64: dataURL
            },
            success: function(response) {
                console.log("Success "  + response);
            },
            error: function(err) {
                console.log("Error " + err);
            }
        });
    });

});
