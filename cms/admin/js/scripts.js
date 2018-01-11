tinymce.init({selector:'textarea'});

$(document).ready(function(){
    $('#selectAllBoxes').click(function(){
        var checkBoxes = $('.checkBoxes');
        checkBoxes.prop("checked", !checkBoxes.prop("checked"));

    })

    $('.confirmDelete').click(function(){
        console.log("Ciao");
        return confirm("Are you sure to delete?");
    })
});