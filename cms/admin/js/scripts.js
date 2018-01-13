tinymce.init({selector:'textarea'});

$(document).ready(function(){
    $('#selectAllBoxes').click(function(){
        var checkBoxes = $('.checkBoxes');
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));

    });

    $('.confirmDelete').click(function(){
        console.log("Ciao");
        return confirm("Are you sure to delete?");
    });

    /*var preloader = "<div id=\"load-screen\"'><div id=\"loading\"></div></div>";
    $('body').prepend(preloader);

    $('#load-screen').delay(400).fadeOut(200, function(){
        $('#load-screen').remove();
    })*/

    loadUserOnline();
});


function loadUserOnline(){
    $.get("functions.php?onlineusers=result", function(data){
        $('.usersonline').text(data);
    })
}

setInterval(function(){
    loadUserOnline();
}, 60000);