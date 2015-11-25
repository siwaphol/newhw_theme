<!-- Inline form modal -->
<div id="semester_year_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title">Semester and Year configuration <a id="refresh_sem_year"><i class="icon icon-spinner11"></i></a></h5>
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
                    <button type="button" class="btn btn-primary" id="">Change</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /inline form modal -->

<script>
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

    $('#refresh_sem_year').click(function (event) {
        event.preventDefault();
        $('#year_select').selectpicker('refresh');
    });

    $('#year_select').change(function () {
        $( "#year_select option:selected" ).each(function() {
            removeSemester($( this ).val());
            $('#semester_select').selectpicker('refresh');
        });
    });
</script>