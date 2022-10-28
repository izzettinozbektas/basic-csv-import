<!doctype html>
<html lang="tr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script
            src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
            crossorigin="anonymous"></script>
    <title>Mivento Assessment</title>

    <style>
        .container {
            margin-top: 2rem !important;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <span id="msg" style="color:red"></span>
            <div hidden class="alert alert-danger"> <small>Yüklenemedi </small></div>
            <div hidden class="alert alert-success"> İşlem Başarılı</div>
            <form class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="campaign-file" class="form-label">Dosya Yükleyin</label>
                    <input class="form-control" type="file" id="campaign-file" required />
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary btn-block " disabled type="button">Yükle</button>
                </div>
            </form>
        </div>
        <div hidden class="col-md-8 dataTableClass">
            <table id="dataTable">
                <thead>
                <tr style="font-weight: bold">
                    <td style="width: 100px;">Name</td>
                    <td style="width: 100px;">Surname</td>
                    <td style="width: 400px;">Email</td>
                    <td style="width: 200px;">Employee_id</td>
                    <td style="width: 200px;">Phone</td>
                    <td style="width: 100px;">Point</td>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#campaign-file").change(function(){
            var property = document.getElementById('campaign-file').files[0];
            var image_name = property.name;
            var image_extension = image_name.split('.').pop().toLowerCase();

            if(jQuery.inArray(image_extension,['csv']) == -1){
                alert("Invalid csv file");
            }else{
                $(".needs-validation button").removeAttr('disabled');
            }

        });
        $(".needs-validation button").on('click',  function (){

            var property = document.getElementById('campaign-file').files[0];
            var image_name = property.name;
            var form_data = new FormData();
            form_data.append("file",property);
            $.ajax({
                url:'/importFile',
                method:'POST',
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                beforeSend:function(){
                    $('#msg').html('Loading......');
                },
                success:function(data){
                    if(data == "true"){
                        $('#msg').remove();
                        $(".alert-success").removeAttr('hidden');
                        $(".dataTableClass").removeAttr('hidden');
                        $.ajax({
                            url: '/getData',
                            method: 'GET',
                            contentType: JSON,
                            processData: JSON,
                            success: function (dt) {
                                var tbody;
                                $.each( JSON.parse(dt)['data'], function( key, val ) {
                                    tbody = '<tr>' +
                                        '<td>'+val.name+'</td>' +
                                        '<td>'+val.surname+'</td>' +
                                        '<td>'+val.email+'</td>' +
                                        '<td>'+val.employee_id+'</td>' +
                                        '<td>'+val.phone+'</td>' +
                                        '<td>'+val.point+'</td>' +
                                        '</tr>';
                                    $("#dataTable tbody").append(tbody);
                                });

                            }
                        });

                    }else{
                        $(".alert-danger").removeAttr('hidden');
                    }
                }
            });
        });
        //

        $.ajax({
            url: '/getData',
            method: 'GET',
            contentType: JSON,
            processData: JSON,
            success: function (dt) {

                if(JSON.parse(dt)['data'].length ==  0){
                    $(".dataTableClass").attr('hidden');
                }else{
                    $(".dataTableClass").removeAttr('hidden');
                }
                var tbody;
                $.each( JSON.parse(dt)['data'], function( key, val ) {
                    tbody = '<tr>' +
                        '<td>'+val.name+'</td>' +
                        '<td>'+val.surname+'</td>' +
                        '<td>'+val.email+'</td>' +
                        '<td>'+val.employee_id+'</td>' +
                        '<td>'+val.phone+'</td>' +
                        '<td>'+val.point+'</td>' +
                        '</tr>';
                    $("#dataTable tbody").append(tbody);
                });

            }
        });

    });

</script>
</body>
</html>
