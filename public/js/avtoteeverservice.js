$("#button1").click(function(){

    $.ajax({
        type:'GET',
        url:'http://spark.transdep.mn:8080/XYPMRTD/ClientGaali.php',
        dataType: "json",
        data:{platenumber:"02209102215I34146"},
        success:function(data){
            $.each(data, function(key,value) {
                console.log(value.response);
                console.log(value.response["changeMode"]);
            });
        }
    });

});

$("#button2").click(function(){

    $.ajax({
        type:'GET',
        url:'http://spark.transdep.mn:8080/XYPMRTD/ClientPenalty.php',
        dataType: "json",
        data:{platenumber:"5169УБЗ"},
        success:function(data){
            $.each(data, function(key,value) {
                value.response.list.forEach(function(item) {
                    console.log(item);
                    console.log(item["localName"]);
                });
            });
        }
    });

});