<div class="modal fade" id="dateTimePickerModal" tabindex="-1" role="dialog" aria-labelledby="datetimepicker" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div style="overflow:hidden;">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div id="dtpicker_modal"></div>
                    </div>
                </div>
            </div>
            {{--<script type="text/javascript">--}}
                {{--$(function () {--}}
                    {{--var DTmodal = $('#dtpicker_modal').datetimepicker({--}}
                        {{--inline: true,--}}
                        {{--sideBySide: true,--}}
                        {{--locale: 'en',--}}
                        {{--format: 'DD/MM/YYYY HH:mm',--}}
                        {{--defaultDate: moment("23:59:00","hh:mm:ss")--}}
                    {{--});--}}
                {{--});--}}
            {{--</script>--}}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" id="DT_OK_button">OK</button>
      </div>
    </div>
  </div>
</div>