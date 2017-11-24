 <!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
 <script src="<?php echo base_url(); ?>assets/admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
 -->
<!-- include summernote css/js-->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>


	<div class="col-md-7">
 		<div class="box box-warning">
 			<form method="POST">
	            <div class="box-header">
	              <h3 class="box-title"><?php if(intval($page['idpage']) == 0){ echo 'New Page'; } else { echo 'Update Page'; } ?></h3>           
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body pad">
	              	<input type="hidden" name="idpage" value="<?php echo $page['idpage']; ?>">
	              	<input type="text" required name="title" class="form-control" placeholder="Title" value="<?php echo $page['title']; ?>">
	              	<br>
	                <textarea  name="text" class="textarea editor" id="editor" required  placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $page["text"]; ?></textarea>
	                
	              	<!--<br>
	              	<div id="f" style="color:rgba(0,0,0,.7); font-size:20px;text-align: center; line-height: 80px;vertical-align: middle; cursor:pointer;width:100%;height:80px;background-color: rgba(0,0,0,.1);border: 1px  dotted rgba(0,0,0,.2)">
	              		Feature Image
	              	</div>
	              	<input required type="file" accept="image/*" name="image" class="form-control hide" placeholder="asdasd" id="image">
	              	-->
	            </div>
	            <div class="box-footer">
	            <button type="submit" class="btn btn-success">Save Page</button>
	            <a  href="<?php echo base_url(); ?>admin/pages" class="btn btn-warning pull-right">New Page</a>
	            </div>
	         </form>
         </div>
    </div>
	<div class="col-md-5">
		<div class="box">
 			 <div class="box-header">
	              <h3 class="box-title">Pages</h3>           
	          </div>
	          <div class="box-body pad">
	          	<table class="table">
	          		<?php foreach ($pages as $key => $value) {
	          			?>
	          			<tr>
	          				<td><?php echo $value['title']; ?></td>
	          				<td style="width:90px">
	          					<a href="?idpage=<?php echo $value["idpage"]; ?>" class="btn btn-small btn-xs btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></a>
	          					<a href="?delete=<?php echo $value["idpage"]; ?>" class="btn btn-small btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
	          				</td>
	          			</tr>
	          			<?php
	          		}
	          		?>
	          	</table>
	          </div>
	</div>

	
 		<div class="box box-success">
 			<form method="POST">
	            <div class="box-header">
	              <h3 class="box-title">Static Pages</h3>           
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body pad">
	             	<div class="form-group">
		            	<label>Latest Sites</label> 
		              	<select class="form-control" name="page_last_sites" required >	              				              				              		
		              		<option <?php if(config_item("page_last_sites") =='2'){ echo 'selected'; } ?> value="2">Hide</option>
		              		<option <?php if(config_item("page_last_sites") =='1'){ echo 'selected'; } ?>  value="1">Show</option>
		              	</select>
		            </div>

		            <div class="form-group">
		            	<label>Top Sites</label> 
		              	<select class="form-control" name="page_top_sites" required >	        		              		
		              		<option <?php if(config_item("page_top_sites") =='2'){ echo 'selected'; } ?> value="2">Hide</option>
		              		<option <?php if(config_item("page_top_sites") =='1'){ echo 'selected'; } ?>  value="1">Show</option>		              		
		              	</select>
		            </div>

		             <div class="form-group">
		            	<label>Contact Form</label> 
		              	<select class="form-control" name="page_contact_form" required >			              		
		              		<option <?php if(config_item("page_contact_form") =='2'){ echo 'selected'; } ?> value="2">Hide</option>
		              		<option <?php if(config_item("page_contact_form") =='1'){ echo 'selected'; } ?>  value="1">Show</option>		              		
		              	</select>
		            </div>



	            </div>
	            <div class="box-footer">
	            <button type="submit" class="btn btn-success">Update</button>	            
	            </div>
	         </form>
         </div>
 


</div>
 <script>
  $(function () {    

  $('#editor').summernote({
	height: 300,                 // set editor height
    focus: true                  // set focus to editable area after initializing summernote

  });

/*
    editor.addCommand("mySimpleCommand", { // create named command
	    exec: function(edt) {
	        editor.insertText("[artist id=?]");
	    }
	});

	editor.ui.addButton('btnArtist', { // add new button and bind our command
	    label: "Add Artist",
	    command: 'mySimpleCommand',
	    toolbar: 'insert',
	    icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
	});

	editor.ui.addButton('btnAlbum', { // add new button and bind our command
	    label: "Add Artist",
	    command: 'mySimpleCommand',
	    toolbar: 'insert',
	    icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
	});


	editor.ui.addButton('btnAlbum', { // add new button and bind our command
	    label: "Add Artist",
	    command: 'mySimpleCommand',
	    toolbar: 'insert',
	    icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
	});*/


    //$(".editor").wysihtml5();
    $("#f").on('click', function(event) {
    	event.preventDefault();
    	$("#image").click();
    });
    $("#image").on('change',  function(event) {
    	event.preventDefault();
    	$("#f").html($(this).val());
    });
  });
</script>