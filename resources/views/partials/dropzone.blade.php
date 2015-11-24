<div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 class="modal-title">Upload File</h4>
	  </div>
	  <div class="modal-body">
			<div class="dropzone" id="dropzoneFileUpload">

			</div>
	  </div>
	  <div class="modal-footer">
		  {{--<a type="button" class="btn btn-default close">Cancel</a>--}}
	  </div>
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">

	Dropzone.autoDiscover = false;
	 var myDropzone = new Dropzone("div#dropzoneFileUpload", {

         url: _uploadURL,
		 params: {
			_token: token,
			course_id: _course_id,
			section: _section
		  },
         autoQueue: false,
        init: function () {
            this.on("sending", function(file, xhr, data) {
                data.append("student_id", student_id);
                data.append("homework_id", homework_id);
                console.log(data);
            });
			//Check if file name is correct
            this.on("addedfile", function (file) {
				var filename = $('.student-button-selected').attr('data-accept-filename');
                var filetype_array = $('.student-button-selected').attr('data-accept-filetype').split(',');
				var filename_array = [];
                if(filetype_array.length > 1){
                    filename_array = filetype_array.map(function (obj) {
                        return filename + obj;
                    });
                }else{
                    filename_array = [filename];
                }
//                console.log(filename_array);
                if(filename_array.indexOf(file.name) >= 0){
                    file.status = Dropzone.ADDED;
                    file.accepted = true;
                    this.enqueueFile(file);
				}else{
                    file.status = Dropzone.CANCELED;
                    file.previewElement.classList.add("dz-error");
                    _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                    _ref[0].textContent = "File name is incorrect.";
				}
            });
        }
	 });
	 Dropzone.options.myAwesomeDropzone = {
		paramName: "file", // The name that will be used to transfer the file
		maxFilesize: 5, // MB
		addRemoveLinks: true
	  };
 </script>