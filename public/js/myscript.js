var currSupplierId = 0;
// function comboboxChange(){
//     currSupplierId = $('#currSupplierId').val();
// }

// jQuery(function($){
//    // $("input[name=contact]").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
//    $("input[name=contact]").mask("999999999999");
// });
var email_pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

jQuery('input[type=number]').keyup(function () { 
    this.value = this.value.replace(/[^0-9\.]/g,'');
});

function cekCodeAjax(menu,code){
    var flag = 0;

    $.ajax({
            url : "loadCode/"+menu+"/"+code,
            dataType: "json",
            async: false,
            success :function(result){
                flag = result;
            }
    });
    return flag==0;
}

function cekCategoryAjax(id,name){
    var flag = 0;

    $.ajax({
            url : "loadCategoryNameUpdate/"+id+"/"+name,
            dataType: "json",
            async: false,
            success :function(result){
                flag = result;
            }
    });
    return flag==0;
}

function cekSkuAjax(sku){
    var flag = 0;

    $.ajax({
            url : "loadSku/"+sku,
            dataType: "json",
            async: false,
            success :function(result){
                flag = result;
            }
    });
    return flag==0;
}

function validateCategory(){

    var success = 0;
    
    if(!cekCodeAjax('Category',$("input[name=name]").val())){
        $('.text').text('Error, nama kategori yang di input sudah ada');
    }else{
        success = 1;
    }

    if(success == 1) return true;
    else{
        $( ".alert" ).show().fadeOut(6000);
        return false;
    }
}

function validateUpdateCategory(){

    var success = 0;
    
    if(!cekCategoryAjax($("input[name=id]").val(),$("input[name=name]").val())){
        $('.text').text('Error, nama kategori yang di input sudah ada');
    }else{
        success = 1;
    }

    if(success == 1) return true;
    else{
        $( ".alert" ).show().fadeOut(6000);
        return false;
    }
}

function cekInputPenjualanQty() {
    var totalItem = parseInt($("input[name=totalItem]").val());
    for(var x = 0 ; x < totalItem ; x++){
        if(typeof $("input[name=qtyBeli"+x+"]").val() !== 'undefined'){
            // alert(parseInt($("input[name=qtyBeli"+x+"]").val()) + " | " + parseInt($(".totalQty"+x).text()));
            if(parseInt($("input[name=qtyBeli"+x+"]").val()) > parseInt($(".totalQty"+x).text().trim())){
                return false;
            }
        }
    }
    return true;
}

function validateData(menu){
    var success = 0;
    var inputCode = menu+'Code';
    var codeValue = $("input[name="+inputCode+"]").val();
    var skuValue = $("input[name=itemSku]").val();
    // var menuCekEmail = "supplier,customer,updateCustomer,updateSupplier";
    var menuCekCode = "supplier,customer,item";
    var upperFirstChar = menu.replace(menu.charAt(0), menu.charAt(0).toUpperCase());
    // cekCodeAjax(menu,codeValue)
    // if(typeof codeValue !== 'undefined' && codeValue.length > 10){
    //     $('.text').text('Error, Panjang dari '+inputCode+' Harus antara 1 dan 10');
    // }else 
    if(typeof codeValue !== 'undefined' && !cekCodeAjax(upperFirstChar,codeValue)){
        $('.text').text('Error, Kode yang di input sudah ada');
    }
    // else if(menuCekEmail.indexOf(menu) != -1 && !email_pattern.test($("input[name=email]").val())){
    //     $('.text').text('Error, Email tidak valid');
    // }
    // else if(menu == "item" && $("input[name=itemSku]").val().length > 11){
    //     $('.text').text('Error, Panjang dari SKU Barang Harus antara 1 dan 10');
    // }
    else if(menu == "item" && !cekSkuAjax($("input[name=itemSku]").val())){
        $('.text').text('Error, SKU yang di input sudah ada');
    }
    // else if(menu == "item" && typeof $('#supplierId').val() === 'undefined'){
    //     $('.text').text('Error, Supplier belum dipilih');
    // }
    else{
        success = 1;
    }

    if(success == 1) return true;
    else{
        $( ".alert" ).show().fadeOut(6000);
        return false;
    }
}


function validateInsertReturan() {
    var success = 0;

    if(typeof selectedItemCode[0] === 'undefined'){
        $('.text').text('Error, Belum ada penjualan yang terpilih');
    }else{
        success = 1;
    }



    if(success == 1) return true;
    else{
        $( ".alert" ).show().fadeOut(6000);
        return false;
    }
}

function validateDateBetween(){
    var success = 0;

    if(Date.parse($("input[name=searchTo]").val()) < Date.parse($("input[name=searchFrom]").val())){
        $('.text').text('Error, tanggal sampai harus lebih besar tanggal dari');
    }
    else{
        success = 1;
    }

    if(success == 1) return true;
    else{
        $( ".alert" ).show().fadeOut(6000);
        return false;
    }
}

function validateInsertPenjualan(){
    var success = 0;

    // if(typeof $("input[name=noNota]").val() !== 'undefined' && $("input[name=noNota]").val().length > 10 ){
    //     $('.text').text('Error, Panjang dari Nomor Nota Harus antara 1 dan 10');
    // }else 
    if(typeof $("input[name=noNota]").val() !== 'undefined' && !cekCodeAjax('Penjualan',$("input[name=noNota]").val())){
        $('.text').text('Error, Kode yang di input sudah ada');
    }else if(Date.parse($("input[name=estimate]").val()) <= Date.parse($("input[name=getDateTimeNow]").val())){
        $('.text').text('Error, tanggal estimasi harus lebih besar dari tanggal SO');
    }else if(!$('#customerId').length){
        $('.text').text('Error, Customer Belum di pilih');
    }
    // else if(typeof selectedItemCode[0] === 'undefined'){
    //     $('.text').text('Error, Belum ada barang yang terpilih');
    // }
    else if($('#selectedItem').find('tr').text() == ""){
        $('.text').text('Error, Belum ada barang yang terpilih');
    }
    else if(!cekInputPenjualanQty()){
        $('.text').text('Error, inputan kuantitas melebihi stock');
    }else{
        success = 1;
    }



    if(success == 1) return true;
    else{
        $( ".alert" ).show().fadeOut(6000);
        return false;
    }
}

function validateInsertPembelian(){
    var success = 0;

    if(typeof $("input[name=noNota]").val() !== 'undefined' && $("input[name=noNota]").val().length > 10 ){
        $('.text').text('Error, Panjang dari Nomor Nota Harus antara 1 dan 10');
    }else if(typeof $("input[name=noNota]").val() !== 'undefined' && !cekCodeAjax('Pembelian',$("input[name=noNota]").val())){
        $('.text').text('Error, Kode yang di input sudah ada');
    }else if(Date.parse($("input[name=estimate]").val()) <= Date.parse($("input[name=getDateTimeNow]").val())){
        $('.text').text('Error, tanggal estimasi harus lebih besar dari tanggal PO');
    }
    else if(typeof $("input[name=noNota]").val() !== 'undefined' && !$('#supplierId').length){
        $('.text').text('Error, Supplier Belum di pilih');
    } 
    else if($('#menu-update-pembelian').length && $('#currSupplierId').length == 0){
        $('.text').text('Error, Supplier Belum di pilih'); //menu update pembelian
    }
    else if(!$('#supplierId').length && $('#menu-pembelian').length){
        $('.text').text('Error, Supplier Belum di pilih');
    }
    else if(typeof selectedItemCode[0] === 'undefined' && $('#menu-pembelian').length){
        $('.text').text('Error, Belum ada barang yang terpilih');
    }else{
        success = 1;
    }

    if(success == 1) return true;
    else{
        $( ".alert" ).show().fadeOut(6000);
        return false;
    }
}

var selectedItemCode = [];
// selectedItemCode.splice(selectedItemCode.indexOf(8),1);



function searchOnTable(tableHolder, toSearch){
    var dataHandler = $(tableHolder);
    var dataRows = dataHandler.find('tr');
    if(toSearch == ""){ 
        dataRows.show();
    }else{
        for(var i=0;i<dataRows.length;i++){
            var currentRow = dataRows[i];
            var dataColumns = $(currentRow).find('td');
            var isRowShow = false;
            for(var j=0;j<dataColumns.length;j++){
                var currentColumn = $(dataColumns[j]);
                if(currentColumn.text().toLowerCase().indexOf(toSearch)>=0){
                    isRowShow = true;
                }
            }
            if(isRowShow){
                $(currentRow).show()
            }else{
                $(currentRow).hide()
            }
        }
    }
}

function doPaging(page)
{
    $.ajax({
        url : "?page="+page,
        success:function(data){
            var result= $(data).find('#page-target');
            $('#page-target').html(result);
            $('.table-data').tablesorter();
            // var imported = document.createElement('script'); //append js
            // imported.src = 'http://localhost:8000/js/jquery.tablesorter.min.js';
            // document.head.appendChild(imported);

            // var href="http://localhost:8000/css/theme.default.css"; //append css
            // var link = '<link rel="stylesheet" type="text/css" href="' + href + '">';
            // $('head').append(link);
        }
    });
}

function checkboxChange()
{ //ajaran gowin
    var cekBarang = document.getElementsByClassName('cekBarang');
    var qtyBeli = document.getElementsByClassName('qtyBeli');

    for(var i = 0 ; i < cekBarang.length ; i++){
        if(cekBarang[i].checked == true){
            qtyBeli[i].disabled = false;
        }else{
            qtyBeli[i].disabled = true;
            qtyBeli[i].value = "";
        }
    }
}

// $( ".bell" ).hover(function() {
//   $( ".dropdown-content" ).stop().slideDown("slow");
// });

// $( ".bell" ).mouseout(function() {
//     if($('.dropdown-content').is(":hover")){
//         $('.dropdown-content').show();
//     }else{
//         $('.dropdown-content').slideUp("slow");
//     }
// });

var isOnAnimation = false;

$('.bell').on('click', function(){
    if(!isOnAnimation)
        $('.dropdown-content').slideToggle(function(){
            isOnAnimation = false;
        });
    isOnAnimation = true;
});

$('.datetimepicker').datetimepicker({
    dayOfWeekStart : 1,
    lang:'en',
    disabledDates:['1986/01/08','1986/01/09','1986/01/10']
});

$('.datepicker').datetimepicker({
    timepicker:false,
    format: 'Y-m-d'
});

$("#cbx").click( function(){ //buat alamat customer
    if( $(this).is(':checked') ) $("textarea").attr("disabled",true);
    else $("textarea").attr("disabled",false);
});

$('#addBtn').click(function(){ //buat transaksi returan yang add angka, tapi udah di komen (gak di pake)
    var elems = document.getElementsByName("selected_no");
    var flag = 0;
    if(flag == 0){
        for (var i= 0, len = $('#currno').text().length ; i < len ; i++){
            if($('#currno').text().charAt(i) == $('#novalue').val()){
                alert('nomor sudah terpilih');
                flag = 1;
            }
        }
    }
    if(flag == 0){
        if ($('#currno').text().length != 0){
            $('#currno').append(',');
        }
        $('#currno').append($('#novalue').val());
        for(var j = 0; j < elems.length ; j++){
            elems[j].value = $('#currno').text();
        }

    }
});


$(document).ready(function(){
    // $("#currSupplierId:enabled").hover(function(){
    //     $(this).css("cursor", "not-allowed");
    // });


    


    if($('#menu-update-pembelian').length){
        currSupplierId = $('#currSupplierId').val();
        $.ajax({
            url : "loadPembelianDetailAjax/"+$('#currPembelianId').val(),
            dataType: "json",
            success :function(result){
                $.each(result,function(key,val){
                    selectedItemCode.push(val.item_id);
                });
            }
        });
    }else if($('#menu-update-penjualan').length){
        $.ajax({
            url : "loadPenjualanDetailAjax/"+$('#currPenjualanId').val(),
            dataType: "json",
            success :function(result){
                $.each(result,function(key,val){
                    selectedItemCode.push(val.item_id);
                });
            }
        });
        // alert(selectedItemCode);
    }

    $(document).on("click",".remove-item",function(){
        // alert(selectedItemCode);
        $(this).closest('tr').remove();
        var removedItemId = $(this).closest('tr').find('#itemId').val();
        selectedItemCode.splice(selectedItemCode.indexOf(parseInt(removedItemId)),1);
        $('.table-data').trigger('update');
        // alert(selectedItemCode);
    });

    // $('#remove-customer').click(function(){
    //     $("#customer-row").remove();

    //     var newRow = $("<tr>");
    //     var cell1 = "<td>"+"<button id='btnCustomer' onclick='pilihCustomer()' type='button'>Pilih Customer</button>"+"</td>";
    //     newRow.append(cell1);
    //     $("#table-penjualan-customer").append(newRow);

    //     var tr = document.createElement('tr');
    //     tr.setAttribute('id','selectedCustomer');
    //     $("#table-penjualan-customer").append(tr);
    // });

    $("#searchData").on("keyup", function() {
        var name = $(this).val();
        if(name == "") name = "kosong";
        var dataHandler = $("#load-data");
        dataHandler.html("");
        if(typeof currSupplierId === 'undefined') currSupplierId = 0;
        $.ajax({
            // url : "loadItemAjaxSearch/"+name+"/"+currSupplierId,
            url : "loadItemAjaxSearch/"+name+"/"+0,
            dataType: "json",
            async : false,
            cache : false,
            success :function(result){
                $.each(result,function(key,val){
                    var newRow = $("<tr>");
                    var cell1,cell1to2,cell2,cell3,cell4 = "";
                    cell1 = "<td>"+val.id+"</td>";
                    cell1to2 = "<td>"+val.item_code+"</td>";
                    cell2 = "<td>"+val.item_name+"</td>";
                    cell3 = "<td>"+val.item_qty+"</td>";
                    cell4 = "<td>"+"<input type='checkbox' name='myCheck' class='selectCheck' value="+val.id+">"+"</td>";

                    var tamp = "roundedOne"+key;
                    cell4 = "<td><div class='roundedOne'><input value="+val.id+" type='checkbox' class='selectCheck' id="+tamp+" name='myCheck' /><label for="+tamp+"></label></div></td>";

                    for(var i = 0 ; i < selectedItemCode.length ; i++){
                        if(selectedItemCode[i] == val.id){
                            cell4 = "<td><div class='roundedOne'><input checked value="+val.id+" type='checkbox' class='selectCheck' id="+tamp+" name='myCheck' /><label for="+tamp+"></label></div></td>";
                        }
                    }

                    newRow.html(cell1+cell1to2+cell2+cell3+cell4);
                    dataHandler.append(newRow);
                });
                $('.table-data').trigger('update');
            }
        });
    });

    

    // $('#btnAddBarang').click(function(){
        // if($(this).text() == "select"){
        //     $(this).text('add barang');
        //     $('#currSupplierId').prop('disabled', true);
        //     $('#selectedSupplierId').html("<input type='hidden' name='supplierId' value="+$('#currSupplierId').val()+">");
        // }else{
            // if(typeof currSupplierId === 'undefined') currSupplierId = 0;
            // var dataHandler = $("#load-data");
            // $.ajax({
            //     url : "loadItemAjax/"+currSupplierId,
            //     dataType: "json",
            //     success :function(result){
            //         $.each(result,function(key,val){
                        
            //             var newRow = $("<tr>");
            //             var cell1,cell1to2,cell2,cell3,cell4 = "";
            //             cell1 = "<td>"+val.id+"</td>";
            //             cell1to2 = "<td>"+val.item_code+"</td>";;
            //             cell2 = "<td>"+val.item_name+"</td>";
            //             cell3 = "<td>"+val.item_qty+"</td>";
            //             cell4 = "<td>"+"<input type='checkbox' name='myCheck' class='selectCheck' value="+val.id+">"+"</td>";


            //             // if(typeof selectedItemCode[key] !== 'undefined'){
            //             // } //isset in javascript
            //             for(var i = 0 ; i < selectedItemCode.length ; i++){
            //                 if(selectedItemCode[i] == val.id){
            //                     cell4 = "<td>"+"<input type='checkbox' checked name='myCheck' class='selectCheck' value="+val.id+">"+"</td>";
            //                 }
            //             }
                        
            //             newRow.html(cell1+cell1to2+cell2+cell3+cell4);
            //             dataHandler.append(newRow);
            //         });
            //         // console.log(result);
            //     } 
            // });
            // popupOn();
            // }
    // });
    $(document).on("click",".supplierPic",function(){
        var dataHandler = $("#load-data-pic"); //not used
        $.ajax({
            url : "supplierAjax/"+$(this).val(),
            dataType: "json",
            success :function(result){
                var cell1,cell2,cell3,header = "";
                header = "<h2>rincian PIC</h2>";
                cell1 = "<p>nama : "+result.pic_name+"</p>";
                cell2 = "<p>kontak : "+result.pic_contact+"</p>";
                cell3 = "<p>email : "+result.pic_email+"</p>";

                dataHandler.html(header+cell1+cell2+cell3);
            }
        });
        popupOnDetail();
    });

    $(document).on("click",".supplierDetail",function(){
        var dataHandler = $("#load-data-supplier");
        $.ajax({
            url : "supplierAjax/"+$(this).val(),
            dataType: "json",
            success :function(result){
                var cell1,cell2,cell3,cell4,header = "";
                header = "<h2>rincian supplier</h2>";
                cell1 = "<p>alamat : "+result.supplier_location+"</p>";
                cell2 = "<p>deskripsi : "+result.supplier_description+"</p>";
                cell3 = "<p>nama pic: "+result.pic_name+"</p>";
                cell4 = "<p>kontak pic: "+result.pic_contact+"</p>";

                dataHandler.html(header+cell1+cell2+cell3+cell4);
            }
        });
        popupOnDetail();
    });

    $(document).on("click",".customerPic",function(){
        var dataHandler = $("#load-data-pic"); //not used
        $.ajax({
            url : "customerAjax/"+$(this).val(),
            dataType: "json",
            success :function(result){
                var cell1,cell2,cell3,header = "";
                header = "<h2>rincian PIC</h2>";
                cell1 = "<p>nama : "+result.pic_name+"</p>";
                cell2 = "<p>kontak : "+result.pic_contact+"</p>";
                cell3 = "<p>email : "+result.pic_email+"</p>";

                dataHandler.html(header+cell1+cell2+cell3);
            }
        });
        popupOnDetail();
    });

    $(document).on("click",".customerDetail",function(){
        var dataHandler = $("#load-data-supplier");
        $.ajax({
            url : "customerAjax/"+$(this).val(),
            dataType: "json",
            success :function(result){
                var cell1,cell2,cell3,cell4,header = "";
                header = "<h2>rincian customer</h2>";
                cell1 = "<p>alamat : "+result.customer_location+"</p>";
                cell2 = "<p>deskripsi : "+result.customer_description+"</p>";
                cell3 = "<p>nama pic : "+result.pic_name+"</p>";
                cell4 = "<p>kontak pic : "+result.pic_contact+"</p>";

                dataHandler.html(header+cell1+cell2+cell3+cell4);
            }
        });
        popupOnDetail();
    });
    
    $(document).on("click",".pembelianDetail",function(){
        var dataHandler = $("#load-data-pembelian");
        $.ajax({
            url : "pembelianDetailAjax/"+$(this).val(),
            dataType: "json",
            success :function(result){
                var header,table,headRow,head1,head2,head3 = "";
                header = "<h2>rincian Pembelian</h2>";

                var orderArrayHeader = ["kode barang","nama barang","kuantitas pembelian"];

                var table = document.createElement('table');
                table.setAttribute('border', '1');
                // table.setAttribute('class', 'popupTable');
                table.setAttribute('class', 'table-data');
                var trhead = document.createElement('tr');
                var thead = document.createElement('thead');
                var tbody = document.createElement('tbody');
                tbody.setAttribute('id','load-data-pembelian-detail');

                thead.appendChild(trhead);
                table.appendChild(thead);
                table.appendChild(tbody);

                for(var i=0;i<orderArrayHeader.length;i++){
                    trhead.appendChild(document.createElement("th")).
                    appendChild(document.createTextNode(orderArrayHeader[i]));
                }
                dataHandler.append(header);
                dataHandler.append(table);

                $.each(result,function(key,val){
                    var newRow = $("<tr>");
                    var cell1,cell2,cell3 = "";
                    cell1 = "<td>"+val.item_code+"</td>";
                    cell2 = "<td>"+val.item_name+"</td>";
                    cell3 = "<td>"+val.purchase_qty+"</td>";

                    newRow.html(cell1+cell2+cell3);
                    $("#load-data-pembelian-detail").append(newRow);
                });
                $('.table-data').tablesorter();
            }
        });
        popupOnDetail();
    });


    $(document).on("click",".penjualanDetail",function(){
        var dataHandler = $("#load-data-pembelian");
        $.ajax({
            url : "penjualanDetailAjax/"+$(this).val(),
            dataType: "json",
            success :function(result){
                console.log(result)
                var header,table,headRow,head1,head2,head3 = "";
                header = "<h2>rincian Penjualan</h2>";

                var orderArrayHeader = ["kode barang","nama barang","kuantitas penjualan"];

                var table = document.createElement('table');
                table.setAttribute('border', '1');
                // table.setAttribute('class', 'popupTable');
                table.setAttribute('class', 'table-data');
                var trhead = document.createElement('tr');
                var thead = document.createElement('thead');
                var tbody = document.createElement('tbody');
                tbody.setAttribute('id','load-data-pembelian-detail');

                thead.appendChild(trhead);
                table.appendChild(thead);
                table.appendChild(tbody);

                for(var i=0;i<orderArrayHeader.length;i++){
                    trhead.appendChild(document.createElement("th")).
                    appendChild(document.createTextNode(orderArrayHeader[i]));
                }
                dataHandler.append(header);
                dataHandler.append(table);

                $.each(result,function(key,val){
                    var newRow = $("<tr>");
                    var cell1,cell2,cell3 = "";
                    cell1 = "<td>"+val.item_code+"</td>";
                    cell2 = "<td>"+val.item_name+"</td>";
                    cell3 = "<td>"+val.selling_qty+"</td>";

                    newRow.html(cell1+cell2+cell3);
                    $("#load-data-pembelian-detail").append(newRow);
                });
                $('.table-data').tablesorter();
            }
        });
        popupOnDetail();
    });

    $(document).on("click",".returanDetail",function(){
        var dataHandler = $("#load-data-returan");
        $.ajax({
            url : "returanDetailAjax/"+$(this).val(),
            dataType: "json",
            success :function(result){
                console.log(result);
                var header,table,headRow,head1,head2,head3 = "";
                header = "<h2>rincian Returan</h2>";

                // var orderArrayHeader = ["id penjualan","nama customer","nama barang",
                //                     "jumlah qty jual","jumlah qty retur","qty waste","qty kembali"];

                var orderArrayHeader = ["kode barang","nama barang","jumlah kuantitas jual","jumlah kuantitas retur"
                                            ,"kuantitas kerugian","kuantitas kembali"];

                if($('#menu-wastelist').length){
                    header = "<h2>rincian kerugian</h2>";
                    var orderArrayHeader = ["kode barang","nama barang","kuantitas kerugian"];
                }

                var table = document.createElement('table');
                // table.className = "table-data";
                table.setAttribute('border', '1');
                table.setAttribute('class', 'table-data');
                var trhead = document.createElement('tr');
                var thead = document.createElement('thead');
                var tbody = document.createElement('tbody');
                tbody.setAttribute('id','load-data-returan-detail');

                thead.appendChild(trhead);
                table.appendChild(thead);
                table.appendChild(tbody);

                for(var i=0;i<orderArrayHeader.length;i++){
                    trhead.appendChild(document.createElement("th")).
                    appendChild(document.createTextNode(orderArrayHeader[i]));
                }
                dataHandler.append(header);
                dataHandler.append(table);
                

                $.each(result,function(key,val){
                    var newRow = $("<tr>");
                    var cell1,cell2,cell3,cell4,cell5,cell6,cell7 = "";
                    // cell1 = "<td>"+val.penjualan_detail.id_penjualan+"</td>";
                    // cell2 = "<td>"+val.customer.customer_name+"</td>";
                    cell2 = "<td>"+val.item.item_code+"</td>";
                    cell3 = "<td>"+val.item.item_name+"</td>";
                    cell4 = "<td>"+val.penjualan_detail.selling_qty+"</td>";
                    cell5 = "<td>"+val.qty_retur+"</td>";
                    cell6 = "<td>"+val.returan_detail_status.qty_waste+"</td>";
                    cell7 = "<td>"+val.returan_detail_status.qty_kembali+"</td>";

                    if($('#menu-wastelist').length){
                        cell4 = ""; cell5=""; cell7="";
                        if(val.returan_detail_status.qty_waste != 0){
                            newRow.html(cell2+cell3+cell4+cell5+cell6+cell7);
                            $("#load-data-returan-detail").append(newRow);
                        }
                    }else{
                        newRow.html(cell2+cell3+cell4+cell5+cell6+cell7);
                        $("#load-data-returan-detail").append(newRow);
                    }

                    // $('.table-data').tablesorter();
                    // newRow.html(cell1+cell2+cell3+cell4+cell5+cell6+cell7);
                    // if($('#menu-wastelist').length && val.returan_detail_status.qty_waste != 0){
                    //     newRow.html(cell3+cell4+cell5+cell6+cell7);
                    //     $("#load-data-returan-detail").append(newRow);
                    // }
                    // $('.table-data').tablesorter();
                });
                // console.log('apa');
                $('.table-data').tablesorter();
            }
        });
        
        popupOnDetail();

    });

    $('#tambahSupplier,#tambahCustomer,#tambahBarang').click(function(){
        popupOn();
    });

    $(document).on("click","#pilihSupplier",function(){
        var dataHandler = $("#load-data-supplier");
        $.ajax({
            url : "loadSupplierAjax",
            dataType: "json",
            success :function(result){
                $.each(result,function(key,val){
                    
                    var newRow = $("<tr>");
                    var cell1,cell2,cell3,cell4 = "";
                    cell1 = "<td>"+val.id+"</td>";
                    cell2 = "<td>"+val.supplier_code+"</td>";
                    cell3 = "<td>"+val.supplier_name+"</td>";
                    cell4 = "<td>"+"<input type='checkbox' name='myCheck' class='selectCheckSupplier' value="+val.id+">"+"</td>";

                    newRow.html(cell1+cell2+cell3+cell4);
                    dataHandler.append(newRow);
                });
                $('.table-data').trigger('update'); //credit by HV
            } 
        });
        popupOnSupplier();
    });

    $("#searchSupplier").on("keyup", function() {
        var name = $(this).val();
        if(name == "") name = "kosong";
        var dataHandler = $("#load-data-supplier");
        dataHandler.html("");

        $.ajax({
            url : "loadSupplierAjaxSearch/"+name,
            dataType: "json",
            async : false,
            cache : false,
            success :function(result){
                $.each(result,function(key,val){
                    var newRow = $("<tr>");
                    var cell1,cell2,cell3,cell4 = "";
                    cell1 = "<td>"+val.id+"</td>";
                    cell2 = "<td>"+val.supplier_code+"</td>";
                    cell3 = "<td>"+val.supplier_name+"</td>";
                    cell4 = "<td>"+"<input type='checkbox' name='myCheck' class='selectCheckSupplier' value="+val.id+">"+"</td>";

                    newRow.html(cell1+cell2+cell3+cell4);
                    dataHandler.append(newRow);
                });
                $('.table-data').trigger('update');
            }
        });
    });
    
    $(document).on("click","#pilihCustomer",function(){
        var dataHandler = $("#load-data-customer");
        $.ajax({
            url : "loadCustomerAjax",
            dataType: "json",
            success :function(result){
                $.each(result,function(key,val){
                    
                    var newRow = $("<tr>");
                    var cell1,cell2,cell3,cell4 = "";
                    cell1 = "<td>"+val.id+"</td>";
                    cell2 = "<td>"+val.customer_code+"</td>";
                    cell3 = "<td>"+val.customer_name+"</td>";
                    cell4 = "<td>"+"<input type='checkbox' name='myCheck' class='selectCheckCustomer' value="+val.id+">"+"</td>";

                    newRow.html(cell1+cell2+cell3+cell4);
                    dataHandler.append(newRow);
                });
                $('.table-data').trigger('update');
            } 
        });
        popupOnSupplier();
    });

    $(document).on("click","#pilihReturan",function(){
        var dataHandler = $("#load-data-penjualan");
        $.ajax({
            url : "loadPenjualanAjax",
            dataType: "json",
            success :function(result){
                // console.log(result);
                $.each(result,function(key,val){
                    var newRow = $("<tr>");
                    var cell1,cell2,cell3,cell4 = "";
                    cell1 = "<td>"+val.id+"</td>";
                    cell2 = "<td>"+val.no_nota+"</td>";
                    cell3 = "<td>"+val.customer.customer_name+"</td>";
                    cell4 = "<td>"+"<input type='checkbox' name='myCheck' class='selectCheckPenjualan' value="+val.id+">"+"</td>";

                    for(var i = 0 ; i < selectedItemCode.length ; i++){
                        if(selectedItemCode[i] == val.id){
                            cell4 = "<td>"+"<input type='checkbox' checked name='myCheck' class='selectCheckPenjualan' value="+val.id+">"+"</td>";
                        }
                    }
                    newRow.html(cell1+cell2+cell3+cell4);
                    dataHandler.append(newRow);
                });
                $('.table-data').trigger('update');
            } 
        });
        popupOnSupplier();
    });

    $("#searchCustomer").on("keyup", function() {
        var name = $(this).val();
        searchOnTable("#load-data-customer",name);
            //dataHandler.html("");

        /*$.ajax({
            url : "loadCustomerAjaxSearch/"+name,
            dataType: "json",
            async : false,
            cache : false,
            success :function(result){
                $.each(result,function(key,val){
                    var newRow = $("<tr>");
                    var cell1,cell2,cell3,cell4 = "";
                    cell1 = "<td>"+val.id+"</td>";
                    cell2 = "<td>"+val.customer_code+"</td>";
                    cell3 = "<td>"+val.customer_name+"</td>";
                    cell4 = "<td>"+"<input type='checkbox' name='myCheck' class='selectCheckCustomer' value="+val.id+">"+"</td>";

                    newRow.html(cell1+cell2+cell3+cell4);
                    dataHandler.append(newRow);
                });
            }
        });*/
    });

    $("#searchPenjualan").on("keyup", function() {
        var name = $(this).val();
        searchOnTable("#load-data-penjualan",name);
        // if(name == "") name = "kosong";
        // var dataHandler = $("#load-data-penjualan");
        // dataHandler.html("");

        // $.ajax({
        //     url : "loadPenjualanAjaxSearch/"+name,
        //     dataType: "json",
        //     async : false,
        //     cache : false,
        //     success :function(result){
        //         console.log(result);
        //         $.each(result,function(key,val){
        //             var newRow = $("<tr>");
        //             var cell1,cell2,cell3,cell4 = "";
        //             cell1 = "<td>"+val.id+"</td>";
        //             cell2 = "<td>"+val.no_nota+"</td>";
        //             cell3 = "<td>"+val.customer.customer_name+"</td>";
        //             cell4 = "<td>"+"<input type='checkbox' name='myCheck' class='selectCheckPenjualan' value="+val.id+">"+"</td>";

        //             for(var i = 0 ; i < selectedItemCode.length ; i++){
        //                 if(selectedItemCode[i] == val.id){
        //                     cell4 = "<td>"+"<input type='checkbox' checked name='myCheck' class='selectCheckPenjualan' value="+val.id+">"+"</td>";
        //                 }
        //             }

        //             newRow.html(cell1+cell2+cell3+cell4);
        //             dataHandler.append(newRow);
        //         });
        //     }
        // });
    });

    $("#searchLog").on("keyup", function() {
        var name = $(this).val();
        searchOnTable("#load-data-log",name);
        
    });
    
});

function a(){
    var dataHandler = $("#load-data-pembelian");
        $.ajax({
            url : "penjualanDetailAjax/"+$('.penjualanDetail').val(), //salah
            dataType: "json",
            success :function(result){
                var header,table,headRow,head1,head2,head3 = "";
                header = "<h2>rincian Penjualan</h2>";

                var orderArrayHeader = ["id barang","nama barang","kuantitas penjualan"];

                var table = document.createElement('table');
                table.className = "table-data";
                table.setAttribute('border', '1');
                table.setAttribute('class', 'popupTable');
                var trhead = document.createElement('tr');
                var thead = document.createElement('thead');
                var tbody = document.createElement('tbody');
                tbody.setAttribute('id','load-data-pembelian-detail');

                thead.appendChild(trhead);
                table.appendChild(thead);
                table.appendChild(tbody);

                for(var i=0;i<orderArrayHeader.length;i++){
                    trhead.appendChild(document.createElement("th")).
                    appendChild(document.createTextNode(orderArrayHeader[i]));
                }
                dataHandler.append(header);
                dataHandler.append(table);

                $.each(result,function(key,val){
                    var newRow = $("<tr>");
                    var cell1,cell2,cell3 = "";
                    cell1 = "<td>"+val.item_id+"</td>";
                    cell2 = "<td>"+val.item_name+"</td>";
                    cell3 = "<td>"+val.selling_qty+"</td>";

                    newRow.html(cell1+cell2+cell3);
                    $("#load-data-pembelian-detail").append(newRow);
                });
            }
        });
        popupOnDetail();
}

function confirmStatus(id,status,menu){
    popupOnStatus();
    var dataHandler = $("#konfirmasi");
    var message,cell1,cell2,url = "";
    if(status == 0){
        message = "<p>Apakah anda ingin mengaktifkan data ini ?</p>";
    }else{
        message = "<p>Apakah anda ingin mengnon-aktifkan data ini ?</p>";
    }
    url = "doChange"+menu+"Status?id="+id;
    cell1 = "<a href="+url+"><button style='margin:13px 10px'>Ya</button></a>";
    cell2 = "<button style='margin:0px 10px' onclick='popupOff()'>Tidak</button>";

    dataHandler.html(message+cell1+cell2);
}

function confirmDelete(id,menu){
    popupOnDelete();
    var dataHandler = $("#hapus");
    var message,cell1,cell2,url = "";
    
    message = "<p>Apakah anda ingin menghapus data ini ?</p>";
    url = "doDelete"+menu+"?id="+id;
    cell1 = "<a href="+url+"><button style='margin:13px 10px'>Ya</button></a>";
    cell2 = "<button style='margin:0px 10px' onclick='popupOff()'>Tidak</button>";

    dataHandler.html(message+cell1+cell2);
}

function confirmArchive(menu){
    popupOnStatus();
    var dataHandler = $("#konfirmasi"),
        message = "<p>Data yang di arsip akan dihapus dan di simpan ke komputer anda ?</p>",
        from = $('input[name=searchFrom]').val() != "" ? $('input[name=searchFrom]').val() : "kosong",
        to = $('input[name=searchTo]').val() != "" ? $('input[name=searchTo]').val() : "kosong",
        downloadUrl = menu+"Pdf/"+from+"/"+to,
        // deleteMenuUrl = "'delete"+menu+"Archive/"+from+"/"+to+"'", //not used
        // deleteMenuUrl2 = "delete"+menu+"Archive/"+from+"/"+to,
        // deleteMenuArchive = "window.location.href="+deleteMenuUrl, //not used
        // delaySecond = setTimeout(function(){ window.location.replace(""+deleteMenuUrl2); }, 3000),
        runFunction = "runArchive('"+menu+"')",
        cell1 = "<a href="+downloadUrl+" target='_blank' onclick="+runFunction+"><button style='margin:13px 10px'>Ya</button></a>",
        cell2 = "<button style='margin:0px 10px' onclick='popupOff()'>Tidak</button>";

    dataHandler.html(message+cell1+cell2);
}

function runArchive(menu){
    var from = $('input[name=searchFrom]').val() != "" ? $('input[name=searchFrom]').val() : "kosong",
    to = $('input[name=searchTo]').val() != "" ? $('input[name=searchTo]').val() : "kosong",
    deleteMenuUrl = "delete"+menu+"Archive/"+from+"/"+to;
        
    setTimeout(function(){ window.location.replace(""+deleteMenuUrl); }, 3000);
}

function addBarang(){

    if(typeof currSupplierId === 'undefined') currSupplierId = 0;
    var dataHandler = $("#load-data");
    $.ajax({
        // url : "loadItemAjax/"+currSupplierId,
        url : "loadItemAjax/"+0,
        dataType: "json",
        success :function(result){
            $.each(result,function(key,val){
                var newRow = $("<tr>");
                var cell1,cell1to2,cell2,cell3,cell4 = "";
                cell1 = "<td>"+val.id+"</td>";
                cell1to2 = "<td>"+val.item_code+"</td>";;
                cell2 = "<td>"+val.item_name+"</td>";
                cell3 = "<td>"+val.item_qty+"</td>";
                var tamp = "roundedOne"+key;
                // cell4 = "<td>"+"<input type='checkbox' name='myCheck' class='selectCheck' value="+val.id+">"+"</td>";
                cell4 = "<td><div class='roundedOne'><input value="+val.id+" type='checkbox' class='selectCheck' id="+tamp+" name='myCheck' /><label for="+tamp+"></label></div></td>";

                // if(typeof selectedItemCode[key] !== 'undefined'){
                // } //isset in javascript
                for(var i = 0 ; i < selectedItemCode.length ; i++){
                    if(selectedItemCode[i] == val.id){
                        cell4 = "<td><div class='roundedOne'><input checked value="+val.id+" type='checkbox' class='selectCheck' id="+tamp+" name='myCheck' /><label for="+tamp+"></label></div></td>";
                    }
                }
                
                newRow.html(cell1+cell1to2+cell2+cell3+cell4);
                dataHandler.append(newRow);
            });
            // console.log(result);
            $('.table-data').trigger('update');
        } 
    });
    popupOn();
}

// $(document).on('click','.selectCheckCustomer', function(){
//     var selectedValue = $(this).val();
//     // $('#pilihCustomer').remove();

//     $.ajax({
//         url : "loadCustomerAjax",
//         dataType: "json",
//         success :function(result){
//             var dataHandler = $("#selectedCustomer");
//             $.each(result,function(key,val){
//                 var cell1,cell2,cell3,cell4,hiddenValueId = "";

//                 if(val.id == selectedValue){
//                     cell1 = "<td>Nama Customer</td>";
//                     cell3 = ""; cell4 = "";

//                     if($('#menu-pembelian').length || $('#menu-penjualan').length){ //cek jika id exists
//                         cell3 = "<td colspan='2'><button type='button' id='btnAddBarang' onclick='addBarang()'>tambah Barang</button></td>";
//                         $("#buttonAddBarang").html(cell3);
//                     }else if($('#menu-update-penjualan').length){
//                         //untuk menu update penjualan
//                         cell4 = "<i class='fa fa-times-circle fa-lg remove-item' onclick='removeCustomer()' aria-hidden='true'></i>";
//                         $('#btnCustomer').remove();
//                     }


//                     cell2 = "<td>"+val.customer_name+cell4+"</td>";
                    
//                     hiddenValueId = "<input type='hidden' id='customerId' name='customerId' value="+val.id+">";

//                     dataHandler.html(cell1+cell2+hiddenValueId);

//                     popupOff();
                    
//                 }
                
//             });
//             // console.log(result);
//         } 
//     });
// });

$(document).on('click','.selectCheckCustomer', function(){
    var selectedValue = $(this).val();
    // $('#pilihCustomer').remove();

    $.ajax({
        url : "loadCustomerAjax",
        dataType: "json",
        success :function(result){
            var dataHandler = $("#selectedCustomer1");
            $.each(result,function(key,val){
                var cell1,cell2,cell3,cell4,hiddenValueId = "";

                if(val.id == selectedValue){
                    cell1 = ""; cell3 = ""; cell4 = "";

                    if($('#menu-pembelian').length || $('#menu-penjualan').length){ //cek jika id exists
                        cell3 = "<td colspan='2'><button type='button' id='btnAddBarang' onclick='addBarang()'>tambah Barang</button></td>";
                        $("#buttonAddBarang").html(cell3);
                    }else if($('#menu-update-penjualan').length){
                        //untuk menu update penjualan
                        cell4 = "<i class='fa fa-times-circle fa-lg remove-item' onclick='removeCustomer()' aria-hidden='true'></i>";
                        $('#btnCustomer').remove();
                    }


                    cell2 = val.customer_name+cell4;

                    
                    if($('#menu-update-penjualan').length){
                        dataHandler = $("#selectedCustomer");
                        cell1 = "<td>nama customer</td>";
                        cell2 = "<td>"+val.customer_name+cell4+"</td>";
                        // dataHandler.html();
                    }
                    
                    hiddenValueId = "<input type='hidden' id='customerId' name='customerId' value="+val.id+">";

                    dataHandler.html(cell1+cell2+hiddenValueId);

                    popupOff();
                    
                }
                
            });
            // console.log(result);
        } 
    });
});

$(document).on('click','.selectCheckPenjualan', function(){
    var selectedValue = $(this).val();
    var elems = document.getElementsByName("selected_no");

    var flag = 1;
    for (var i = 0; i < selectedItemCode.length; i++) {
        if(selectedItemCode[i] == $(this).val()){
            flag = 0;
        }
    }

    if(flag == 1){
        if ($('#currno').text().length != 0) $('#currno').append(',');
        $('#currno').append($(this).val());
        selectedItemCode.push($(this).val());
        for(var j = 0; j < elems.length ; j++){
            elems[j].value = $('#currno').text();
        }
    }

    popupOff();
});


// $(document).on('click','.selectCheckSupplier', function(){
//     var selectedValue = $(this).val();
//     // $('#pilihSupplier').remove();

//     $.ajax({
//         url : "loadSupplierAjax",
//         dataType: "json",
//         success :function(result){
//             var dataHandler = $("#selectedSupplier");
//             $.each(result,function(key,val){
//                 var cell1,cell2,cell3,hiddenValueId = "";

//                 if(val.id == selectedValue){
//                     cell1 = "<td>Nama Supplier</td>";
//                     cell3 = "";

//                     if($('#menu-pembelian').length){ //cek jika id exists
//                         cell3 = "<td colspan='2'><button type='button' id='btnAddBarang' onclick='addBarang()'>tambah Barang</button></td>";
//                         $("#buttonAddBarang").html(cell3);
//                     }
//                     cell2 = "<td>"+val.supplier_name+"</td>";
                    
//                     hiddenValueId = "<input type='hidden' id='supplierId' name='supplierId' value="+val.id+">";

//                     dataHandler.html(cell1+cell2+hiddenValueId);

//                     popupOff();
                   
//                     currSupplierId = $('#supplierId').val();

//                     $("#selectedItem").children().remove()
//                     selectedItemCode = [];
//                 }
                
//             });
//             // console.log(result);
//         } 
//     });
// });

$(document).on('click','.selectCheckSupplier', function(){
    var selectedValue = $(this).val();
    // $('#pilihSupplier').remove();

    $.ajax({
        url : "loadSupplierAjax",
        dataType: "json",
        success :function(result){
            var dataHandler = $("#selectedSupplier1");
            $.each(result,function(key,val){
                var cell1,cell2,cell3,hiddenValueId,hiddenValueSupId = "";

                if(val.id == selectedValue){
                    cell3 = "";

                    if($('#menu-pembelian').length){ //cek jika id exists
                        cell3 = "<td colspan='2'><button type='button' id='btnAddBarang' onclick='addBarang()'>tambah Barang</button></td>";
                        $("#buttonAddBarang").html(cell3);
                    }else if($('#menu-update-pembelian').length){
                        //untuk menu update penjualan
                        cell4 = "<i class='fa fa-times-circle fa-lg remove-item' onclick='removeSupplier()' aria-hidden='true'></i>";
                        $('#pilihSupplier').remove();
                    }
                    cell2 = val.supplier_name;
                    
                    hiddenValueId = "<input type='hidden' id='supplierId' name='supplierId' value="+val.id+">";

                    dataHandler.html(cell2+hiddenValueId);

                    if($('#menu-update-pembelian').length){
                        dataHandler = $("#selectedSupplier");
                        cell1 = "<td>nama supplier</td>";
                        cell2 = "<td>"+val.supplier_name+cell4+"</td>";
                        hiddenValueSupId = "<input type='hidden' name='supplierId' id='currSupplierId' value="+val.id+">";
                        dataHandler.html(cell1+cell2+hiddenValueSupId);
                    }

                    popupOff();
                   
                    currSupplierId = $('#supplierId').val();

                    // $("#selectedItem").children().remove();
                    selectedItemCode = [];
                }
                
            });
            // console.log(result);
        } 
    });
});


$(document).on('click','.selectCheck', function(){
    //ketika barang di pilih

    // alert($(".selectRadio").index(this)); //ambil posisi index dari radio
    //$('input[name=myRadio]:checked').val() //ambil value index dari radio
    //alert($(this).val()); //ambil value dari class yg di pilih
    // alert($('input[name=myCheck]').index($(this)).attr("dicek",1));

    var selectedValue = $(this).val();
    if(!$('input[name=myCheck]').is( ":checked")){
        $(this).prop('checked',true);
    }else{
        $.ajax({
            // url : "loadItemAjax/"+currSupplierId,
            url : "loadItemAjax/"+0,
            dataType: "json",
            success :function(result){
                var dataHandler = $("#selectedItem");
                $.each(result,function(key,val){
                    var newRow = $("<tr>");
                    var cell0,cell1,cell2,cell3,cell4,cell5,currValue,hiddenValueId,hiddenValueName,currItemId,currItemName,currItemNameValue = "";

                    if(val.id == selectedValue){
                        var currTotalQty = "totalQty"+val.id;
                        cell0 = "<td>"+val.id+"</td>";
                        cell1 = "<td>"+val.item_code+"</td>";
                        cell2 = "<td>"+val.item_name+"</td>";
                        cell3 = "<td class="+currTotalQty+">"+val.item_qty+"</td>";

                        currValue = "qtyBeli"+val.id;
                        cell4 = "<td>"+"<input type='number' min='1' name="+currValue+" class='qtyBeli' required>"+"</td>";
                        
                        currItemId = "cekBarang"+val.id;
                        hiddenValueId = "<input type='hidden' name="+currItemId+" id='itemId' value="+val.id+">";

                        currItemName = "namaBarang"+val.id;
                        currItemNameValue = " value='"+val.item_name+"'";
                        hiddenValueName = "<input type='hidden' name="+currItemName+""+currItemNameValue+">";

                        if($('#menu-update-pembelian').length || $('#menu-update-penjualan').length){
                            cell5 = "<td>"+"<i class='fa fa-times-circle fa-2x remove-item' aria-hidden='true'></i>"+"</td>"
                            newRow.html(hiddenValueName+hiddenValueId+cell0+cell2+cell3+cell4+cell5);
                        }else{
                            cell5 = "<td>"+"<i class='fa fa-times-circle fa-2x remove-item' aria-hidden='true'></i>"+"</td>"
                            newRow.html(hiddenValueName+hiddenValueId+cell0+cell1+cell2+cell3+cell4+cell5);
                        }



                        var flag = 1;
                        for (var i = 0; i < selectedItemCode.length; i++) {
                            if(selectedItemCode[i] == val.id){
                                flag = 0;
                            }
                        }

                        if(flag == 1){
                            dataHandler.append(newRow);
                            selectedItemCode.push(val.id);
                        }

                        jQuery('input[type=number]').keyup(function () { 
                            this.value = this.value.replace(/[^0-9\.]/g,'');
                        });
                        
                        // $('.bg-red').css({"background-color":"red"});
                        popupOff();
                    }
                    
                });
                // console.log(result);
            } 
        });
    }
    
});

function pilihCustomer() {
    var dataHandler = $("#load-data-customer");
    $.ajax({
        url : "loadCustomerAjax",
        dataType: "json",
        success :function(result){
            $.each(result,function(key,val){
                
                var newRow = $("<tr>");
                var cell1,cell2,cell3,cell4 = "";
                cell1 = "<td>"+val.id+"</td>";
                cell2 = "<td>"+val.customer_code+"</td>";
                cell3 = "<td>"+val.customer_name+"</td>";
                cell4 = "<td>"+"<input type='checkbox' name='myCheck' class='selectCheckCustomer' value="+val.id+">"+"</td>";

                newRow.html(cell1+cell2+cell3+cell4);
                dataHandler.append(newRow);
            });
        } 
    });
    popupOnSupplier();
}

function removeCustomer(){ //ini di menu edit penjualan
    $("#selectedCustomer").remove();

    var newRow = $("<tr id='customer-row'>");
    var cell1 = "<td>"+"<button id='btnCustomer' onclick='pilihCustomer()' type='button'>Pilih Customer</button>"+"</td>";
    newRow.append(cell1);
    $("#table-penjualan-customer").append(newRow);

    var tr = document.createElement('tr');
    tr.setAttribute('id','selectedCustomer');
    $("#table-penjualan-customer").append(tr);
}

function removeSupplier(){ //ini di menu edit pembelian
    $("#selectedSupplier").remove();

    var newRow = $("<tr id='supplier-row'>");
    var cell1 = "<td>"+"<button id='pilihSupplier' type='button'>Pilih supplier</button>"+"</td>";
    newRow.append(cell1);
    $("#table-pembelian-supplier").append(newRow);

    var tr = document.createElement('tr');
    tr.setAttribute('id','selectedSupplier');
    $("#table-pembelian-supplier").append(tr);
}

function popupOn(){
    $('#light').css('display', 'block');
    $('#fade').css('display', 'block');
}

function popupOnSupplier(){
    $('#lightSup').css('display', 'block');
    $('#fadeSup').css('display', 'block');
}

function popupOnStatus(){
    $('#light2').css('display', 'block');
    $('#fade2').css('display', 'block');
}

function popupOnDelete(){
    $('#lightDel').css('display', 'block');
    $('#fadeDel').css('display', 'block');
}

function popupOnDetail(){
    $('#light3').css('display', 'block');
    $('#fade3').css('display', 'block');
}

$("#fade,#fade2,#fade3,#fadeSup,#fadeDel").click( function(){
    popupOff();
});

function popupOff(){
    $('#light').css('display', 'none');
    $('#fade').css('display', 'none');

    $('#lightDel').css('display', 'none');
    $('#fadeDel').css('display', 'none');
    
    $('#lightSup').css('display', 'none');
    $('#fadeSup').css('display', 'none');

    $('#light2').css('display', 'none');
    $('#fade2').css('display', 'none');

    $('#light3').css('display', 'none');
    $('#fade3').css('display', 'none');

    $("#load-data-supplier").html("");
    $("#load-data-pic").html(""); 
    $("#load-data-pembelian").html(""); 
    $("#load-data").html("");
    $("#konfirmasi").html("");
    $("#searchData").val("");
    $("#load-data-customer").html("");
    $("#load-data-penjualan").html("");
    $("#load-data-returan").html("");


    if($('#menu-customer').length || $('#menu-supplier').length){
        $("input[type=text]").val('');
        $("input[type=number]").val('');
        $("input[type=email]").val('');
        $("textarea").val('');
    }
    
}

