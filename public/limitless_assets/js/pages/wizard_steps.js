/* ------------------------------------------------------------------------------
*
*  # Steps wizard
*
*  Specific JS code additions for wizard_steps.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {

    var selectedSemester = null;
    var selectedYear = null;
    var tableLoaded = false;
    var oldSemesterYear = true;
    var secondStepFirstRun = false;

    function getSemester(){
        var temp;
        var splitArr = null;
        var lSemester = null;

        if(oldSemesterYear){
            temp = $("select[name='year-semester'] option:selected").val();
            splitArr = temp.split("-");
            lSemester = splitArr[1];
        }else{
            lSemester = $("select[name='new-semester'] option:selected").val();
        }
        return lSemester;
    }
    function getYear(){
        var temp;
        var splitArr = null;
        var lYear = null;

        if(oldSemesterYear){
            temp = $("select[name='year-semester'] option:selected").val();
            splitArr = temp.split("-");
            lYear = splitArr[0];
        }else{
            lYear = $("select[name='new-year'] option:selected").val();
        }
        return lYear;
    }
    // Wizard examples
    // ------------------------------

    // Basic wizard setup
    $(".steps-basic").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        titleTemplate: '<span class="number">#index#</span> #title#',
        labels: {
            finish: 'Submit'
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            var newSemester = getSemester();
            var newYear = getYear();

            if(newSemester !== selectedSemester || newYear !== selectedYear) {
                tableLoaded = false;
            }
            selectedSemester = newSemester;
            selectedYear = newYear;

            if(newIndex == 1 && !tableLoaded){
                if(secondStepFirstRun){
                    $('#course-section-list').dataTable().fnDestroy();
                }
                secondStepFirstRun = true;

                // show course and section list from autoajax1 before insert or update
                $('#course-section-list').DataTable({
                    "bDestroy": true,
                    "processing": true,
                    "scrollX": true,
                    "ajax": {
                        url: getAllCourseSectionURL,
                        data: {"semester": selectedSemester, "year": selectedYear}
                        ,error: function(data){
                            swal({
                                title: "เกิดข้อผิดพลาด",
                                text: "ข้อความผิดพลาดเพิ่มเติม",
                                confirmButtonColor: "#EF5350",
                                type: "error"
                            });
                            console.log(data);
                            tableLoaded = false;
                        }
                    },
                    "columns": [
                        { "data": "id"},
                        { "data": "name"},
                        { "data": "section"},
                        { "data": "teacher"
                            ,"render": function ( data, type, full, meta) {
                            return data.length==0?'<p style="color:red;">Not found</p>':(data.firstname_en+' '+data.lastname_en);
                        }},
                        { "data": "teacher"
                            ,"render": function ( data, type, full, meta) {
                            return data.length==0?'<p style="color:red;">Not found</p>':(data.firstname_th+' '+data.lastname_th);
                        }},
                        { "data": "teacher"
                            ,"render": function ( data, type, full, meta) {
                            // TODO-nong ใช้ตัวแปร full เพิ่ม id ให้กับแต่ละ row ของ column นี้เพื่อให้มี spinner เวลาส่งข้อมูลขึ้นแล้วเซฟลงดาต้าเบส ถ้าสำเร็จมี success span
                            return data.length==0?'<span class="label label-danger">Fail</span>':'';
                        }},
                        { "data": "teacher"
                            ,"render": function ( data, type, full, meta) {
                            // TODO-nong ถ้าสร้างไม่สำเร็จให้ขึ้นข้อความด้วย
                            return data.length==0?'No teacher found or only "Staff" found':'';
                        }}
                    ],
                    "init": function(){
                        alert('complete');
                    }
                })
                .on( 'init.dt', function () {
                    console.log( 'Table initialisation complete: '+new Date().getTime() );
                    tableLoaded = true;
                } );
            }

            if((newIndex == 2 || newIndex ==3) && !tableLoaded){
                swal({
                    title: "Please select correct semester and year",
                    text: "go back to first step and select semester and year again ",
                    confirmButtonColor: "#EF5350",
                    type: "error"
                });
                return false;
            }else{
                return true;
            }
        },
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        }
    });

    // We should insert click event listener after wizard render completely
    $('#new_ys').click(function () {
        $("select[name='year-semester']").prop('disabled', true);
        $("select[name='new-year']").prop('disabled', false);
        $("select[name='new-semester']").prop('disabled', false);
        oldSemesterYear=false;
    });
    $('#cancel_new_ys').click(function () {
        $("select[name='year-semester']").prop('disabled', false);
        $("select[name='new-year']").prop('disabled', true);
        $("select[name='new-semester']").prop('disabled', true);
        oldSemesterYear=true;
    });

    $('#import-course-section').click(function () {
        alert('test');
    });

    //TODO-nong ข้างล่างนี้ลงไปจะต้องถูกลบ
    // Async content loading
    $(".steps-async").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        titleTemplate: '<span class="number">#index#</span> #title#',
        labels: {
            finish: 'Submit'
        },
        onContentLoaded: function (event, currentIndex) {
            $(this).find('select.select').select2();

            $(this).find('select.select-simple').select2({
                minimumResultsForSearch: '-1'
            });

            $(this).find('.styled').uniform({
                radioClass: 'choice'
            });

            $(this).find('.file-styled').uniform({
                wrapperClass: 'bg-warning',
                fileButtonHtml: '<i class="icon-googleplus5"></i>'
            });
        },
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        }
    });


    // Saving wizard state
    $(".steps-state-saving").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        saveState: true,
        titleTemplate: '<span class="number">#index#</span> #title#',
        autoFocus: true,
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        }
    });


    // Specify custom starting step
    $(".steps-starting-step").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        startIndex: 2,
        titleTemplate: '<span class="number">#index#</span> #title#',
        autoFocus: true,
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        }
    });


    //
    // Wizard with validation
    //

    // Show form
    var form = $(".steps-validation").show();


    // Initialize wizard
    $(".steps-validation").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        titleTemplate: '<span class="number">#index#</span> #title#',
        autoFocus: true,
        onStepChanging: function (event, currentIndex, newIndex) {

            // Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex) {
                return true;
            }

            // Forbid next action on "Warning" step if the user is to young
            if (newIndex === 3 && Number($("#age-2").val()) < 18) {
                return false;
            }

            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex) {

                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }

            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },

        onStepChanged: function (event, currentIndex, priorIndex) {

            // Used to skip the "Warning" step if the user is old enough.
            if (currentIndex === 2 && Number($("#age-2").val()) >= 18) {
                form.steps("next");
            }

            // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
            if (currentIndex === 2 && priorIndex === 3) {
                form.steps("previous");
            }
        },

        onFinishing: function (event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },

        onFinished: function (event, currentIndex) {
            alert("Submitted!");
        }
    });


    // Initialize validation
    $(".steps-validation").validate({
        ignore: 'input[type=hidden], .select2-input',
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        errorPlacement: function(error, element) {
            if (element.parents('div').hasClass("checker") || element.parents('div').hasClass("choice") || element.parent().hasClass('bootstrap-switch-container') ) {
                if(element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                    error.appendTo( element.parent().parent().parent().parent() );
                }
                 else {
                    error.appendTo( element.parent().parent().parent().parent().parent() );
                }
            }
            else if (element.parents('div').hasClass('checkbox') || element.parents('div').hasClass('radio')) {
                error.appendTo( element.parent().parent().parent() );
            }
            else if (element.parents('label').hasClass('checkbox-inline') || element.parents('label').hasClass('radio-inline')) {
                error.appendTo( element.parent().parent() );
            }
            else if (element.parent().hasClass('uploader') || element.parents().hasClass('input-group')) {
                error.appendTo( element.parent().parent() );
            }
            else {
                error.insertAfter(element);
            }
        },
        rules: {
            email: {
                email: true
            }
        }
    });



    // Initialize plugins
    // ------------------------------

    // Select2 selects
    $('.select').select2();


    // Simple select without search
    $('.select-simple').select2({
        minimumResultsForSearch: '-1'
    });


    // Styled checkboxes and radios
    $('.styled').uniform({
        radioClass: 'choice'
    });


    // Styled file input
    $('.file-styled').uniform({
        wrapperClass: 'bg-warning',
        fileButtonHtml: '<i class="icon-googleplus5"></i>'
    });
    
});
