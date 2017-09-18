$(document).ready(function () {

    //variables
    page_number=1;

    Pagination(page_number);
    validateCustomer(page_number);

    function Pagination(pageNumber) {
        $.ajax({
            url:'curl.php',
            data:{
                task:'pagination',
                pagenum:pageNumber
            },
            type:'post',
            cache:false,
            success:function(pagination){
                $("#pagination_wrapper").empty().append(pagination);

            }
        });//end of ajax function
    }//End of pagination function



    $("#main_container").on('click','.page_num',function () {
        page_number=$(this).text();
        Pagination(page_number);
        validateCustomer(page_number);

    });//end of page num click function

    function validateCustomer(pageNumber){
        $.ajax({
            url:'curl.php',
            data:{
                task:'customerValidation',
                pagenum:pageNumber
            },
            type:'post',
            cache:false,
            success:function(info){
                //console.log(info);
                if(info.length>0){
                    if($("#output").length===0){
                        $("<div id=output></div>").insertBefore("#pagination_wrapper");
                    }
                    $("#output").empty().append(info);

                }
                else{
                    $("#output").remove();
                }
            }
        });//end of ajax function
    }


}); //end of ready function