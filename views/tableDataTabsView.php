<?php include "componenets/sectionHeader.html" ?>
<!-- START SECTION CONTENT -->
<div class="section-content">

  <div class="table-actions text-center" data-toggle="data">
    <button type="button" class="btn active" data-type="data">Browse</button>
    <button type="button" class="btn" data-type="structure">Structure</button>
  </div>

  <div class="dt-container" data-toggle="data">
    <?php include "componenets/datatables/tableData.html"; ?>
    <?php include "componenets/datatables/tableStructure.html"; ?>
  </div>

  <button id="modal-add" type="button" class="btn add-row-btn btn-fill green">
    <span>Add New Row</span>
    <i class="mdi mdi-plus-box"></i>
  </button>
</div>
<!-- END SECTION CONTENT -->
