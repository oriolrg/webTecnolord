$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    $('input').click(function () {
        if ($(this).val() < 1){
            $('input').next().css("color", "grey");
            $("input:radio:checked").next().css("color", "red");
            var pregunta = $(this).attr('name');
            postError(pregunta);
        }
        if ($(this).val() >= 1) {
            $('input').next().css("color", "grey");
            $("input:radio:checked").next().css("color", "green");
            var pregunta = $(this).attr('name');
            postOk(pregunta);
            $('#' + $(this).attr('name')).delay(3000).hide(0);
        }
        
    });

});
function postError(pregunta){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: "/webOpos/pregunta/error",
        data: {question : pregunta},
        success: function (data) {
            console.log(data);
        },
        error: function (data) {
            console.log(data);
        },
        datatype: 'application/json',
        //dataType: dataType
    });
}
function postOk(pregunta) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        url: "/webOpos/pregunta/ok",
        data: { question: pregunta },
        success: function (data) {
            console.log(data);
        },
        error: function (data) {
            console.log(data.msg);
        },
        datatype: 'application/json',
        //dataType: dataType
    });
}
//
