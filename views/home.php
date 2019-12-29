
<?php include "componenets/header.php" ?>

<!-- START SIDEBAR -->
<div id="ajx-permissions">
<div class="sidebar">

  <!-- FILTER PANEl -->
  <div class="filter-panel panel-item green" data-toggle="open">
    <ul class="list-unstyled list-inline float-lt">
      <li>
        <button type="button" class="btn hide" data-value="open">
          <i class="icon-big mdi mdi-arrow-up-drop-circle"></i>
        </button>
        <button type="button" class="btn hide" data-value="close">
          <i class="icon-big mdi mdi-arrow-down-drop-circle"></i>
        </button>
      </li>
      <li>Databases (10)</li>
    </ul>
    <button id="filter-button" type="button" class="btn float-rt focus">
      <i class="icon-big mdi mdi-filter"></i>
    </button>
    <div class="clearfix"></div>
  </div>
  <!-- END FILTER PANEl -->

  <!-- START SIDEBAR ITEMS -->
  <div class="sidebar-databases-items">


  </div>
  <!-- END SIDEBAR ITEMS -->

  <!-- SIDEBAR LOADER -->
  <div class="loader-sidebar hide"></div>
  <!-- SIDEBAR LOADER -->

  <!-- TOGGLE LOGS PANEL BTN -->
  <div class="toggle-logs-section text-center">
    <button id="toggle-logs-btn" type="button" class="btn" data-toggle="close">
      <span>show logs</span>
      <i class="icon-big mdi mdi-arrow-down-drop-circle open hide"></i>
      <i class="icon-big mdi mdi-arrow-up-drop-circle close hide"></i>
    </button>
  </div>
  <!-- TOGGLE LOGS PANEL BTN -->
</div>
<!-- END SIDEBAR -->

<!-- START FULL CONTAINER -->
<div class="full-container">
  <div class="loader-straight hide">
    <div class="loader-content">
    </div>
  </div>

  <!-- START INNER CONTAINER -->
  <div class="inner-container">

    <!-- START SECTION CONTAINER -->
      <div id="ajx-content" class="section-container text-color">

        <h1 class="no-selected text-center">no database table selected</h1>

      </div>
    <!-- END SECTION CONTAINER -->

    <?php include "componenets/tableEdit.html" ?>

  </div>
  <!-- END INNER CONTAINER -->

  <!-- START LOGS PANEL -->
  <div class="logs-panel hide" data-toggle="close">
    <div class="panel-header">
      <div class="title float-lt">
        <i class="mdi mdi-library-books"></i>
        <span class="info text-color">Table Name Logs</span>
        <span class="logs-count">2000 <span>Logs Founded</span></span>
      </div>
      <div class="panel-actions float-rt">
        <i class="mdi btn icon-big mdi-arrow-expand"></i>
        <i class="mdi btn icon-big mdi-arrow-down-box"></i>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="panel-content">
      <div class="log-item" data-type="delete">
        <span class="badge"></span>
        <div class="log-item-content">
          delete
        </div>
      </div>
      <div class="log-item" data-type="update">
        <span class="badge"></span>
        <div class="log-item-content">
          update
        </div>
      </div>
      <div class="log-item" data-type="insert">
        <span class="badge"></span>
        <div class="log-item-content">
          insert
        </div>
      </div>
      <div class="log-item" data-type="delete">
        <span class="badge"></span>
        <div class="log-item-content">
          delete
        </div>
      </div>
    </div>
  </div>
  <!-- END LOGS PANEL -->

  <!-- START FOOTER -->
  <div class="footer shadow-top">
    <span class="copyrights">Databases Manager Copyrights 2020 <i class="mdi mdi-copyright"></i></span>
  </div>
  <!-- END FOOTER -->
</div>
</div>
<!-- END FULL CONTAINER -->
