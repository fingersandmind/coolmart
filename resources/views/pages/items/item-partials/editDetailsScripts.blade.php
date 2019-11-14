<script>
    $('#add').on('click', add);
    $('#remove').on('click', remove);

    var index = {{ $index_desc }};
    var limit = 10;

    function add() {
        if(index <= limit)
        {
            index ++;
            var name_input = '<input type="text" id="name_'+index+'" class="form-control" name="names[]" minlength="2" maxlength="50" placeholder="Name" required>';
            // var name_label = '<label id="lname_'+index+'" class="form-label">Name</label>';
            var desc_input = '<div class="justify-content-between d-flex"><input id="desc_'+index+'" type="text" class="form-control" name="descriptions[]" minlength="2" maxlength="100" placeholder="Description" required><button id="removeCol" onclick="javascript:removeColumn('+index+');"type="button" class="btn btn-danger btn_'+index+'"><i class="fa fa-trash"></i></button></div>';
            
            $('#name_input').append(name_input);
            $('#desc_input').append(desc_input);
        }
    }

    function remove() {
        var last_index = index;

        if(last_index > 1) {
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
        if(col > 1 )
        {
            $('#name_' + col).remove();
            // $('#lname_' + col).remove();
            $('#desc_' + col).remove();
            // $('#ldesc_' + col).remove();
            $('.btn_' + col).remove();
        }
    }
</script>