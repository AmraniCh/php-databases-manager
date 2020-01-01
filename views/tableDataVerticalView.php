<?php include "componenets/sectionHeader.html" ?>
<!-- START SECTION CONTENT -->
<div class="section-content">

  <div class="btn toggle-table-btn" data-type="data" data-toggle="open">
    <i class="mdi mdi-arrow-up-drop-circle open hide"></i>
    <i class="mdi mdi-arrow-down-drop-circle close hide"></i>
    <span>Data</span>
  </div>

  <?php include "componenets/datatables/tableData.html" ?>

  <div class="btn toggle-table-btn" data-type="structure" data-toggle="open">
    <i class="mdi mdi-arrow-up-drop-circle open hide"></i>
    <i class="mdi mdi-arrow-down-drop-circle close hide"></i>
    <span>Structure</span>
  </div>

  <?php include "componenets/datatables/tableStructure.html" ?>

</div>
<!-- END SECTION CONTENT -->
