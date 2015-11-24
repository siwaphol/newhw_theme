<div class="modal fade" id="addFileModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">เพิ่มไฟล์</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal addFileForm" role="form">
          <div class="form-group">
            <label class="control-label col-sm-2" for="section">Section</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="section" id="section" placeholder="Enter course section (blank for all)">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="homeworkname">Name</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="homeworkname" id="homeworkname" placeholder="Ex. lab01_{id} ,lab01_{section}_{id}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="filetype">Type</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="filetype" id="filetype" placeholder="Choose file type">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="filedetail">Detail</label>
            <div class="col-sm-8">
              <textarea style="resize:none" class="form-control" name="filedetail" id="filedetail" rows="3" placeholder="Enter file detail" required></textarea>
            </div>
          </div>
          <div class="form-group">
              <label class="control-label col-sm-2" for="dueDate">Due Date</label>
                <div class='col-sm-8 input-group date clsDatePicker' id='datetimepicker1'>
                    <input type='text' class="form-control" name="dueDate" id="dueDate"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="acceptUntil">Accept Until</label>
              <div class='col-sm-8 input-group date clsDatePicker' id='datetimepicker2'>
                  <input type='text' class="form-control" name="acceptUntil" id="acceptUntil"/>
                  <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                  </span>
              </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addFileOK">ตกลง</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
            locale: 'en',
            format: 'DD/MM/YYYY LT',
            defaultDate: moment("11:59:00","hh:mm:ss")
        });
    });
    $(function () {
        $('#datetimepicker2').datetimepicker({
            locale: 'en',
            format: 'DD/MM/YYYY LT',
            defaultDate: moment("11:59:00","hh:mm:ss")
        });
    });
</script>
