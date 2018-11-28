$(document).ready(function(){
    $('#pf').change(function(){
        var pf = $(this).val();
        var type = 'puissance-fiscale';
        $.ajax({
            url : "inc/fetch_datas.php",
            method : "POST",
            data : {pfType:pf,type:type},
            dataType : "text",
            success : function(data){
                $('#pfValue').html(data);
            }
        });
    });
    $('#status-pro').change(function(){
        var spro = $(this).val();
        var type = 'socio-pro';
        $.ajax({
            url : "inc/fetch_datas.php",
            method : "POST",
            data : {stat:spro,type:type},
            dataType : "text",
            success : function(data){
                $('#info-status-pro').prop('title',data);
            }
        });
    });
    $('#catcar').change(function(){
        var catcar = $(this).val();
        var type = 'cat';
        $.ajax({
            url : "inc/fetch_datas.php",
            method : "POST",
            data : {cat:catcar,type:type},
            dataType : "text",
            success : function(data){
                $('#cat-desc').html(data);
            }
        });
    });
    $('#classe-permis').change(function(){
        var classe = $(this).val();
        var type = 'cls-pc';
        $.ajax({
            url : "inc/fetch_datas.php",
            method : "POST",
            data : {classe:classe,type:type},
            dataType : "text",
            success : function(data){
                $('#classe-desc').html(data);
            }
        });
    });
    $('#def-rec').change(function(){
        $('#defense').prop('enabled','enabled');
    });
});