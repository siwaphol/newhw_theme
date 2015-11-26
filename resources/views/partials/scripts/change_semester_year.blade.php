@if(!\Auth::guest())
<!-- Inline form modal -->
<div id="semester_year_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title">Semester and Year configuration</h5>
            </div>

            <form action="#" class="form-inline">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sel1">Year</label>
                        <select class="form-control" id="year_select">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sel1">Semester</label>
                        <select class="form-control" id="semester_select">
                            <option id="option_sem_1" value="1">1</option>
                            <option id="option_sem_2" value="2">2</option>
                            <option id="option_sem_3" value="3">3</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="semester_year_change_btn">Change  <img src="{{asset('images/spinner.gif')}}" alt="" class="hidden" id="modal-spinner"></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /inline form modal -->

<script>
    $(function () {
        var semester_year_json = null;
        var current_semester = '{{\Session::get('semester')}}';
        var current_year = '{{\Session::get('year')}}';
        $.getJSON('{{url('/api/v1/semesters_and_years')}}', function (json) {
            semester_year_json = json;
            $('#year_select').empty();
            for(var i=0; i<json.years.length; i++){
                $('#year_select').append('<option value="' +json.years[i]+'">'+json.years[i]+'</option>');
            }

            removeSemester(current_year);
        });

        function removeSemester(year){
            var all_semesters = ['1','2','3'];
            var temp = semester_year_json.data[year];
            // Init hidden to all semester
            for(var i=0; i<all_semesters.length; i++){
                var $option_semester = $('#option_sem_' + all_semesters[i]);
                $option_semester.addClass('hidden');
            }
            // Remove item which exists in semester of that year
            for(i=0; i<temp.length; i++){
                var $option_semester2 = $('#option_sem_' + temp[i]);
                $option_semester2.removeClass('hidden');
            }
        }

        $('#change_sem_year').click(function (event) {
            event.preventDefault();

            $('#year_select').selectpicker('refresh');
            $('#year_select').selectpicker('val', current_year);
            $('#semester_select').selectpicker('refresh');
            $('#semester_select').selectpicker('val', current_semester);

            $('#semester_year_modal').modal();
        });

        $('#year_select').change(function () {
            $( "#year_select option:selected" ).each(function() {
                removeSemester($( this ).val());
                // Get first option that are not hidden
                if($('#semester_select option:not(.hidden):first').length > 0){
                    $('#semester_select').selectpicker('val',$('#semester_select option:not(.hidden):first').val());
                    $('#semester_select').selectpicker('refresh');
                }
            });
        });

        $('#semester_year_change_btn').click(function () {
            var selected_semester = $('#semester_select').val();
            var selected_year = $('#year_select').val();
            var token = $('meta[name="csrf-token"]').attr('content');

            if(current_semester !== selected_semester || current_year !== selected_year){
                $.ajax({
                    type: "POST",
                    url:'{{url('/api/v1/semesters_and_years/edit')}}',
                    data: {_token:token ,semester:selected_semester, year:selected_year},
                    beforeSend: function () {
                        $('#modal-spinner').removeClass('hidden');
                    }
                })
                .done(function (data) {
                    if(data==='success'){
                        location.reload();
                    }
                })
                .fail(function (data) {
                    console.log(data);
                    alert('There was an error please see console.log for more details.');
                })
                .always(function () {
                    $('#modal-spinner').addClass('hidden');
                });
            }
        });
    });
</script>
@endif