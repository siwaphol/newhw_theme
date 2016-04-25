<div class="modal fade" style="overflow-y: scroll;" id="addFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="js-title-step"></h4>
            </div>
            <div class="modal-body">
                {{-------------Start of modal step 1------------------}}
                <div class="row hide" data-step="1" data-title="Add new homework">
                    <div class="well">
                        <form class="form-horizontal addFileForm" role="form">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="homeworkname">Name<i
                                            style="color: red;">*</i></label>

                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="homeworkname" id="homeworkname"
                                               placeholder="Ex. lab01_{id} ,{id}_lab01_1">
                                        <span class="input-group-addon"
                                              id="homework-ext-label">no extension selected</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group file-type-select">
                                <label class="control-label col-sm-2" for="section">File Type<i style="color: red;">*</i></label>
                                <div class="col-sm-8">
                                    <select id="filetype-list">
                                        @foreach($filetype_list as $a_file_type)
                                            <option value="{{$a_file_type->id}}">{{$a_file_type->extension}}</option>
                                        @endforeach
                                        <option value="newfiletype">others...</option>
                                    </select>
                                    <input type="text" class="form-control hidden" id="extension" name="extension">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="filedetail">Detail</label>

                                <div class="col-sm-8">
                                    <textarea style="resize:none" class="form-control" name="filedetail" id="filedetail"
                                              rows="3" placeholder="Enter file detail" required></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-------------End of modal step 1------------------}}
                {{-------------Start of modal step 2------------------}}
                <div class="row hide" data-step="2" data-title="Select section for this homework">
                    <div class="well">
                        <form class="form-horizontal addFileForm-selected-section" role="form">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="section">Section<i style="color: red;">*</i></label>

                                <div class="col-sm-8 clsAboveDatePicker">
                                    <select id="section-list" multiple="multiple">
                                        @foreach($section_list as $section)
                                            <option value="{{$section->section}}">Section {{$section->section}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div id="errorDisplay" class="alert alert-danger hidden">
                                <strong>Error</strong><br>
                                <ul>

                                </ul>
                            </div>

                            <div id="sectionTimeDatePicker" class="sectionRemovable">

                            </div>

                        </form>
                    </div>
                </div>
                {{-------------End of modal step 2------------------}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default js-btn-step pull-left" data-orientation="cancel"
                        data-dismiss="modal"></button>
                <button type="button" class="btn btn-warning js-btn-step" data-orientation="previous"></button>
                <button type="button" class="btn btn-success js-btn-step" data-orientation="next"></button>
                {{--<button type="button" class="btn btn-success" id="DTcaller" data-dismiss="modal">Test button</button>--}}
            </div>
        </div>
    </div>
</div>

@include('partials.datetimepickermodal')

<script>

</script>
<script type="text/javascript">
    $(document).ready(function () {

        //starttest
        var changingTxt = "";

        $('#dtpicker_modal').datetimepicker({
            inline: true,
            sideBySide: true,
            locale: 'en',
            format: 'DD/MM/YYYY HH:mm',
            defaultDate: moment("23:59:00", "hh:mm:ss")
        });
        function changeCurrentDateText(cText,sec_num) {
            changingTxt = cText+sec_num;
            //init minDate and maxDate
            $('#dtpicker_modal').data("DateTimePicker").minDate(false);
            $('#dtpicker_modal').data("DateTimePicker").maxDate(false);
            //check linked date
            if(cText === '#dueDate'){
                if($.trim($('#acceptUntil'+sec_num).val()).length > 0){
                    $('#dtpicker_modal').data("DateTimePicker").maxDate(moment($('#acceptUntil'+sec_num).val(),'DD/MM/YYYY HH:mm'));
                }else{
                    $('#dtpicker_modal').data("DateTimePicker").maxDate(false);
                }
            }else if(cText == '#acceptUntil'){
                if($.trim($('#dueDate'+sec_num).val()).length > 0){
                    $('#dtpicker_modal').data("DateTimePicker").minDate(moment($('#dueDate'+sec_num).val(),'DD/MM/YYYY HH:mm'));
                }else{
                    $('#dtpicker_modal').data("DateTimePicker").minDate(false);
                }
            }

            if ($.trim($(changingTxt).val()).length > 0) {
                $('#dtpicker_modal').data("DateTimePicker").date(moment("23:59:59", "hh:mm:ss"));
            } else {
                $('#dtpicker_modal').data("DateTimePicker").date($(changingTxt).val());
            }
            $('#dateTimePickerModal').modal('toggle');
        }

        function checkErrorBeforeModalStepComplete() {
            $('#errorDisplay ul').empty();
            var hasError = false;

            //check second wizard for datetimepicker
            $('#sectionTimeDatePicker input').each(function () {
                var current_input_id_value = $(this).attr('data-message');
                if ($.trim($(this).val()).length === 0) {
                    hasError = true;
                    $('#errorDisplay').removeClass('hidden');
                    $('#errorDisplay ul').append('<li>'+ current_input_id_value +' cannot be empty.</li>');
                    //input should be in format of asdaffddfdf
                } else if (!moment($(this).val(), 'DD/MM/YYYY HH:mm', true).isValid() || $.trim($(this).val()).length > 16) {
                    hasError = true;
                    $('#errorDisplay ul').append('<li>'+current_input_id_value+' incorrect format (DD/MM/YYYY HH:mm).</li>');
                    //date input is incorrect
                }
            });

            return hasError;
        }

        // function removeA(arr) {
        //     var what, a = arguments, L = a.length, ax;
        //     while (L > 1 && arr.length) {
        //         what = a[--L];
        //         while ((ax= arr.indexOf(what)) !== -1) {
        //             arr.splice(ax, 1);
        //         }
        //     }
        //     return arr;
        // }

        function getSectionInputString(section_text){

            return "" +
                    "<div class='panel panel-info section" + section_text + "' id='section-panel'>" +
                    "<div class='panel-heading'>" +
                    "Section " + section_text +
                    "</div>" +
                    "<div class='panel-body'>" +
                    "<div class='form-group section" + section_text + "'>" +
                    "  <label class='control-label col-sm-3' style='text-align: left;' for='dueDate" + section_text + "'>Due Date</label>" +
                    "  <div class='col-sm-6 input-group date clsDatePicker'>" +
                    "    <input type='text' class='form-control' name='dueDate" + section_text + "' id='dueDate" + section_text + "' data-message='section "+ section_text +"&#39;due date '/>" +
                    "    <span class='input-group-addon' id='btn_due_date" + section_text + "'>" +
                    "      <span class='glyphicon glyphicon-calendar'></span>" +
                    "    </span>" +
                    "  </div>" +
                    "</div>" +
                    "<div class='form-group section" + section_text + "'>" +
                    "  <label class='control-label col-sm-3' style='text-align: left;' for='acceptUntil" + section_text + "'>Accept Until</label>" +
                    "  <div class='col-sm-6 input-group date clsDatePicker'>" +
                    "    <input type='text' class='form-control' name='acceptUntil" + section_text + "' id='acceptUntil" + section_text + "' data-message='section "+ section_text +"&#39;accept until '/>" +
                    "    <span class='input-group-addon' id='btn_accept_date" + section_text + "'>" +
                    "      <span class='glyphicon glyphicon-calendar'></span>" +
                    "    </span>" +
                    "  </div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "";
        }

        $("#DT_OK_button").on("click", function () {
            $(changingTxt).val($('#dtpicker_modal').data("DateTimePicker").date().format("DD/MM/YYYY HH:mm"));
        });
        //endtest

        var baseUrl = "{{ url('/') }}";
        var baseHomeworkCreate = 'homework/create';
        var token = "{{ csrf_token() }}";
        var course_no = "{{$course_id}}";
        var selected_section_array = [];

        $('#addFileModal').modalSteps({
            completeCallback: function () {
                if(!checkErrorBeforeModalStepComplete()){
                    console.log($('.addFileForm').serialize()+'&'+$('.addFileForm-selected-section').serialize());
                    console.log(baseUrl+'/homework/create');
                    var mydata = $('.addFileForm').serialize()+'&'+$('.addFileForm-selected-section').serialize();
                    $.ajax({
                        type: "POST",
                        url: '/newHW/public/homework/create',
                        data: {aData: mydata, _token: token, course_no:course_no},
                        beforeSend: function(){
                            $('#section-panel > .panel-heading').each(function(){
                                $(this).append('<i class="fa fa-spinner fa-pulse"></i>');
                            });
                        },
                        success: function(data){
                            //nong in progress
                            console.log("success");
                            for (var i = 0; i < selected_section_array.length; i++) {
                                console.log(selected_section_array + ":" + data.status[selected_section_array[i]])
                            };
                            // console.log(data);
                            // for(var section_status in data.result) {
                            //     console.log(section_status);
                            // }
                            //end nong in progress
                            // console.log(data);
                            //if in production uncomment line under this line
                            // $('#addFileModal').modal('hide');
                        },
                        error: function(data){
                            console.log("error: " + data);
                        }
                    });
                }
                //$('#addFileModal').modal('hide');
            }
        });

        $('#section-list').multiselect({
            includeSelectAllOption: true,
            allSelectedText: 'All section selected',
            onChange: function (element, checked) {
                if (typeof element === 'undefined') {
                    if (checked === false) {
                        //remove an unselected section from section array
                        var index = selected_section_array.indexOf(element.val());
                        selected_section_array.splice(index, 1);

                        $('#sectionTimeDatePicker').empty();
                        $('#errorDisplay').addClass('hidden');
                    }
                } else {
                    if (checked === true) {
                        //push a section number to section array
                        console.log(element.val());
                        selected_section_array.push(element.val());

                        var this_section = "section" + element.val();
                        if (!$('.' + this_section)[0]) {
                            $('#sectionTimeDatePicker').append(getSectionInputString(element.val()));

                            var current_dbtn = "#btn_due_date" + element.val();
                            var current_abtn = "#btn_accept_date" + element.val();
                            var current_sec = element.val();
                            $(current_dbtn).on('click', function () {
                                changeCurrentDateText("#dueDate", current_sec);
                            });
                            $(current_abtn).on('click', function () {
                                changeCurrentDateText("#acceptUntil", current_sec);
                            });
                        }
                    }
                    else if (checked === false) {
                        var thisSection = ".section" + element.val();
                        $(thisSection).remove();
                        $('#errorDisplay').addClass('hidden');
                    }
                }
            },
            onSelectAll: function () {
                $('#section-list option').each(function () {
                    var this_section = "section" + $(this).val();
                    var index = selected_section_array.indexOf($(this).val());
                    //if an item is not in selected array
                    if(index !== -1){
                        selected_section_array.push($(this).val());
                    }
                    if (!$('.' + this_section)[0]) {
                        $('#sectionTimeDatePicker').append(getSectionInputString($(this).val()));

                        var current_dbtn = "#btn_due_date" + $(this).val();
                        var current_abtn = "#btn_accept_date" + $(this).val();
                        var current_sec = $(this).val();
                        $(current_dbtn).on('click', function () {
                            changeCurrentDateText("#dueDate", current_sec);
                        });
                        $(current_abtn).on('click', function () {
                            changeCurrentDateText("#acceptUntil", current_sec);
                        });
                    }
                });
            }
        });

        $('#filetype-list').multiselect({
            onChange: function (element, checked) {
                if (checked === true) {
                    if (element.val() === 'newfiletype') {
                        $('.file-type-select').after(''+
                        '<div class="form-group newfiletype"">'+
                            '<label class="control-label col-sm-2" for="newextension">Extension<i style="color: red;">*</i></label>' +
                            '<div class="col-sm-8">' +
                                '<input type="text" class="form-control" name="newextension" id="newextension" maxlength="20" placeholder="Ex. c, cpp (use comma for multiple extension)">' +
                            '</div>'+
                        '</div>');
                        $('#newextension').on('input', function () {
                            var trimed_text = $(this).val().replace(/ /g, '');
                            if (!trimed_text == '') {
                                //check if , is at the end of string
                                patt = /,$/g;
                                if (patt.test(trimed_text)) {
                                    trimed_text = trimed_text.substring(0, trimed_text.length - 1);
                                    trimed_text = trimed_text.replace(/,/g, ', .');
                                } else {
                                    trimed_text = trimed_text.replace(/,/g, ', .');
                                }

                                trimed_text = '.' + trimed_text;
                                trimed_text = trimed_text.toLowerCase();
                            }

                            $('#homework-ext-label').html(trimed_text);
                            $('#extension').val($('#homework-ext-label').html());
                        });
                        $('#homework-ext-label').html('');
                    } else {
                        $('.newfiletype').remove();

                        $('#homework-ext-label').html(element.html());
                        $('#extension').val(element.val());
                    }
                }
            }
        });

//        $('#newextension').on('input', function () {
//            var trimed_text = $(this).val().replace(/ /g, '');
//            if (!trimed_text == '') {
//                //check if , is at the end of string
//                patt = /,$/g;
//                if (patt.test(trimed_text)) {
//                    trimed_text = trimed_text.substring(0, trimed_text.length - 1);
//                    trimed_text = trimed_text.replace(/,/g, ', .');
//                } else {
//                    trimed_text = trimed_text.replace(/,/g, ', .');
//                }
//
//                trimed_text = '.' + trimed_text;
//                trimed_text = trimed_text.toLowerCase();
//            }
//
//            $('#homework-ext-label').html(trimed_text);
//        });
    });
</script>

