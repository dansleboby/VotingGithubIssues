$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function () {
    function githubs() {
        $.get(baseurl+'/api/rows', function(res) {
            $("#rows").html(res);
            $("#loader").slideUp(200);
        });
    }

    $("body").on("click", ".votes span.btnVotes", function() {
        console.log('click!');
        $("#loader").slideDown(200);
        var action = $(this).data('action');
        var github_id = $(this).parent().data('id');

        $.post(baseurl + '/api/votes', {github_id: github_id, action: action}, function(res) {
            if(res.status != "success") {
                alert(res.status);
                $("#loader").slideUp(200);
            } else
                githubs();
        });
    });

    githubs();
});
