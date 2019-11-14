<script>
    $('#add').on('click', add);
    $('#remove').on('click', remove);

    var index = 0;
    var limit = 10;

    function add() {
        if(index <= limit)
        {
            index ++;
            var name_input = '<input type="text" id="name_'+index+'" class="form-control" name="names[]" minlength="2" maxlength="30" placeholder="Name" required>';
            // var name_label = '<label id="lname_'+index+'" class="form-label">Name</label>';
            // var desc_input = '<input id="desc_'+index+'" type="text" class="form-control" name="descriptions[]" minlength="2" maxlength="40" placeholder="Description" required>';
            var desc_input = '<div class="justify-content-between d-flex"><input id="desc_'+index+'" type="text" class="form-control" name="descriptions[]" minlength="2" maxlength="80" placeholder="Description" required><button id="removeCol" onclick="javascript:removeColumn('+index+');"type="button" class="btn btn-danger btn_'+index+'"><i class="fa fa-trash"></i></button></div>';
            // var desc_label = '<label id="ldesc_'+index+'" class="form-label">Description</label>';
            
            // $('#name_input').append(name_label);
            $('#name_input').append(name_input);
            // $('#desc_input').append(desc_label);
            $('#desc_input').append(desc_input);
        }
    }

    function remove() {
        var last_index = index;

        if(last_index > 0) {
            $('#name_' + last_index).remove();
            // $('#lname_' + last_index).remove();
            $('#desc_' + last_index).remove();
            // $('#ldesc_' + last_index).remove();
            $('.btn_' + last_index).remove();
            index --;
        }
    }
    function removeColumn(col)
    {
        console.log(col);
        $('#name_' + col).remove();
        // $('#lname_' + col).remove();
        $('#desc_' + col).remove();
        // $('#ldesc_' + col).remove();
        $('.btn_' + col).remove();
    }
</script>