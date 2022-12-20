<script>
    var pipelines = [];
    var all_data =
        $(document).ready(function() {
            $('.loading').show();
            $.ajax({
                url: "<?php echo e(route($route . '.getdata', $id ?? null)); ?>",
                type: "GET",
                success: function(data) {
                    $('#show_data').html(data.data);
                    pipelines = data.pipelines;
                    autoSelect();
                    initSelect2();
                    $('.loading').hide();
                },
                error: function(data) {
                    // console.log(data);
                },
                complete: function() {
                    $('.loading').hide();
                }
            });

            $('body').on('submit', '#sync_setting_save_form', function(e) {

                e.preventDefault();
                $.each($('form select'), function(index, t) {
                    appendName(t);
                });
                var form = $(this);
                process_ajax_form(form.attr('action'), form[0], function() {
                    <?php if(is_null($id)): ?>
                        location.reload();
                    <?php endif; ?>
                }, form.attr('method'));

            });

            $('body').on('change', '#pipeline_id', function() {
                var pipeline_id = $(this).val();
                var pipeline_stages = pipelines.find(function(pipeline) {
                    return pipeline.id == pipeline_id;
                });
                // console.log(pipeline_stages.stages);
                var html = '';
                html += '<label for=""> Select Stage </label>';
                html += '<select name="pipeline_stage_id[]" id="pipeline_stage_id" class="form-control">';
                $.each(pipeline_stages.stages, function(key, value) {
                    // var last_stage = "check_field($pipelines, 'pipeline_stage_id') ";
                    // var selected = last_stage == value.id ? 'selected' : '';
                    var selected = '';
                    html += '<option value="' + value.id + '" ' + selected + '>' + value.name +
                        '</option>';
                });
                html += '</select>';
                $(this).closest('.card').find('.pipeline_stages').html(html);
            });

            //on change of any select put the text of that into its closest hidden element

            $('body').on('change', 'select', function() {

                appendName(this);
            });



            $('body').off('click', '#add_more');
            $('body').on('click', '#add_more', function() {
                //  removeInvalid();
                //clone the html of closest card of this
                var maincard = $(this).closest('.card');
                var html = maincard.clone();
                var allselect = html.find('select');

                $.each(maincard.find('select'), function(index, t) {
                    //auto-select
                    $(allselect[index]).val($(t).val());
                });
                html.find('#technician_id').attr('name', `technician_id[${$('.card').length}][]`);



                html.removeClass('main_data');
                html.find('.btn_remove').removeClass('d-none');
                //append the cloned html to card-box
                $('.appended_data').append(html);
                initSelect2();
                //remove the this button and put that after the last card
                /*
                on card remove
                */
            });

            $('body').on('click', '.btn_remove', function() {
                $(this).closest('.card').remove();
                setTimeout(() => {
                    $.each($('.technician_id'), function(index, t) {
                        $(t).attr('name', `technician_id[${index}][]`);
                    });
                }, 400);
            })

        })
</script>
<?php /**PATH F:\xampp\htdocs\ServiceTitans\Service-Titans\resources\views/admin/sync-settings/formscript.blade.php ENDPATH**/ ?>