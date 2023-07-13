<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
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
        #success-message{
            background-color : #DEF1D8;
            color : green;
            padding : 10px;
            margin : 10px;
            display : none;
            position : absolute;
            right: 15px;
            top : 15px;
        }
        #error-message{
            background-color : #EFDCDD;
            color : red;
            padding : 10px;
            margin : 10px;
            display : none;
            position : absolute;
            right: 15px;
            top : 15px;
        }
        .delete-btn{
            background:red;
            color:#fff;
            border:0;
            padding: 4px 10px;
            border-radius:3px;
            cursor:pointer;
        }
        .edit-btn{
            background:green;
            color:#fff;
            border:0;
            padding: 4px 10px;
            border-radius:3px;
            cursor:pointer;
        }
        #model{
            background:rgba(0,0,0,0.7);
            position: fixed;
            left:0;
            top:0;
            width: 100%;
            height:100%;
            z-index: 100;
            display: none;
        }
        #model-form{
            background: #fff;
            width:30%;
            position: relative;
            top: 20%;
            left: calc(50%-15%);
            padding: 15px;
            border-radius: 4px;
        }
        #model-form h2{
            margin: 0 0 15px;
            padding: 10px;
            border-bottom: 1px solid #000;
        }
        #close-btn{
            background: red;
            color: white;
            width:30px;
            height:30px;
            line-height:30px;
            text-align: center;
            border-radius: 50%;
            position : absolute;
            top:-15px;
            right: -15px;
            cursor: pointer;
        }
        #pagination{
            border-radius: 50%;
            text-align:center;
        }
    </style>
    <body>
        <table>
            <tr>
                <td id="header">
                    <h1>Add Record With PHP & Ajax</h1>
                </td>
            </tr>
            <div id="search-bar">
                <label>Search :</label>
                <input type="text" id ="search">
            </div>
            <tr>
                <td id="table-form">
                    <form id="addForm">
                        First Name: <input type="text" id="fname">&nbsp;&nbsp;
                        Last Name: <input type="text" id="lname">
                        <input type="submit" id="save-button" value="Save">
                    </form>
                </td>
            </tr>
            <tr>
                <td id="table-data">
                </td>
            </tr>
        </table>
        <div id="error-message"></div>
        <div id="success-message"></div>
        <div id="model">
            <div id="model-form">
                <h2>Edit Form</h2>
                <table cellpadding="10px" width="100%">
                </table>
                <div id="close-btn">X</div>
            </div>
           
        </div>
        <script src="js/jquery.js"></script>
        <script>
            $(document).ready(function(){
                function loadTable(){ 
                    $.ajax({
                        url:'ajax-load.php',
                        type:'POST',
                        success: function(data){
                            $('#table-data').html(data);
                        }
                    });
                }
                loadTable();
                $('#save-button').on('click',function(e){
                    e.preventDefault();
                    var fname = $('#fname').val();
                    var lname = $('#lname').val();
                    if(fname == '' || lname == ''){
                        $('#error-message').html("All Fields are Required").slideDown();
                        $('#success-message').slideUp();    
                    }else{
                        $.ajax({
                        url : 'ajax-insert.php',
                        type : 'POST',
                        data : { first_name : fname, last_name: lname},
                        success : function(data){
                            if(data == 1){
                                loadTable();
                                $('#addForm').trigger('reset');
                                $('#success-message').html("Record Insertes Successfully").slideDown();
                                $('#error-message').slideUp(); 
                            }else{
                                $('#error-message').html("Somthing Want Wrong").slideDown();
                                $('#success-message').slideUp(); 
                            }
                            
                        }
                    })
                    }
                    loadTable();
                });
                $(document).on('click','.delete-btn',function(){
                    if(confirm("Do You really want to delete this record ?")){
                    var studentId = $(this).data('id');

                    var element = this;
                    $.ajax({
                        url:'ajax-delete.php',
                        type:'POST',
                        data:{id: studentId},
                        success: function(data){
                            if(data==1){
                                $(element).closest('tr').fadeOut();
                            }else{
                                $('#error-message').html("Can't Delete Record.").slideDown();
                                $('#success-message').slideUp();  
                            }
                        }
                    });
                }
                });
                //Show Model box
                $(document).on('click','.edit-btn',function(){
                            $('#model').show();
                            var studentId = $(this).data("eid");

                            $.ajax({
                                url:"load-update-form.php",
                                type: "POST",
                                data:{ id: studentId },
                                success:function(data){
                                    $('#model-form table').html(data);
                                }
                            })
                        });
                        // Hide Model Box
                      $('#close-btn').on('click',function(){
                        $('#model').hide();
                      });
                      //Save Update Form  
                      $(document).on('click','#edit-submit',function(){
                        var stuId = $('#edit-id').val();
                        var fname = $('#edit-fname').val();
                        var lname = $('#edit-lname').val();

                        $.ajax({
                            url:"ajax-update-form.php",
                            type: "POST",
                            data: { id:stuId, first_name:fname, last_name:lname},
                            success : function(data){
                                if(data == 1){
                                    $('#model').hide();
                                    loadTable();
                                }
                            }
                        })
                      });
                      // Live Search
                      $('#search').on('keyup',function(){
                        var search_term = $(this).val();

                        $.ajax({
                            url:"ajax-live-search.php",
                            type:"POST",
                            data: { search: search_term},
                            success: function(data){
                                $('#table-data').html(data);
                            }
                        });
                      });
                });
               $(document).ready(function(){
                function loadTable(page){
                    $.ajax({
                        url:"ajax-pagination.php",
                        type:"POST",
                        data:{page_no:page},
                        success: function(data){
                            $('#table-data').html(data);
                        }
                    });
                }
                loadTable();
                //pagination Code
                $(document).on('click','#pagination a',function(e){
                    e.preventDefault();
                    var page_id = $(this).attr('id');
                    loadTable(page_id);
                });
               }); 
        </script>
    </body>
</html>