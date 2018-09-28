<!DOCTYPE html>
<html class="no-js">

<?php include("funciones.php"); ?>
<?php echo Cabecera('Reporte Facturacion Diaria'); ?>
<?php
    $TituloPantalla = 'Reporte Facturacion Diaria';    
?>
<body>
            <div class="panel panel-default">

<form>
    <fieldset>
        <label for="theText">Enter some text</label>
        <input id="theText" type="text" />
    </fieldset>
</form>
<div><b>Output Text</b>: <span id="theOutputText"></span>
</div>
<div><b>keydown</b> event.which: <span id="theOutputKeyDown"></span>
</div>
<div><b>keyup</b> event.which: <span id="theOutputKeyUp"></span>
</div>
<div><b>keypress</b> event.which: <span id="theOutputKeyPress"></span>
</div>
<div><b>focus</b>  <span id="theOutputFocusOut"></span>
</div>
<div>
    <p>Keydown: triggers on when you press a key and it returns the scan-code from the keyboard. (<em>A</em> and <em>a</em> both return 65)</p>
    <p>Keypress: triggers after keydown, and it returns the charcode.
        <br />(<em>A</em> returns 65 and <em>a</em> returns 97)
        <br />But this only works reliably for character codes (not Esc, Home, End, Arrows etc. and the results are browser dependent).
        <p>Article: <a href="https://www.quirksmode.org/js/keys.html">Detecting Keys - [quirksmode]</a> 
</div>
                </div>
</body>
</html>

<?php echo Script(); ?>
<script>
    $(function () {
/*        var theText = $("#theText");
        var theOutputText = $("#theOutputText");
        var theOutputKeyPress = $("#theOutputKeyPress");
        var theOutputKeyDown = $("#theOutputKeyDown");
        var theOutputKeyUp = $("#theOutputKeyUp");
        var theOutputFocusOut = $("#theOutputFocusOut");

        theText.keydown(function (event) {
            keyReport(event, theOutputKeyDown);
        });

        theText.keypress(function (event) {
            keyReport(event, theOutputKeyPress);
        });


        theText.keyup(function (event) {
            keyReport(event, theOutputKeyUp);
        });

        theText.focusout(function (event) {
            theOutputFocusOut.html(".focusout() fired!");
        });

        theText.focus(function (event) {
            theOutputFocusOut.html(".focus() fired!");
        });

        function keyReport(event, output) {
            // catch enter key = submit (Safari on iPhone=10)
            if (event.which == 10 || event.which == 13) {
                event.preventDefault();
            }
            // show event.which
            output.html(event.which + "&nbsp;&nbsp;&nbsp;&nbsp;event.keyCode " + event.keyCode);
            // report invisible keys  
            switch (event.which) {
                case 0:
                    output.append("event.which not sure");
                    break;
                case 13:
                    output.append(" Enter");
                    break;
                case 27:
                    output.append(" Escape");
                    break;
                case 35:
                    output.append(" End");
                    break;
                case 36:
                    output.append(" Home");
                    break;
            }
            // show field content
            theOutputText.text(theText.val());
        }*/
        //setup before functions
        var typingTimer;                //timer identifier
        var doneTypingInterval = 3000;  //time in ms (5 seconds)

        //on keyup, start the countdown
        $('#theText').keyup(function(){
            clearTimeout(typingTimer);
            if ($('#theText').val()) {
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            }
        });

        //user is "finished typing," do something
        function doneTyping (){
            //do something
            var val = $('#theText').val();
            alert(val + ' es el valor');
        }
    });
</script>
