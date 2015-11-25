<script>
var semester_year_json = null;
$('#change_sem_year').click(function (event) {
    event.preventDefault();
    $.getJSON('{{url('/api/v1/semesters_and_years')}}', function (json) {
        semester_year_json = json;
        console.log(json);
    });
    $('#select_test1').selectpicker();
    $('#select_test2').selectpicker();
    $('#semester_year_modal').modal();
});
</script>

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
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sel1">Semester</label>
                        <select class="form-control" id="semester_select" disabled>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
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