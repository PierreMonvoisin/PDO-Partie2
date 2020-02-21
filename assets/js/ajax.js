$(function () {
    $('#searchPatient').on('keyup', function () {
        let input = $(this).val();
        if (input.length >= 2) {
            axios.post(
                    "http://pdopartie2.exercice/pdo-partie2-correction/Controllers/add-appointmentController.php",
                    {
                        search: input
                    }
            )
                    .then(function (response) {
                        var ul = $('.list-group');
                        ul.empty();
                        if (response.data.length > 0) {
                            response.data.map(function (patient) {
                                var li = $('<li></li>');
                                li.addClass('list-group-item');
                                li.attr('data-id', patient.id);
                                li.text(`${patient.firstname} ${patient.lastname}`);
                                ul.append(li);
                            })
                        }
                    })
        }
    });
    $('#suggestBox').on('click','.list-group-item',function(){
        var inputValue = $(this).text();
        var idPatient = $(this).data('id');
        $('#searchPatient').val(inputValue);
         $('#idPatient').val(idPatient);
        $('#suggestBox ul').empty();
    })
});

