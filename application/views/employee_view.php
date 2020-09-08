<!DOCTYPE html>
<html>
<head>
  <title>Task </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
  <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
  
</head>
<body>
  
<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      
      <button class="btn btn-success pull-right" style="margin-top:20px;" onclick="add_person()"><i class="glyphicon glyphicon-plus"></i> Add Employee</button>
      <h1>Treeview Employeee Listing</h1>
    </div>
    <div class="panel-body">
      <div class="col-md-8" id="treeview_json">
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">employee Form</h3>
      </div>
      <div class="modal-body form">
        <form id="form" method="post" action="employee/addemployee"  class="form-horizontal" >
          
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3"> Manager</label>
              <div class="col-md-9">
              <select id='emplist' class="form-control" name="parent">
              <option value="0" selected>Select Manager</option>
              </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Employee Name</label>
              <div class="col-md-9">
                <input name="name" placeholder="Employee Name" class="form-control" type="text">
              </div>             
            </div>  
          </div>
          <div class="modal-footer">
            <button type="submit" id="btnSave"  class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->

  <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
  
<script type="text/javascript">
$(document).ready(function(){
  
   var treeData;
   
   $.ajax({
        type: "GET",  
        url: "employee/getemp",
        dataType: "json",       
        success: function(response)  
        {
           initTree(response)
        }   
  });
    
  function initTree(treeData) {
    $('#treeview_json').treeview({data: treeData});
  }

  $.ajax({
        type: "GET",  
        url: "employee/getManager",
        dataType: "json",       
        success: function(response)  
        {
          console.log(response);
          var mySelect = $('#emplist');
          $.each(response, function(val, text) {
              mySelect.append(
                  $('<option></option>').val(response[val].id).text(response[val].name)
              );        
          });
        }
    });  
  });
</script>

<script type="text/javascript">
function add_person()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add Employee'); // Set Title to Bootstrap modal title
    }
   
</script>
   
</body>
</html>
