<?php include "componenets/sectionHeader.html" ?>
<!-- START SECTION CONTENT -->
<div class="section-content">

  <div class="table-actions text-center" data-toggle="data">
    <button type="button" class="btn active" data-type="data">Browse</button>
    <button type="button" class="btn" data-type="structure">Structure</button>
  </div>

  <div class="dt-container" data-toggle="data">
  <?php include "componenets/tableData.html" ?>
  <?php include "componenets/tableStructure.html" ?>
  </div>

    <style>
.dt-container[data-toggle='data'] #table-structure_wrapper{ display: none }
    </style>

</div>
<!-- END SECTION CONTENT -->
