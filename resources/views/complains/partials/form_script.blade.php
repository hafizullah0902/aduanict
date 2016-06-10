<script type="text/javascript">

    $( document ).ready(function() {

        var servertime = parseFloat(($("#servertime").val())) * 1000;
        $("#clock").clock({"timestamp":servertime,
            "calendar":"false"});


        var bagi_pihak =$('#bagi_pihak:checked').val();
        if(bagi_pihak=='Y')
        {
            $('#hide_bagiPihak').show();
        }

        $( "#bagi_pihak" ).change(function() {

            if($(this).prop("checked"))
            {
                $('#hide_bagiPihak').show();
            }
            else
            {
                $('#hide_bagiPihak').hide();
            }

        });



        var complain_category_id = $("#complain_category_id").val();
        console.log(complain_category_id);
        show_hide_byCategory(complain_category_id);

        $( "#complain_category_id" ).change(function() {
            var complain_category_id = $(this).val();
            show_hide_byCategory(complain_category_id);

            $('#complain_source_id').val('');
            $('#complain_source_id').trigger("chosen:updated");

        });

        $( "#branch_id" ).change(function() {
            var branch_id = $(this).val();
            get_location_byBranch(branch_id);

        });

        $( "#lokasi_id" ).change(function() {
            var lokasi_id = $(this).val();
            get_asset_byLocation(lokasi_id);
        });

        function get_location_byBranch(branch_id)
        {
//                alert(branch_id);
            $.ajax({
                type: "GET",
                url: base_url + '/complain/locations',
                dataType:"json",
                data:
                {
                    branch_id : branch_id
                },
                beforeSend: function() {

                },
                success: function (location_data) {

//                        console.log(location_data);
                    $("#lokasi_id").empty();

                    $.each(location_data,function (key,value) {

                        $("#lokasi_id").append("<option value='"+ key + "'>" + value + "</option>");
                    });

                    $("#lokasi_id").val('');
                    $("#lokasi_id").trigger("chosen:updated");

                }
            });

        }

        function get_asset_byLocation(lokasi_id)
        {
//                alert(lokasi_id);
            $.ajax({
                type: "GET",
                url: base_url + '/complain/assets',
                dataType:"json",
                data:
                {
                    lokasi_id : lokasi_id
                },
                beforeSend: function() {

                },
                success: function (asset_data) {

                    $("#ict_no").empty();

                    $.each(asset_data,function (key,value) {

                        $("#ict_no").append("<option value='"+ key + "'>" + value + "</option>");
                    });

                    $("#ict_no").val('');
                    $("#ict_no").trigger("chosen:updated");


                }
            });

        }

        function show_hide_byCategory(complain_category_id) {

            if(!complain_category_id)
            {
                return;
            }

            var esp_complain_category_id = complain_category_id.split('-');

            complain_category_id= esp_complain_category_id[0];

            if(complain_category_id=='5'||complain_category_id=='6')
            {
                $('.hide_byCategory').hide();
            }
            else
            {
                $('.hide_byCategory').show();
            }
        }

    });

</script>