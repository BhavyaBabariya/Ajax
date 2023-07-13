<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
             #header{
            text-align:center;
            background-color: #ffee93;
        }
        #table-form{
            background-color: #a0ced9;
            padding:15px;
        }
        #table-data{
            background-color: #fcf5c7;
        }
        #table-data tr:nth-child(even){
            background-color: #ffc09f;
        }
        .delete-btn{
            background:red;
            color:#fff;
            border:0;
            padding: 4px 10px;
            border-radius:3px;
        }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <td id="header">
                    <h1>PHP With Ajax</h1>
                </td>
            </tr>
            <tr>
                <td id="table-load">
                    <input type="button" id="load-button" value="Load Value">
                </td>
            </tr>
            <tr>
                <td id="table-data">
                </td>
            </tr>
        </table>
        <script src="js/jquery.js"></script>
        <script>
            $(document).ready(function(){
                $('#load-button').on('click',function(e){
                    $.ajax({
                        url:'ajax-load.php',
                        type:'POST',
                        success: function(data){
                            $('#table-data').html(data);
                        }
                    });
                });
            });
        </script>
    </body>
</html>