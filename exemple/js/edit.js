
        //
        $(document).ready(function(){
            $('.field').css("visibility", "hidden");
            $('.dataline').hover(function(){
                $('.editbtn').css("display", "");
            });
            $('.editbtn').click(function(){
                $('.editbtn').css("display", "none");
                $('.savebtn').css("display", "");
                $('.dataline').css("display", "none");
                $('.editline').css("display", "");
            });
            $('.save').click(function(){
                $('textarea').css("pointer-events", "none");
                $('.hide1').css("pointer-events", "none");
                $('.hide2').css("pointer-events", "none");
                $('.hide3').css("pointer-events", "none");
                $('.visible1').css("pointer-events", "none");
                $('.visible2').css("pointer-events", "none");
                $('.visible3').css("pointer-events", "none");
                $('#max-width').css("background-color", "");
            });
        });