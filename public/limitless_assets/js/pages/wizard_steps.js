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
var selectedSemester = null;
var selectedYear = null;
var tableLoaded = false;
var oldSemesterYear = true;
var isCourseSectionUpdated = false;
var secondStepFirstRun = false;
var onLoadingState = false;
var courseSectionTable = null;
var $courseSection = $('#course-section-list');

$(function() {

    function customSleep(miliseconds) {
           var currentTime = new Date().getTime();

       while (currentTime + miliseconds >= new Date().getTime()) {
       }
    }

    var ajaxManager = (function() {
         var requests = [];

         return {
            addReq:  function(opt) {
                requests.push(opt);
            },
            removeReq:  function(opt) {
                if( $.inArray(opt, requests) > -1 )
                    requests.splice($.inArray(opt, requests), 1);
            },
            run: function() {
                var self = this,
                    oriSuc;

                if( requests.length ) {
                    oriSuc = requests[0].complete;

                    requests[0].complete = function() {
                         if( typeof(oriSuc) === 'function' ) oriSuc();
                         requests.shift();
                         self.run.apply(self, []);
                    };   

                    $.ajax(requests[0]);
                } else {
                  self.tid = setTimeout(function() {
                     self.run.apply(self, []);
                  }, 200); //Set เพื่อปรับเวลาที่หยุดระหว่างแต่ละ ajax call
                }
            },
            stop:  function() {
                requests = [];
                clearTimeout(this.tid);
            }
         };
    }());

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
    // Course Section Table Initialization
    function courseSectionTableInit (semester, year) {
        courseSectionTable = $('#course-section-list').DataTable({
            "bDestroy": true,
            "processing": true,
            "scrollX": true,
            "ajax": {
                url: getAllCourseSectionURL,
                data: {"semester": selectedSemester, "year": selectedYear}
                ,error: function(data){
                    swal({
                        title: "เกิดข้อผิดพลาด",
                        text: "ไม่สามารถดึงข้อมูล course และ section จากเว็บสำนักทะเบียน",
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
                    return data.length==0?'<p>Not found</p>':(data.firstname_en+' '+data.lastname_en);
                }},
                { "data": "teacher"
                    ,"render": function ( data, type, full, meta) {
                    return data.length==0?'<p>Not found</p>':(data.firstname_th+' '+data.lastname_th);
                }},
                { "data": "teacher"
                    ,"render": function ( data, type, full, meta) {
                    // TODO-nong ใช้ตัวแปร full เพิ่ม id ให้กับแต่ละ row ของ column นี้เพื่อให้มี spinner เวลาส่งข้อมูลขึ้นแล้วเซฟลงดาต้าเบส ถ้าสำเร็จมี success span
                    return data.length==0?'<span class="label label-danger">Not Import</span>':'';
                }},
                { "data": "teacher"
                    ,"render": function ( data, type, full, meta) {
                    // TODO-nong ถ้าสร้างไม่สำเร็จให้ขึ้นข้อความด้วย
                    return data.length==0?'No teacher found or only "Staff" found':'';
                }}
            ],
            "rowCallback": function (row, data, index) {
                if(data.skip){
                    $('td', row).css('background-color', 'rgba(255, 0, 0, 0.50)');
                }else{
                    $('td', row).css('background-color', 'transparent');
                }

                if(data.success==0){
                    $(row).find('td').eq(5).html('<span class="label label-success">Success</span>');
                }else if(data.success==1){
                    $(row).find('td').eq(5).html('<span class="label label-warning">Duplicate</span>');
                }else if(data.success==2){
                    $(row).find('td').eq(5).html('<span class="label label-danger">Import Fail</span>');
                }else if(data.loading==true){
                    $(row).find('td').eq(5).html('<img src="'+spinGifPath+'">');
                }
            }
        })
        .on( 'init.dt', function () {
            console.log( 'Table initialisation complete: '+new Date().getTime() );
            tableLoaded = true;
        } );
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

            if(onLoadingState){
                return false;
            }

            if(newSemester !== selectedSemester || newYear !== selectedYear) {
                tableLoaded = false;
                isCourseSectionUpdated = false
            }
            selectedSemester = newSemester;
            selectedYear = newYear;

            if(newIndex == 1 && !tableLoaded){
                if(secondStepFirstRun){
                    $('#course-section-list').dataTable().fnDestroy();
                    courseSectionTable = null;
                }
                secondStepFirstRun = true;

                // show course and section list from autoajax1 before insert or update
                courseSectionTableInit(selectedSemester, selectedYear);
            }
            // TODO-nong เพื่อป้องกันเมื่อบันทึกข้อมูลลงดาต้าเบส แล้ว user กลับมาเปลี่ยน semester หรือ year
            if(newIndex == 0 && isCourseSectionUpdated){
                return false;
            }
            // TODO-nong โหลดทุก course และ section เข้าไปยัง database
            if((newIndex == 2 || newIndex ==3) && tableLoaded && !isCourseSectionUpdated){
                var notSkipCourseSection = $.grep(courseSectionTable.data(), function (element, index) {
                    return element.skip===false;
                });
                var allRequests = notSkipCourseSection.length;
                var counter = 0;
                swal({
                    title:'Please wait while importing courses'
                    ,imageUrl: bigSpinner
                    ,showConfirmButton:false
                    ,showCancelButton:false
                    ,allowOutsideClick: false
                    ,allowEscapeKey: false
                    ,closeOnConfirm:false
                    ,closeOnCancel: false
                });
                console.log('allRequests : ', allRequests);
                // start ajaxManager
                ajaxManager.run();
                onLoadingState = true;
                notSkipCourseSection.forEach(function (element) {
                    element.semester = selectedSemester;
                    element.year = selectedYear;
                    var elementAsJsonString = JSON.stringify(element);
                    var currentIdAndSection = element.id + ' ,' + element.section;
                    //use ajaxManager to throttle between each ajax call, preventing unexpected error

                     ajaxManager.addReq({
                           url: storeEachCourseSection,
                            data: elementAsJsonString,
                            // dataType: 'json',
                            contentType: 'application/json',
                            type: 'post',
                            success: function (data) {
                                counter++;
                                console.log('from success ajax: ',data);
                                courseSectionTable.row(element.virtual_id - 1).data().success = parseInt(data.overview.success[0]);
                                courseSectionTable.draw(false);
                            }
                            ,beforeSend: function () {
                                console.log('beforeSend virtual id: ', element.virtual_id);
                                courseSectionTable.row(element.virtual_id - 1).data().loading = true;
                                courseSectionTable.draw(false);
                            }
                            ,error: function (data) {
                                counter++;
                                console.log(' Error at ',currentIdAndSection);
                                courseSectionTable.row(element.virtual_id - 1).data().success = 2;
                                courseSectionTable.draw(false);
                            }
                            ,complete: function () {
                                allRequests--;
                                if(allRequests<1){
                                    console.log('last course section');
                                    // stop ajaxManager after push all requests to server
                                    ajaxManager.stop();
                                    isCourseSectionUpdated = true;
                                    onLoadingState = false;
                                    swal('Import all available course and section complete');
                                }
                            }
                       });
                });
                console.log("Waiting for course section insert to complete...");
                return false;
            }

            // TODO-nong Add import functionality here (see if we can change Next step text from here)
            //console.log(this.find(""));

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
       onStepChanged: function (event, currentIndex, priorIndex) {

            if (currentIndex === 2 && priorIndex === 3) {
                //call get student data
                var notSkipCourseSection = $.grep(courseSectionTable.data(), function (element, index) {
                    //TODO-nong dont forget to filter for unique course and section
                    return element.skip===false;
                });
                var counter = 0;            
                notSkipCourseSection.forEach(function (element) {
                    element.semester = selectedSemester;
                    element.year = selectedYear;
                    var elementAsJsonString = JSON.stringify(element);

                    ajaxManager.addReq({
                       url: 'getStudentExcelFilesForeachCourseSection',
                        data: elementAsJsonString,
                        // dataType: 'json',
                        contentType: 'application/json',
                        type: 'post',
                        success: function (data) {
                            counter++;

                        }
                        ,beforeSend: function () {

                        }
                        ,error: function (data) {
                            counter++;

                        }
                        ,complete: function () {
                            allRequests--;
                            if(allRequests<1){
                                console.log('last course section\'s student list');
                                // stop ajaxManager after push all requests to server
                                ajaxManager.stop();
                                swal('Import all available students complete');
                            }
                        }
                       });
                });
            }else{ // พบว่ามีปัญหาเกิดขึ้นกับกระบวนการทำงาน
                form.steps("previous");
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
        courseSectionTable.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var data = this.data();

            // TODO-nong we will call inport autoajax2 from here to insert course and section to tables
            //if(data.skip)
            //{
            //    console.log(data);
            //}
        });
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
